<?php
  include("session-customer.php");

  if (isset($_POST['btnDelete']))
  {
    $customer_id=$_SESSION["customer_id"]; 
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $delete_query="DELETE FROM cart_table WHERE cart_id='$cart_id'";
    $result = mysqli_query($conn, $delete_query) or trigger_error("Query Failed! SQL: $delete_query - Error: ".mysqli_error($conn), E_USER_ERROR);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Products In Cart | SVS GlobalBiz Solution</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../page-template/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../page-template/vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../page-template/style.css">
  <link rel="stylesheet" href="../style.css">
  <!-- endinject -->
  <link rel="icon" type="image/png" href="../images\favicon.ico" />
  <style>
  .nav-pills .nav-link.active, .nav-pills .show > .nav-link 
  {
    color: #fff;
    background-color: #CFB53B !important;
  }
  .sidebar .nav .nav-item.active > .nav-link i, .sidebar .nav .nav-item.active > .nav-link .menu-title, .sidebar .nav .nav-item.active > .nav-link .menu-arrow {
    color:#000;
  }
  </style>
</head>
<body>
  <div class="container-scroller">
    <!-- heder -->
    <?php include("header-customer.php"); ?>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- sidebar -->
     <?php include("sidebar-customer.php"); ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h4 class="font-weight-bold mb-0">Products in Cart</h4>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link text-dark active" id="pills-by-items-tab" data-toggle="pill" href="#pills-by-items" role="tab" aria-controls="pills-by-items" aria-selected="true">Checkout by items</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark" id="pills-all-items-tab" data-toggle="pill" href="#pills-all-items" role="tab" aria-controls="pills-all-items" aria-selected="false">Checkout all items</a>
                  </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-by-items" role="tabpanel" aria-labelledby="pills-by-items-tab">
                    <div class="table-responsive pt-3">
                      <table class="table table-bordered text-center">
                          <thead>
                              <tr>
                                  <th style="width:600px;">
                                      Product
                                  </th>
                                  <th style="width:50px;">
                                      Quantity
                                  </th>
                                  <th style="width:150px;">
                                      Total Price (RM)
                                  </th>
                                  <th>
                                      Added Date
                                  </th>
                                  <th style="width:120px;" colspan="2">
                                    Action
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php
                              //Selecting the information of the products that are added to cart
                              $customer_id=$_SESSION["customer_id"];
                              $sql = "SELECT * FROM product_info_table  
                                      LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                      LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id
                                      LEFT JOIN cart_table ON product_info_table.product_id = cart_table.product_id
                                      WHERE customer_id='$customer_id'";
                              $result = mysqli_query($conn, $sql);
                              
                              if (mysqli_num_rows($result) > 0) 
                              {
                                  // output data of each row
                                  while($row = mysqli_fetch_assoc($result)) 
                                  {
                                      $cart_id = $row["cart_id"];
                                      $category = $row["product_category"];
                                      $category_id = $row["category_id"];
                                      $brand = $row["brand_name"];  
                                      $brand_id = $row["brand_id"];
                                      $product_id = $row["product_id"];
                                      $product_name = $row["product_name"];
                                      $total_price = number_format($row["total_price"],2);
                                      $product_desc = $row["product_desc"];
                                      $product_img = $row["product_img"];
                                      $added_date = $row["added_date"];
                                      $quantity=$row["quantity"];
                                      //$total_price = number_format($row['SUM(product_price)'], 2);

                                      echo
                                      '
                                      <tr>
                                          <td style="text-align:center;">
                                            <b>'.$product_name.'</b><br>
                                            <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:200px; height:200px;" />
                                            <div><a href="../product-details.php?product_id='.$row['product_id'].'">View</a></div>
                                          </td>
                                          <td>
                                          '.$quantity.' <br>
                                          <a href="edit-quantity-in-cart.php?cart_id='.$row['cart_id'].'" class="btn btn-info btn-xs text-light">
                                            Edit
                                          </a>
                                          </td>
                                          <td>'.$total_price.'</td>
                                          <td>'.$added_date.'</td>
                                          <td align="center">
                                              <form method="POST" action="" name="deleteForm" id="deleteForm">
                                                  <input type="hidden" value="' . $cart_id . '" name="cart_id">
                                                  <button type="submit" class="btn btn-block btn-danger btn-xs" style="width:120px;" name="btnDelete" id="' . $cart_id . '" title="Delete product">Delete</button>
                                              </form>
                                              <br>
                                              <form method="POST" name="checkoutForm" id="checkoutForm">
                                                <input type="hidden" value="' . $cart_id . '" name="cart_id">
                                                <a href="checkout-page-single.php?cart_id='.$row['cart_id'].'" class="btn btn-block btn-xs" style="color:white; background-color:orange;text-decoration:none;width:120px;" name="btnCheckout" id="' . $cart_id . '" title="Checkout">Checkout</a>
                                              </form>
                                          </td>
                                      </tr>
                                      ';
                                  }
                              } 
                              else 
                              {
                                  echo
                                  '
                                      <tr>
                                      <td colspan="9">
                                          <p style="text-align:center">No result found</p>
                                      </td>
                                      </tr>
                                  ';
                              }
                          ?>
                          </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="pills-all-items" role="tabpanel" aria-labelledby="pills-all-items-tab">
                  <div class="table-responsive pt-3">
                      <table class="table table-bordered text-center">
                          <thead>
                              <tr>
                                  <th style="width:800px;">
                                      Product Name
                                  </th>
                                  <th >
                                      Quantity
                                  </th>
                                  <th style="width:120px;">
                                      Total Price (RM)
                                  </th>
                                  <th style="width:120px;" colspan="2">
                                      Action
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php
                            //Selecting the information of the products that are added to cart
                            $customer_id=$_SESSION["customer_id"];
                            $sql = "SELECT * FROM product_info_table  
                                    LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                    LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id
                                    LEFT JOIN cart_table ON product_info_table.product_id = cart_table.product_id
                                    WHERE customer_id='$customer_id'";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) 
                            {
                              // output data of each row
                              while($row = mysqli_fetch_assoc($result)) 
                              {
                                  $cart_id = $row["cart_id"];
                                  $category = $row["product_category"];
                                  $category_id = $row["category_id"];
                                  $brand = $row["brand_name"];  
                                  $brand_id = $row["brand_id"];
                                  $product_id = $row["product_id"];
                                  $product_name = $row["product_name"];
                                  $total_price = number_format($row["total_price"],2);
                                  $product_desc = $row["product_desc"];
                                  $product_img = $row["product_img"];
                                  $added_date = $row["added_date"];
                                  $quantity=$row["quantity"];

                                  echo
                                  '
                                  <tr>
                                    <td style="text-align:center;">
                                    <b>'.$product_name.'</b> 
                                      <br>
                                      <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:200px; height:200px;" />
                                      <div><a href="../product-details.php?product_id='.$row['product_id'].'">View</a></div>
                                    </td>
                                    <td>
                                    '.$quantity.' <br>
                                    <a href="edit-quantity-in-cart.php?cart_id='.$row['cart_id'].'" class="btn btn-info btn-xs text-light">
                                      Edit
                                    </a>
                                    </td>
                                    <td>'.$total_price.' </td>
                                    <td>
                                        <form method="POST" action="" name="deleteForm2" id="deleteForm2">
                                            <input type="hidden" value="' . $cart_id . '" name="cart_id">
                                            <button type="submit" class="btn btn-block btn-danger btn-xs" name="btnDelete" id="' . $cart_id . '" title="Delete product">Delete</button>
                                        </form>
                                        <br>
                                    </td>
                                  </tr>  
                                  ';
                              }
                            }
                            else 
                            {
                                echo
                                '
                                    <tr>
                                    <td colspan="4">
                                        <p style="text-align:center">No result found</p>
                                    </td>
                                    </tr>
                                ';
                            }

                            //Selecting the information of the products that are added to cart
                            $customer_id=$_SESSION["customer_id"];
                            $sql = "SELECT *, SUM(total_price) FROM product_info_table  
                                    LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                    LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id
                                    LEFT JOIN cart_table ON product_info_table.product_id = cart_table.product_id
                                    WHERE customer_id='$customer_id'";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) 
                            {
                              // output data of each row
                              while($row = mysqli_fetch_assoc($result)) 
                              {
                                  $cart_id = $row["cart_id"];
                                  $category = $row["product_category"];
                                  $category_id = $row["category_id"];
                                  $brand = $row["brand_name"];  
                                  $brand_id = $row["brand_id"];
                                  $product_id = $row["product_id"];
                                  $product_name = $row["product_name"];
                                  $total_price = number_format($row["total_price"],2);
                                  $product_desc = $row["product_desc"];
                                  $product_img = $row["product_img"];
                                  $added_date = $row["added_date"];
                                  $quantity=$row["quantity"];
                                  $checkout_date = date("Y-m-d");
                                  $overall_price = number_format($row['SUM(total_price)'], 2);

                                  echo
                                  '  
                                    <tr style="text-align:right;">
                                      <td colspan="4">
                                        <b>Total Price for All Items (RM):</b> '.$overall_price.' <br>
                                      </td>
                                    </tr>
                                    <tr style="text-align:right;">
                                      <td colspan="4">
                                        <div align="right">
                                        <form method="POST" name="checkoutForm" id="checkoutForm">
                                          <input type="hidden" value="' . $cart_id . '" name="cart_id">
                                          <a href="checkout-page-all.php?customer_id='.$_SESSION['customer_id'].'" class="btn btn-block btn-xs" style="color:white; background-color:orange;text-decoration:none;width:120px;" name="btnCheckout" id="' . $cart_id . '" title="Checkout">Checkout</a>
                                        </form>
                                        </div>
                                      </td>
                                    </tr>
                                  ';
                              }      
                            }
                            else
                            {
                              echo '';
                            }
                          ?>
                          </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                  <!-- <div class="table-responsive pt-3">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th style="width:600px;">
                                    Product
                                </th>
                                <th >
                                    Price (RM)
                                </th>
                                <th style="width:20px;">
                                    Quantity
                                </th>
                                <th>
                                    Added Date
                                </th>
                                <th style="width:120px;" colspan="2">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            //Selecting the information of the products that are added to cart
                            $customer_id=$_SESSION["customer_id"];
                            $sql = "SELECT * FROM product_info_table  
                                    LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                    LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id
                                    LEFT JOIN cart_table ON product_info_table.product_id = cart_table.product_id
                                    WHERE customer_id='$customer_id'";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) 
                            {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) 
                                {
                                    $category = $row["product_category"];
                                    $category_id = $row["category_id"];
                                    $brand = $row["brand_name"];  
                                    $brand_id = $row["brand_id"];
                                    $product_id = $row["product_id"];
                                    $product_name = $row["product_name"];
                                    $product_price = $row["product_price"];
                                    $product_desc = $row["product_desc"];
                                    $product_img = $row["product_img"];
                                    $added_date = $row["added_date"];
                                    $quantity=$row["quantity"];
                                    //$total_price = number_format($row['SUM(product_price)'], 2);

                                    echo
                                    '
                                    <tr>
                                        <td style="text-align:center;">
                                            '.$product_name.' <br>
                                            <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:200px; height:200px;" />
                                            <div><a href="../product-details.php?product_id='.$row['product_id'].'">View</a></div>
                                        </td>
                                        <td>'.$product_price.'</td>
                                        <td>'.$quantity.'</td>
                                        <td>'.$added_date.'</td>
                                        <td>
                                            <form method="POST" action="" name="deleteForm" id="deleteForm">
                                                <input type="hidden" value="' . $product_id . '" name="product_id">
                                                <button type="submit" class="btn btn-block btn-danger btn-xs" name="btnDelete" id="' . $product_id . '" title="Delete product">Delete</button>
                                            </form>
                                            <br>
                                            <form method="POST" name="checkoutForm" id="checkoutForm">
                                            <input type="hidden" value="' . $product_id . '" name="product_id">
                                            <button type="submit" class="btn btn-block btn-xs" style="color:white; background-color:orange;" name="btnCheckout" id="' . $product_id . '" title="Checkout">Checkout</button>
                                            </form>
                                        </td>
                                    </tr>
                                    ';
                                }
                            } 
                            else 
                            {
                                echo
                                '
                                    <tr>
                                    <td colspan="9">
                                        <p style="text-align:center">No result found</p>
                                    </td>
                                    </tr>
                                ';
                            }
                        ?>
                        </tbody>
                    </table>
                  </div> -->
                </div>
              </div>
            </div> 
          </div>
         </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include("../page-template/footer.php"); ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../page-template/vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="../page-template/vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../page-template/js/off-canvas.js"></script>
  <script src="../page-template/js/hoverable-collapse.js"></script>
  <script src="../page-template/js/template.js"></script>
  <script src="../page-template/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../page-template/js/dashboard.js"></script>
  <script>
    $('#deleteForm').submit(function() {  
        return confirm("Are you sure you want to delete this product from the cart?");
    }); 
    $('#deleteForm2').submit(function() {  
        return confirm("Are you sure you want to delete this product from the cart?");
    });  
  </script>
  <!-- End custom js for this page-->
</body>

</html>


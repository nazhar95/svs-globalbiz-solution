<?php
  include("session-customer.php");

  if (isset($_POST['btnUpdate']))
  {
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $new_quantity = mysqli_real_escape_string($conn, $_POST['new_quantity']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $new_total_price=$new_quantity*$product_price;
    $update_query="UPDATE cart_table SET quantity='$new_quantity', total_price='$new_total_price' WHERE cart_id='$cart_id'";
    $result = mysqli_query($conn, $update_query) or trigger_error("Query Failed! SQL: $update_query - Error: ".mysqli_error($conn), E_USER_ERROR);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit Product Quantity In Cart | SVS GlobalBiz Solution</title>
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
                  <h4 class="font-weight-bold mb-0">Edit Product Quantity in Cart</h4>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th style="width:600px;text-align:left;">
                                    Product Information
                                </th>
                                <th style="width:120px;">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            //Selecting the information of the products that are added to cart
                            $customer_id=$_SESSION["customer_id"];
                            $cart_id = $_GET['cart_id'];
                            $sql = "SELECT * FROM product_info_table  
                                    LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                    LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id
                                    LEFT JOIN cart_table ON product_info_table.product_id = cart_table.product_id
                                    WHERE cart_id='$cart_id'";
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
                                    $product_price = $row["product_price"];
                                    $product_desc = $row["product_desc"];
                                    $product_img = $row["product_img"];
                                    $added_date = $row["added_date"];
                                    $quantity=$row["quantity"];
                                    $total_price = number_format($row["total_price"],2);

                                    echo
                                    '
                                    <tr>
                                        <td style="text-align:left;">
                                          <ul>
                                            <li><b>Product Name:</b> '.$product_name.'</li>
                                            <li><b>Product Price:</b> '.$product_price.'</li>
                                            <li><b>Previous Quantity Added</b>: '.$quantity.'</li>
                                            <li><b>Total Price (RM)</b>: '.$total_price.'</li>
                                          </ul>  
                                            <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:200px; height:200px;" />
                                        </td>
                                        <td>
                                            <form method="POST" action="" name="updateForm" id="updateForm">
                                                <input class="form-control" type="number" name="new_quantity" min="1" max="'.$row['stock'].'" required>
                                                <input type="hidden" value="' . $cart_id . '" name="cart_id">
                                                <input type="hidden" value="' . $product_price . '" name="product_price">
                                                <br>
                                                <button type="submit" class="btn btn-block btn-dark btn-xs" name="btnUpdate" id="' . $cart_id . '" title="Update product quantity">Update Quantity</button>
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
                                    <td colspan="2">
                                        <p style="text-align:center">No result found</p>
                                    </td>
                                    </tr>
                                ';
                            }
                        ?>
                        </tbody>
                    </table>
                  </div>
                  <br>
                  <a href="products-in-cart.php"><button type="button" class="btn btn-warning text-light">Back</button></a> 
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
    $('#updateForm').submit(function() {  
        return confirm("Are you sure you want to update the quantity for this product?");
    });  
  </script>
  <!-- End custom js for this page-->
</body>

</html>


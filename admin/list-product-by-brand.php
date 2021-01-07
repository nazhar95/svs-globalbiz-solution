<?php
  include("session-admin.php");

  error_reporting(0);

  if (isset($_POST['btnDelete']))
  { 
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $delete_query="DELETE FROM product_info_table WHERE product_id='$product_id'";
    $result = mysqli_query($conn, $delete_query) or trigger_error("Query Failed! SQL: $delete_query - Error: ".mysqli_error($conn), E_USER_ERROR);

    echo 
    (
      "<script language='JAVASCRIPT'>
          window.alert('Product successfully deleted.');
          window.location.href='list-product-by-brand.php';
      </script>"
    );
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>List Product By Brand Page | SVS GlobalBiz Solution</title>
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
    <?php include("header-admin.php"); ?>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- sidebar -->
     <?php include("sidebar-admin.php"); ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h4 class="font-weight-bold mb-0">List Product By Brand</h4>
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
                          <th style="width:15px;">
                            Category
                          </th>
                          <th style="width:20px;">
                            Brand Name
                          </th>
                          <th style="width:100px;">
                            Product Name
                          </th>
                          <th style="width:20px;">
                            Product Price
                          </th>
                          <th style="width:250px;">
                            Product Description
                          </th>
                          <th style="width:30px;">
                            Product Image
                          </th>
                          <th style="width:20px;">
                            Stock
                          </th>
                          <th style="width:100px;">
                            Latest Updated Date
                          </th>
                          <th style="width:20px;">
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        //Selecting the information 
                        $admin_id = $_SESSION["admin_id"];
                        $brand_id=$_GET["brand_id"];
                        $sql = "SELECT * FROM product_info_table  
                                LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id  
                                WHERE admin_id='$admin_id' AND brand_table.brand_id='$brand_id'";
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
                            $stock = $row["stock"];
                            $latest_updated_date = $row["latest_updated_date"];
                            $admin_id = $row["admin_id"];

                            echo
                            '
                            <tr>
                              <td>'.$category.'</td>
                              <td>'.$brand.'</td>
                              <td style="text-align:left;">'.$product_name.'</td>
                              <td>'.$product_price.'</td>
                              <td style="text-align:left;">'.$product_desc.'</td>
                              <td class="text-center"><img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:100px; height:100px;" /></td>
                              <td>'.$stock.'</td>
                              <td>'.$latest_updated_date.'</td>
                              <td>
                                <form method="POST" action="admin-edit-product.php">
                                  <input type="hidden" value="' . $admin_id . '" name="admin_id">
                                  <input type="hidden" value="' . $product_id . '" name="product_id">
                                  <button type="submit" class="btn btn-block btn-info btn-xs" name="edit-product" id="'. $product_id .'" title="Edit product"><i class="ti-pencil-alt"></i></button>
                                </form>
                                <br>
                                <form method="POST" action="" name="deleteForm" id="deleteForm">
                                  <input type="hidden" value="' . $product_id . '" name="product_id">
                                  <button type="submit" class="btn btn-block btn-danger btn-xs" name="btnDelete" id="' . $product_id . '" title="Delete product"><i class="ti-layout-placeholder"></i></button>
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
                  <a href="view-product-by-brand.php"><input type="button" class="btn btn-warning mr-2 text-light mt-2" value="Back"></a>
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
        return confirm("Are you sure you want to delete this product?");
    });  
  </script>
  <!-- End custom js for this page-->
</body>

</html>


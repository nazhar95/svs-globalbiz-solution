<?php
  include("session-admin.php");

  if (isset($_POST['btnDelete']))
  { 
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $delete_query="DELETE FROM product_info_table WHERE product_id='$product_id'";
    $result = mysqli_query($conn, $delete_query) or trigger_error("Query Failed! SQL: $delete_query - Error: ".mysqli_error($conn), E_USER_ERROR);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Product By Brand Page | SVS GlobalBiz Solution</title>
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
                  <h4 class="font-weight-bold mb-0">View Product By Brand</h4>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <div class="container text-center">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                    $admin_id = $_SESSION["admin_id"];
                                    $sql = "SELECT DISTINCT brand_table.brand_id, brand_table.brand_name FROM product_info_table  
                                            LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                            LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id  
                                            WHERE admin_id='$admin_id' 
                                            ORDER BY brand_table.brand_id ASC";
                                    $result = mysqli_query($conn, $sql);
                                    
                                    if (mysqli_num_rows($result) > 0) 
                                    {
                                      // output data of each row
                                      while($row = mysqli_fetch_assoc($result)) 
                                      {
                                        $brand = $row["brand_name"];  
                                        $b_id = $row["brand_id"];
                                        
                                        echo 
										'
                                            <a href="list-product-by-brand.php?brand_id='.$b_id.'" style="text-decoration:none;">
                                                <button type="button" class="btn" style="background-color:#CFB53B;color:white;width:150px;">'.$brand.'</button>
                                            </a>  
                                        ';
                                        
                                      }
                                      
                                    }
                                    else
                                    {
                                        echo "No results are found.";
                                    }
                                ?>
                            
                            </div>
                        </div>  
                    </div>
                  
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


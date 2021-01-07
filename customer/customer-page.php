<?php
  include("session-customer.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Customer Dashboard Page | SVS GlobalBiz Solution</title>
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
  <link rel="icon" type="image/png" href="../images/favicon.ico" />
  <style>
    .sidebar .nav .nav-item.active > .nav-link i, .sidebar .nav .nav-item.active > .nav-link .menu-title, .sidebar .nav .nav-item.active > .nav-link .menu-arrow {
      color:#000;
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
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
                  <h4 class="font-weight-bold mb-0">Dashboard</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left">Products in Cart</p>
                  <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                    <?php
                      $customer_id=$_SESSION["customer_id"];
                      $sql = "SELECT COUNT(cart_id) FROM cart_table
                              WHERE customer_id='$customer_id'";
                      $result = mysqli_query($conn, $sql);
                      
                      if (mysqli_num_rows($result) > 0) 
                      {
                        while($row = mysqli_fetch_assoc($result)) 
                        {

                          $total_product_in_cart = $row['COUNT(cart_id)'];

                          echo
                          '
                            <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">'.$total_product_in_cart.'</h3>
                          ';
                        }
                      }
                      else
                      {
                      echo
                      '
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">0</h3>
                      ';
                      }
                    ?>                   
                    <i class="ti-shopping-cart-full icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>  
                  </div>  
                  <p class="mb-0 mt-2 text-info"><a href="products-in-cart.php">View</a></p>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left">Orders with Pending Payment</p>
                  <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <?php
                      $customer_id=$_SESSION["customer_id"];
                      $sql = "SELECT COUNT(order_id) FROM products_ordered_table
                              WHERE customer_id='$customer_id' AND order_status='Pending payment'";
                      $result = mysqli_query($conn, $sql);
                      
                      if (mysqli_num_rows($result) > 0) 
                      {
                        while($row = mysqli_fetch_assoc($result)) 
                        {

                          $total_product_pending_payment = $row['COUNT(order_id)'];

                          echo
                          '
                            <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">'.$total_product_pending_payment.'</h3>
                          ';
                        }
                      }
                      else
                      {
                      echo
                      '
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">0</h3>
                      ';
                      }
                    ?>
                    <i class="ti-bag icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                  </div>  
                  <p class="mb-0 mt-2 text-info"><a href="products-ordered-page.php">View</a></p>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left">Orders with Completed Payment</p>
                  <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <?php
                      $customer_id=$_SESSION["customer_id"];
                      $sql = "SELECT COUNT(order_id) FROM products_ordered_table
                              WHERE customer_id='$customer_id' AND order_status='Paid'";
                      $result = mysqli_query($conn, $sql);
                      
                      if (mysqli_num_rows($result) > 0) 
                      {
                        while($row = mysqli_fetch_assoc($result)) 
                        {

                          $total_product_finish_payment = $row['COUNT(order_id)'];

                          echo
                          '
                            <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">'.$total_product_finish_payment.'</h3>
                          ';
                        }
                      }
                      else
                      {
                      echo
                      '
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">0</h3>
                      ';
                      }
                    ?>
                    <i class="ti-bag icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                  </div>  
                  <p class="mb-0 mt-2 text-info"><a href="products-ordered-page.php#pills-paid">View</a></p>
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
  <!-- End custom js for this page-->
</body>

</html>


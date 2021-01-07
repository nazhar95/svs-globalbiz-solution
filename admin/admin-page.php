<?php
  include("session-admin.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Dashboard Page | SVS GlobalBiz Solution</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../page-template/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../page-template/vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../page-template/style.css">
  <link rel="stylesheet" href="../style.css">
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
  <!-- endinject -->
  <link rel="icon" type="image/png" href="../images/favicon.ico" />
 
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
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
                  <h4 class="font-weight-bold mb-0">Dashboard</h4>
                </div>
              </div>
            </div>
          </div>
          <h5 class="font-weight-bold mb-2">Customer Related</h5>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left">New Customer Order</p>
                  <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <?php
                      $admin_id=$_SESSION["admin_id"];
                      $sql = "SELECT COUNT(order_id) FROM products_ordered_table
                              LEFT JOIN product_info_table ON products_ordered_table.product_id = product_info_table.product_id
                              WHERE products_ordered_table.admin_id='$admin_id' AND order_status='Paid'";
                      $result = mysqli_query($conn, $sql);
                      
                      if (mysqli_num_rows($result) > 0) 
                      {
                        while($row = mysqli_fetch_assoc($result)) 
                        {

                          $total_products_ordered = $row['COUNT(order_id)'];

                          echo
                          '
                            <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">'.$total_products_ordered.'</h3>
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
                    <i class="ti-face-smile icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                  </div>  
                  <p class="mb-0 mt-2 text-info"><a href="customer-orders-page.php">View</a></p>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left">New Cancelled Order</p>
                  <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <?php
                      $admin_id=$_SESSION["admin_id"];
                      $sql = "SELECT COUNT(*) FROM products_ordered_table
                              LEFT JOIN product_info_table ON products_ordered_table.product_id = product_info_table.product_id
                              LEFT JOIN cancel_order_table ON products_ordered_table.order_id = cancel_order_table.order_id
                              WHERE products_ordered_table.admin_id='$admin_id' AND products_ordered_table.order_status='Cancelled' AND cancel_order_table.cancel_status='To be approved by admin'";
                      $result = mysqli_query($conn, $sql);
                      
                      if (mysqli_num_rows($result) > 0) 
                      {
                        while($row = mysqli_fetch_assoc($result)) 
                        {

                          $total_cancel_order = $row['COUNT(*)'];

                          echo
                          '
                            <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">'.$total_cancel_order.'</h3>
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
                    <i class="ti-face-sad icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                  </div>  
                  <p class="mb-0 mt-2 text-info"><a href="customer-orders-page.php#pills-cancel-order">View</a></p>
                </div>
              </div>
            </div>
          </div>
          <h5 class="font-weight-bold mb-2">Product Related</h5>
          <div class="row">  
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left">Total Products</p>
                  <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <?php
                      $admin_id=$_SESSION["admin_id"];
                      $sql = "SELECT COUNT(product_id) FROM product_info_table  
                              LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                              LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id  
                              WHERE admin_id='$admin_id'";
                      $result = mysqli_query($conn, $sql);
                      
                      if (mysqli_num_rows($result) > 0) 
                      {
                        while($row = mysqli_fetch_assoc($result)) 
                        {

                          $total_products = $row['COUNT(product_id)'];

                          echo
                          '
                            <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">'.$total_products.'</h3>
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
                    <i class="ti-package icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                  </div>  
                  <p class="mb-0 mt-2 text-info"><a href="admin-product-list.php">View All Products</a></p>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left">Total Products Sold</p>
                  <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <?php
                      $admin_id=$_SESSION["admin_id"];
                      $sql = "SELECT COUNT(order_id) FROM products_ordered_table
                              LEFT JOIN product_info_table ON products_ordered_table.product_id = product_info_table.product_id
                              WHERE products_ordered_table.admin_id='$admin_id' AND order_status='Completed'";
                      $result = mysqli_query($conn, $sql);
                      
                      if (mysqli_num_rows($result) > 0) 
                      {
                        while($row = mysqli_fetch_assoc($result)) 
                        {

                          $total_product_sold = $row['COUNT(order_id)'];

                          echo
                          '
                            <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">'.$total_product_sold.'</h3>
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
                    <i class="ti-files icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                  </div>
                  <p class="mb-0 mt-2 text-info"><a href="list-report-by-month.php">View Sales Report</a></p>  
                </div>
              </div>
            </div>
          </div>

          <?php
            //Selecting the information from the user_table
            $admin_id = $_SESSION["admin_id"];
            $sql = "SELECT * FROM admin_table WHERE admin_id='$admin_id'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) 
            {
            // output data of each row
              while($row = mysqli_fetch_assoc($result)) 
              {
                $admin_id = $row["admin_id"];
                $full_name = $row["full_name"];
                $admin_status=$row['admin_status'];

                if ($admin_status=='super_admin')
                {
                  echo
                  '
                  <h5 class="font-weight-bold mb-2">Admin Related</h5>
                  <div class="row">  
                    <div class="col-md-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <p class="card-title text-md-center text-xl-left">New Admin Request</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">       
                  ';

                  $sql = "SELECT COUNT(admin_id) FROM admin_table WHERE admin_status='Pending approval'";
                  $result1 = mysqli_query($conn, $sql);
                  
                  if (mysqli_num_rows($result1) > 0) 
                  {
                    while($row = mysqli_fetch_assoc($result1)) 
                    {

                      $total_admin = $row['COUNT(admin_id)'];
                        echo
                        '
                          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">'.$total_admin.'</h3>
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

                  echo
                  '
                            <i class="ti-package icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                          </div>  
                          <p class="mb-0 mt-2 text-info"><a href="list-new-admin.php">New Admin List</a></p>
                        </div>
                      </div>
                    </div>
                  ';
                }
              }
            }
          ?>

          <?php
            //Selecting the information from the user_table
            $admin_id = $_SESSION["admin_id"];
            $sql = "SELECT * FROM admin_table WHERE admin_id='$admin_id'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) 
            {
            // output data of each row
              while($row = mysqli_fetch_assoc($result)) 
              {
                $admin_id = $row["admin_id"];
                $full_name = $row["full_name"];
                $admin_status=$row['admin_status'];

                if ($admin_status=='super_admin')
                {
                  echo
                  '
                    <div class="col-md-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <p class="card-title text-md-center text-xl-left">Total Admin</p>
                          <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">       
                  ';

                  $sql = "SELECT COUNT(admin_id) FROM admin_table WHERE admin_status!='Pending approval' AND admin_status!='Declined'";
                  $result1 = mysqli_query($conn, $sql);
                  
                  if (mysqli_num_rows($result1) > 0) 
                  {
                    while($row = mysqli_fetch_assoc($result1)) 
                    {

                      $total_admin = $row['COUNT(admin_id)'];
                      echo
                      '
                            <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">'.$total_admin.'</h3>
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

                  echo
                  '
                            <i class="ti-package icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                          </div>  
                          <p class="mb-0 mt-2 text-info"><a href="list-existing-admin.php">View Admin List</a></p>
                        </div>
                      </div>
                    </div>
                    </div>
                  ';
                }
              }
            }
          ?>
          
        
        </div>
        
      
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include("../page-template/footer.php"); ?>
        <!-- partial -->
      
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


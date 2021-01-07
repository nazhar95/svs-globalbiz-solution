<?php
  include("session-admin.php");
 
  if(isset($_POST['add-brand'])){
    $brand_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $check_existing_query = "SELECT * FROM brand_table WHERE brand_name='$brand_name' LIMIT 1";
    $result = mysqli_query($conn, $check_existing_query);
    $brand_exist = mysqli_fetch_assoc($result);

    
    if ($brand_exist) 
    {
        if ($brand_exist['brand_name'] === $brand_name) 
        {
            echo 
            (
                "<script language='JAVASCRIPT'>
                    window.alert('Brand already existed.');
                    window.location.href='admin-add-brand.php';
                </script>"
            );
        }
        
    }
    else    
    {
            $query = "INSERT INTO brand_table (brand_name) VALUES ('$brand_name')";        
            $result1=mysqli_query($conn, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($conn), E_USER_ERROR);

            echo 
            (
                "<script language='JAVASCRIPT'>
                    window.alert('Brand successfully added.');
                    window.location.href='admin-add-product.php';
                </script>"
            );
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Add Brand Page | SVS GlobalBiz Solution</title>
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
    <script src="https://cdn.tiny.cloud/1/jqlvox6zxpy1h5n6mugmaw019hu1420xuak30zt7eavn5zdh/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
                    <h4 class="font-weight-bold mb-0">Add New Brand</h4>
                    </div> 
                </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <form class="forms-sample" method="POST">
                        <div class="form-group">
                            <label>Brand Name</label>
                            <input type="text" class="form-control" name="brand_name" placeholder="Brand Name" required/>
                        </div>
                        <input type="submit" name="add-brand" class="btn btn-warning mr-2 text-light" value="Add Brand">
                        <a href="admin-add-product.php"><input type="button" class="btn btn-danger mr-2 text-light" value="Cancel"></a>
                    </form>
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
    tinymce.init({
        selector: '#product_desc',
        width: 600,
        height: 300
    });
    </script>
    <!-- End custom js for this page-->
</body>

</html>


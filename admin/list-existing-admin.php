<?php
  include("session-admin.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Existing admin List | SVS GlobalBiz Solution</title>
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
                            <h4 class="font-weight-bold mb-0">Existing Admin List</h4>
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
                                                <th style="width:100px;">
                                                    Registered Date
                                                </th>
                                                <th style="width:250px;">
                                                    Name
                                                </th>
                                                <th>
                                                    Phone No.
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Gender 
                                                </th>
                                                <th style="width:150px;">
                                                    Date of Birth
                                                </th>
                                                <th style="width:150px;">
                                                    Company Name
                                                </th>
                                                <th style="width:250px;">
                                                    Company Address
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $sql = "SELECT * FROM admin_table WHERE admin_status!='Pending approval' AND admin_status!='Declined' ORDER BY register_date ASC";
                                            $result = mysqli_query($conn, $sql);
                                            
                                            if (mysqli_num_rows($result) > 0) 
                                            {
                                                // output data of each row
                                                while($row = mysqli_fetch_assoc($result)) 
                                                {
                                                    echo
                                                    '
                                                    <tr>
                                                        <td>'.$row["register_date"].'</td>
                                                        <td>'.$row["full_name"].'</td>
                                                        <td>'.$row["phone"].'</td>
                                                        <td>'.$row["email"].'</td>
                                                        <td>'.$row["gender"].'</td>
                                                        <td>'.$row["dob"].'</td>
                                                        <td>'.$row["company_name"].'</td>
                                                        <td>'.$row["company_address"].'</td>
                                                    </tr>
                                                    ';
                                                }
                                            } 
                                            else 
                                            {
                                                echo
                                                '
                                                    <tr>
                                                        <td colspan="8">
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
    $('#approveadmin').submit(function() {  
        return confirm("Are you sure you want to approve the newly registered admin?");
    });

    $('#declineadmin').submit(function() {  
        return confirm("Are you sure you want to decline the newly registered admin?");
    });  
  </script>
  <!-- End custom js for this page-->
</body>

</html>


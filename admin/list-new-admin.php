<?php
  include("session-admin.php");

  if (isset($_POST['btnAcceptadmin']))
  {
    $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
    $admin_phone = mysqli_real_escape_string($conn, $_POST['admin_phone']);
    
    //update admin_table
    $update_admin_status_query="UPDATE admin_table SET admin_status='Approved' WHERE admin_id='$admin_id'";
    $result1 = mysqli_query($conn, $update_admin_status_query) or trigger_error("Query Failed! SQL: $update_admin_status_query - Error: ".mysqli_error($conn), E_USER_ERROR);

    echo 
    (
        "<script language='JAVASCRIPT'>
            window.alert('You have accepted the admin. Please send a message to the newly registered admin to note him/her that he/she has been approved.');
            window.location.href='https://api.whatsapp.com/send/?phone=6".$admin_phone."&text=Dear newly registered admin on SVS GlobalBiz Solution E-commerce website, SVS GlobalBiz Solution would like to inform you that you have successfully been approved by the super admin to become an authenticated admin in our website. From now onwards, you are able to login into the website and sell your products. We are happy to collaborate with you and would like to wish you good luck!';
        </script>"
    );
  }

  if (isset($_POST['btnDeclineadmin']))
  {
    $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
    $admin_phone = mysqli_real_escape_string($conn, $_POST['admin_phone']);
    
    //update admin_table
    $update_admin_status_query="UPDATE admin_table SET admin_status='Declined' WHERE admin_id='$admin_id'";
    $result1 = mysqli_query($conn, $update_admin_status_query) or trigger_error("Query Failed! SQL: $update_admin_status_query - Error: ".mysqli_error($conn), E_USER_ERROR);

    echo 
    (
        "<script language='JAVASCRIPT'>
            window.alert('You have declined the admin. Please send the message to the newly registered admin to note him/her that he/she has been declined to be a admin.');
            window.location.href='https://api.whatsapp.com/send/?phone=6".$admin_phone."&text=Dear newly registered admin on SVS GlobalBiz Solution E-commerce website, SVS GlobalBiz Solution regret to inform you that you are declined to be an authenticated admin in our website. For more information, you may contact our us through our phone number or via our email.';
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
  <title>Newly Registered Admin List | SVS GlobalBiz Solution</title>
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
                            <h4 class="font-weight-bold mb-0">Newly Registered admin List</h4>
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
                                                <th style="width:500px;">
                                                    Newly Registered admin Information
                                                </th>
                                                <th style="width:100px;">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $sql = "SELECT * FROM admin_table WHERE admin_status='Pending approval' ORDER BY register_date DESC";
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
                                                        <td style="text-align:left;">
                                                            <p><b>Name</b>:</p>
                                                            <p>'.$row["full_name"].'</p>
                                                            <br>
                                                            <p><b>Phone</b>:</p>
                                                            <p>'.$row["phone"].'</p>
                                                            <br>
                                                            <p><b>Email</b>:</p>
                                                            <p>'.$row["email"].'</p>
                                                            <br>
                                                            <p><b>Company Name</b>:</p>
                                                            <p>'.$row["company_name"].'</p>
                                                            <br>
                                                            <p><b>Company Address</b>:</p>
                                                            <p>'.$row["company_address"].'</p>
                                                            <br>
                                                        </td>
                                                        <td>
                                                            <form method="POST" name="approveadmin" id="approveadmin" class="mb-2">
                                                                <input type="hidden" value="' .$row["admin_id"]. '" name="admin_id">
                                                                <input type="hidden" value="' .$row["phone"]. '" name="admin_phone">
                                                                <input type="submit" name="btnAcceptadmin" id="btnAcceptadmin" class="btn btn-info mr-2 text-light" value="Accept admin"> 
                                                            </form>
                                                            <form method="POST" name="declineadmin" id="declineadmin" class="mb-2">
                                                                <input type="hidden" value="' .$row["admin_id"]. '" name="admin_id">
                                                                <input type="hidden" value="' .$row["phone"]. '" name="admin_phone">
                                                                <input type="submit" name="btnDeclineadmin" id="btnDeclineadmin" class="btn btn-danger mr-2 text-light" value="Decline admin">
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
                                                        <td colspan="3">
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


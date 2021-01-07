<?php
    include("session-admin.php");

    //Declare variables for the errors
    $error = "";
    $error1 = "";
        
    if(isset($_POST['update_profile']))
    {
        if
        (
          $_POST['full_name'] == "" || 
          $_POST['email'] == "" ||
          $_POST['password1'] == "" || 
          $_POST['password2'] == "" ||
          $_POST['gender'] == "" ||
          $_POST['dob'] == "" || 
          $_POST['company_name'] == "" ||
          $_POST['company_address'] == "" ||
          $_POST['phone'] == "" 
        )
        {
            $error = "Please fill in the required field";
        }
        else
        {
            $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
            $password2 =  mysqli_real_escape_string($conn, $_POST['password2']);
            $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
            $company_address = mysqli_real_escape_string($conn, $_POST['company_address']);
            $gender = mysqli_real_escape_string($conn, $_POST['gender']);
            $dob = mysqli_real_escape_string($conn, $_POST['dob']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $admin_id=$_SESSION['admin_id'];
            
            $user_check_query = "SELECT * FROM admin_table WHERE email='$email' AND admin_id='$admin_id' LIMIT 1";
            $result = mysqli_query($conn, $user_check_query);
            $user = mysqli_fetch_assoc($result);
        
            
            if($password1 == $password2)
            {
                //put user details into user_table
                $password = md5($password1);
                $update_profile_query = "UPDATE admin_table SET full_name='$full_name', email='$email', password='$password', gender='$gender', dob='$dob', company_name='$company_name', company_address='$company_address', phone='$phone' WHERE admin_id='$admin_id'";        
                $result1=mysqli_query($conn, $update_profile_query) or trigger_error("Query Failed! SQL: $update_profile_query - Error: ".mysqli_error($conn), E_USER_ERROR);
                // echo $update_profile_query;

                echo 
                (
                    "<script language='JAVASCRIPT'>
                        window.alert('Profile successfully updated');
                        window.location.href='admin-profile-setting.php';
                    </script>"
                );

            }
            else
            {
                $error1 = "The confirmed password is not the same!"; 
            }
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Profile Page | SVS GlobalBiz Solution</title>
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
    <link rel="icon" type="image/png" href="../images\favicon.ico" />
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
                    <h4 class="font-weight-bold mb-0">Edit Profile</h4>
                    </div> 
                </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <form class="forms-sample" method="POST">
                    <?php
                        $admin_id=$_SESSION['admin_id'];
                        $select_details_query="SELECT * FROM admin_table WHERE admin_id='$admin_id'";
                        $result = mysqli_query($conn, $select_details_query) or trigger_error("Query Failed! SQL: $select_details_query - Error: ".mysqli_error($conn), E_USER_ERROR);
                    
                        if (mysqli_num_rows($result) > 0) 
                        {
                            while($row = mysqli_fetch_assoc($result)) 
                            {
                            echo
                            '
                            <div class="form-group row">
                              <label class="col-sm-3 form-control-label">Full Name</label>
                              <div class="col-sm-9">
                                <input name="full_name" type="text" value="'.$row['full_name'].'" placeholder="Please enter your full name" class="form-control" min="10" max="200" required/>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 form-control-label">Email</label>
                              <div class="col-sm-9">
                                <input name="email" type="email" value="'.$row['email'].'" placeholder="Eg: johndoe@gmail.com" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required/>         
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 form-control-label">Gender</label>
                              <div class="col-sm-9">
                                <select id="gender" name="gender" class="form-control">
                                  <option value="'.$row['gender'].'">'.$row['gender'].'</option>   
                                  <option value="Male">Male</option>
                                  <option value="Female">Female</option>
                                  <option value="Others">Others</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 form-control-label">Date of Birth</label>
                              <div class="col-sm-9">
                              <input type="date" class="form-control" value="'.$row['dob'].'" placeholder="Data of Birth" name="dob" id="dob">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 form-control-label">Company Name</label>
                              <div class="col-sm-9">
                                <input name="company_name" type="text" value="'.$row['company_name'].'" placeholder="Please enter your company name" class="form-control" min="10" max="200" required/>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 form-control-label">Company Address</label>
                              <div class="col-sm-9">
                                <textarea name="company_address" id="" cols="30" rows="5" placeholder="Please enter your company address" min="10" max="300" class="form-control" required/>'.$row['company_address'].'</textarea>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 form-control-label">Phone No.</label>
                              <div class="col-sm-9">
                                <input name="phone" type="tel" value="'.$row['phone'].'" placeholder="Eg: 0194445555" class="form-control" pattern="^(01)[0-46-9]*[0-9]{7,8}$" required/>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 form-control-label">Password</label>
                              <div class="col-sm-9">
                                <input name="password1" type="password" id="password1" placeholder="Eg: John1234" class="form-control" min="6" max="12" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,12}$" required/>
                                <small>Password must contain at least 6 to 12 characters, have one uppercase letter, one lowercase letter and a digit</small>
                              </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Confirm Password</label>
                                <div class="col-sm-9">
                                  <input name="password2" type="password" id="password2" placeholder="Eg: John1234" class="form-control" min="6" max="12" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,12}$" required/>
                                  <br>
                                  <input type="checkbox" onclick="showPassword()"> Show Password
                                </div>
                            </div>
                            <div class="form-group row">       
                                <div class="col-sm-12 text-center">
                                    <input type="submit" name="update_profile" value="Update Profile" class="btn btn-primary">
                                </div>
                            </div>
                            ';
                            }
                        }
                    ?>       
                    </form>
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
        $(document).ready(function(){
            $('#add-product').click(function(){
                var image_name = $('#product_img').val();
                if(image_name==''){
                    alert("Please select an image");
                    return false;
                }
                else{
                    var extension = $('#product_img').val().split('.').pop().toLowerCase();
                    if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1){
                        alert("Invalid image file!");
                        $('#product_img').val('');
                        return false;
                    }
                }
            })
        });
    </script>
    <script>
        $('#add-product-form').submit(function() {  
            return confirm("Are you sure you want to update your profile?");
        });
    </script>
    <script>
       function showPassword() {
            var x = document.getElementById("password1");
            var y = document.getElementById("password2");
            
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }

            if (y.type === "password") {
                y.type = "text";
            } else {
                y.type = "password";
            }
        }
    </script>
    <script>
    $(function(){
        var dtToday = new Date();
    
        var month = dtToday.getMonth() + 1;// jan=0; feb=1 .......
        var day = dtToday.getDate();
        var year = dtToday.getFullYear() - 18;
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
    	  var minDate = year + '-' + month + '-' + day;
        var maxDate = year + '-' + month + '-' + day;
    	$('#dob').attr('max', maxDate);
    });
    </script>
    <!-- End custom js for this page-->
</body>

</html>


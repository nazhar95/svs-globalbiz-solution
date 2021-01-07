<?php
  //DB Connection
  include("inc/dbconfig.php");

  //Show all errors
  error_reporting(E_ALL);

  //timezone for Malaysia
  date_default_timezone_set("Asia/Kuala_Lumpur");
  
  //Declare variables for the errors
  $error = "";
  $error1 = "";
  $error2 = "";

  //Process the registration form for admin
  if(isset($_POST['register-admin']))
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
          $register_date = date("Y-m-d");
          $admin_status="Pending approval";
          $role_id=1;
      
          $user_check_query = "SELECT * FROM admin_table WHERE email='$email' LIMIT 1";
          $result = mysqli_query($conn, $user_check_query);
          $user = mysqli_fetch_assoc($result);
      
          if ($user) 
          {
              if ($user['email'] === $email) 
              {
                  $error1 = "Email already exists";
              }
          }
          if ($error1 == "") 
          {
              if($password1 == $password2)
              {
                  //put user details into user_table
                  $password = md5($password1);
                  $query = "INSERT INTO admin_table (role_id, full_name, email, password, gender, dob, company_name, company_address, phone, register_date, admin_status) VALUES ('$role_id', '$full_name', '$email', '$password','$gender','$dob','$company_name', '$company_address', '$phone', '$register_date', '$admin_status')";
                  $result1=mysqli_query($conn, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($conn), E_USER_ERROR);
                  $_SESSION['login_user']=$email;
                  $_SESSION['role_user']=$role_id;

                  echo 
                  (
                      "<script language='JAVASCRIPT'>
                          window.alert('Thank you for signing up. You will be notified by the super admin in 3 days regarding the status of approval.');
                          window.location.href='./login.php';
                      </script>"
                  );

              }
              else
              {
                  $error2 = "The confirmed password is not the same!"; 
              }
          }
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Registration | SVS GlobalBiz Solution</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	  <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images\favicon.ico">
    <script>
    
</script> 
</head><!--/head-->

<body>
	<?php include("inc/header.php"); ?>
	<!--/header-->
	
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
        <!--sign up form customer-->
				<div class="col-sm-12">
          <div class="col-lg-12 bg-white">
            <div class="form d-flex align-items-center">
                <div class="content">
                <p style="background-color:black;text-align:center;color:white;"><b><span style="color:#CFB53B;">Dear newly registered admin,</span></b><br> You will need to wait for the super admin to approve you in 3 days before you can login. Thank you for your attention.</p> 
                  <div id="login-alert" class="text-center col-sm-12" style="margin-bottom:5px;color:white;background-color:#CFB53B;">
                    <?php if(isset($error)) { echo $error; } ?>
                    <?php if(isset($error1)) { echo $error1; } ?>
                    <?php if(isset($error2)) { echo $error2; } ?>
                  </div>
                  <form class="form-horizontal" method="POST" name="adminRegisterForm">
                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Full Name</label>
                      <div class="col-sm-9">
                        <input name="full_name" type="text" placeholder="Please enter your full name" class="form-control" min="10" max="200" required/>
                      </div>
                      
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Email</label>
                      <div class="col-sm-9">
                        <input name="email" type="email" placeholder="Eg: johndoe@gmail.com" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required/>
                        
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Gender</label>
                      <div class="col-sm-9">
                        <select id="gender" name="gender" class="form-control">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Date of Birth</label>
                      <div class="col-sm-9">
                      <input type="date" class="form-control" placeholder="Data of Birth" name="dob" id="dob">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Company Name</label>
                      <div class="col-sm-9">
                        <input name="company_name" type="text" placeholder="Please enter your company's name" class="form-control" min="10" max="200" required/>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Company Address</label>
                      <div class="col-sm-9">
                        <textarea name="company_address" id="" cols="30" rows="5" placeholder="Please enter your company's address" min="10" max="300" class="form-control" required/></textarea>
                      
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Phone No.</label>
                      <div class="col-sm-9">
                        <input name="phone" type="tel" placeholder="Eg: 0194445555" class="form-control" pattern="^(01)[0-46-9]*[0-9]{7,8}$" required/>
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
                          <input type="submit" name="register-admin" value="Register" class="btn btn-primary" style="background-color:#CFB53B">
                      </div>
                    </div>
                  </form>
                  <div align="center">
                    <small>Already have an account? </small>
                    <a href="login.php" class="signup" style="color:#CFB53B;">Login</a>
                  </div> 
              </div>
            </div>
          </div>
        </div>
			</div>
		</div>
	</section><!--/form-->
	
	
	<!--Footer-->
    <?php include("inc/footer.php") ?>
		
    <script src="js/jquery.js"></script>
	  <script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	  <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
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
</body>
</html>
<?php
  error_reporting(0);

  //DB Connection
  include("inc/dbconfig.php");

  // Initialize the session
  session_start();

  $username="";
  $password="";

  if(isset($_POST["login-customer"]))
  {
    // Getting Post Vlaues
    $username=mysqli_real_escape_string($conn, trim($_POST['username']));
    $password=mysqli_real_escape_string($conn, trim(md5($_POST['password']))); // MD5 password encryption
    $sql = "SELECT * from customer_table where email ='$username' and password ='$password'";
    $result = mysqli_query($conn,$sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);;
	$row = mysqli_fetch_array($result);

    if($row) 
    {
		$_SESSION["login_user"]= $row["email"];
		$_SESSION["customer_id"]=$row["customer_id"];
		$_SESSION["user_fullname"]= $row["full_name"];
		$_SESSION["user_role"]=2;
		$_SESSION['loggedin']=true;
      
		if(!empty($_POST["remember"])) 
		{
			setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
			setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
      	} 
		else 
		{
			if(isset($_COOKIE["user_login"])) 
			{
				setcookie ("user_login","");
			}
			if(isset($_COOKIE["userpassword"])) 
			{
				setcookie ("userpassword","");
			}
		}
		echo 
		(
			"<script language='JAVASCRIPT'>
				window.alert('Login success.');
				window.location.href='customer/customer-page.php';
			</script>"
		);
	}
    else if (empty($_POST["username"]))
    {
      $message_customer = "Invalid username!";
    }
    else if (empty($_POST["password"]))
    {
      $message_customer = "Invalid password!";
    }
    else{
      $message_customer = "Invalid login!";
    }
  }
  
  if(isset($_POST["login-admin"]))
  {
    // Getting Post Vlaues
    $username=mysqli_real_escape_string($conn, trim($_POST['username']));
	$password=mysqli_real_escape_string($conn, trim(md5($_POST['password']))); // MD5 password encryption
    $sql = "SELECT * from admin_table where email ='$username' and password ='$password'";
    $result = mysqli_query($conn,$sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);;
	$row = mysqli_fetch_array($result);

    if($row) 
    {
		$_SESSION["login_user"]= $row["email"];
		$_SESSION["admin_id"]=$row["admin_id"];
		$_SESSION["user_fullname"]= $row["full_name"];
		$admin_status=$row["admin_status"];
		$_SESSION["user_role"]=1;
		
		if(!empty($_POST["remember"])) 
		{
			setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
			setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
      	} 
		else 
		{
			if(isset($_COOKIE["user_login"])) 
			{
				setcookie ("user_login","");
			}
			if(isset($_COOKIE["userpassword"])) 
			{
				setcookie ("userpassword","");
			}
		}

		if($admin_status=="Pending approval")
		{
			echo 
			(
				"<script language='JAVASCRIPT'>
					window.alert('Sorry, you will need to wait for the super admin to approve you to be a admin.');
					window.location.href='login.php';
				</script>"
			);
		}
		else if($admin_status=="Declined")
		{
			echo 
			(
				"<script language='JAVASCRIPT'>
					window.alert('Sorry, you are not approved to be a admin by the super admin. Please contact the super admin for more information.');
					window.location.href='login.php';
				</script>"
			);
		}
		else
		{
			$_SESSION['loggedin']=true;

			echo 
			(
				"<script language='JAVASCRIPT'>
					window.alert('Login success.');
					window.location.href='admin/admin-page.php';
				</script>"
			);
		}
	}
    else if (empty($_POST["username"]))
    {
      $message_admin = "Invalid username!";
    }
    else if (empty($_POST["password"]))
    {
      $message_admin = "Invalid password!";
	}
    else{
      $message_admin = "Invalid login!";
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
    <title>Login | SVS GlobalBiz Solution</title>
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
    <link rel="icon" type="image/png" href="images\favicon.ico" />
</head><!--/head-->

<body>
	<?php include("inc/header.php"); ?>
	<!--/header-->
	
	<section id="form"><!--form-->
		<div class="container pt-0">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login as Customer</h2>
						<div id="login-alert" class="text-center col-sm-12" style="margin-bottom:5px;color:white;background-color:#CFB53B;">
							<?php if(isset($message_customer)) { echo $message_customer; } ?>
						</div>
						<form method="POST">
  							<label>Username</label>
							  <input type="email" placeholder="Email" class="form-control" name="username" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>" required>

							<label>Password</label>  
							<input type="password" placeholder="Password" class="form-control" name="password" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>" required>
							<span>
								<input type="checkbox" class="checkbox" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?>/> 
								Keep me signed in
							</span>
							<div class="form-group">       
								<div class="text-center">
									<input type="submit" name="login-customer" value="Login" class="btn btn-primary" style="background-color:#CFB53B;color:#000;">
								</div>
								<div class="text-center">
									<a href="customer-forget-password.php" style="color:#CFB53B;">Forget Password?</a>
								</div>
                  			</div>
						</form>
					</div>
					<!--/login form-->
				</div>
				<div class="col-sm-1" style="margin-left:20px;">
					<h2 class="or" style="background-color:#CFB53B;color:#000">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="login-form"><!--login form-->
						<h2>Login as Admin</h2>
						<div id="login-alert" class="text-center col-sm-12" style="margin-bottom:5px;color:white;background-color:#CFB53B;">
							<?php if(isset($message_admin)) { echo $message_admin; } ?>
						</div>
						<form method="POST">
  							<label>Username</label>
							  <input type="email" placeholder="Email" class="form-control" name="username" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>" required>

							<label>Password</label>  
							<input type="password" placeholder="Password" class="form-control" name="password" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>" required>
							<span>
								<input type="checkbox" class="checkbox" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?>/> 
								Keep me signed in
							</span>
							<div class="form-group">       
								<div class="text-center">
									<input type="submit" name="login-admin" value="Login" class="btn btn-primary" style="background-color:#CFB53B; color:#000;">
								</div>
								<div class="text-center">
									<a href="admin-forget-password.php" style="color:#CFB53B;">Forget Password?</a>
								</div>
                  			</div>
						</form>
					</div>
					<!--/login form-->
				</div>
				<div style="margin-top:10px; margin-bottom:25px;" class="col-sm-11 text-center">
						<a href="register-page.php" style="color:#CFB53B;">New user? Click here to register</a> 
				</div>
			</div>
		</div>
	</section><!--/form-->
	
	<!--/Footer-->
	<?php include("inc/footer.php") ?>
	
    <script src="js/jquery.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
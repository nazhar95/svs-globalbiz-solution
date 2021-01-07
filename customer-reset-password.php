<?php
    error_reporting(0);

    //DB Connection
    include("inc/dbconfig.php");

    // Initialize the session
    session_start();

    $username="";
    $phone="";

    if(isset($_POST["updatePass"]))
    {
        // Getting Post Vlaues
        $phone=mysqli_real_escape_string($conn, $_POST['phone']);
        $newpassword=mysqli_real_escape_string($conn, md5(trim($_POST['password'])));
        $sql = "UPDATE customer_table SET password='$newpassword' where phone ='$phone'";
        $result = mysqli_query($conn,$sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);;
        
        echo 
        (
            "
            <script language='JAVASCRIPT'>
                window.alert('You have successfully reset your password. You may login into your account by using the newly updated password.');
                window.location.href='login.php';
            </script>
            "
        );
    }
  
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Customer Reset Password | SVS GlobalBiz Solution</title>
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
</head><!--/head-->

<body>
    <?php include("inc/header.php"); ?>
	<!--/header-->
	
	<section id="form"><!--form-->
		<div class="container pt-0" style="margin-bottom:195px;">
			<div class="row">
				<div class="col-sm-12">
					<div class="login-form"><!--login form-->
						<h2>Reset Password</h2>
						<div id="login-alert" class="text-center col-sm-12" style="margin-bottom:5px;color:white;background-color:#CFB53B;">
							<?php if(isset($message)) { echo $message; } ?>
						</div>
						<form method="POST">
                        <?php
                            $phone=$_GET["phone"];
                            echo
                            '
                            <label>New Password</label>  
							<input type="password" placeholder="Password" class="form-control" name="password" required>

							<div class="form-group">       
								<div class="text-center">
									<input type="submit" name="updatePass" value="Submit" class="btn btn-primary" style="background-color:#CFB53B; color:#000;">
								</div>
                              </div>
                              <input type="hidden" name="phone" value="'.$phone.'">
                            ';
                         ?>     
						</form>
					</div>
					<!--/login form-->
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
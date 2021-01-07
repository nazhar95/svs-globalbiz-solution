<?php
  error_reporting(0);

  //DB Connection
  include("inc/dbconfig.php");

  // Initialize the session
  session_start();

  $username="";
  $phone="";

  if(isset($_POST["submit"]))
  {
    // Getting Post Vlaues
    $username=mysqli_real_escape_string($conn, trim($_POST['username']));
    $phone=mysqli_real_escape_string($conn, trim($_POST['phone'])); 
    $sql = "SELECT * from customer_table where email ='$username' and phone ='$phone'";
    $result = mysqli_query($conn,$sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);;
	$row = mysqli_fetch_array($result);

    if($row) 
    {
		$email= $row["email"];
        $phone=$row["phone"];
        $name=$row["full_name"];

        echo 
        (
            "
            <script language='JAVASCRIPT'>
                window.alert('Hello ".$name.", you will get your a link to renew your password through your WhatsApp.');
                window.location.href='https://api.whatsapp.com/send/?phone=6".$phone."&text=http://localhost/SVS-GlobalBiz-Solution/customer-reset-password.php?phone=".$phone."';
            </script>
            "
        );
	}
    //mysqli_close($conn);//Closing Connection
    else if (empty($_POST["username"]))
    {
      $message = "Invalid username!";
    }
    else if (empty($_POST["phone"]))
    {
      $message = "Invalid phone number!";
    }
    else{
      $message = "Invalid username/phone number!";
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
    <title>Customer Forget Password | SVS GlobalBiz Solution</title>
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
		<div class="container pt-0" style="margin-bottom:90px;">
			<div class="row">
				<div class="col-sm-12">
					<div class="login-form"><!--login form-->
						<h2>Reset Password</h2>
						<div id="login-alert" class="text-center col-sm-12" style="margin-bottom:5px;color:white;background-color:#CFB53B;">
							<?php if(isset($message)) { echo $message; } ?>
						</div>
						<form method="POST">
  							<label>Enter your username</label>
							  <input type="email" placeholder="Email" class="form-control" name="username" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>

							<label>Enter your phone no.</label>  
							<div class="form-group">
                                <input name="phone" type="tel" placeholder="Eg: 0194445555" class="form-control" pattern="^(01)[0-46-9]*[0-9]{7,8}$" required/>
                            </div>

							<div class="form-group">       
								<div class="text-center">
									<input type="submit" name="submit" value="Submit" class="btn btn-primary" style="background-color:#CFB53B; color:#000;">
								</div>
                                <div class="text-center">
									<a href="login.php" style="color:#CFB53B;">Back</a>
								</div>
                  			</div>
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
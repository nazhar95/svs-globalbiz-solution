<?php
	include("inc/dbconfig.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register | SVS GlobalBiz Solution</title>
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
    <link rel="shortcut icon" href="images/favicon.ico">
</head><!--/head-->

<body>
	<?php include("inc/header.php"); ?>
	<!--/header-->
	
	<section id="form"><!--form-->
		<div class="container text-center">
			<div class="row">
				<div class="col-md-12">
                    <a href="customer-register-page.php" style="text-decoration:none; color:white;"><button type="submit" class="btn btn-primary" style="width:200px; height:50px; margin-top: 100px;color:#000;background-color:#CFB53B;">Sign up as Customer!</button></a>
                </div>
                
                <div class="col-sm-12 text-center">
					<h3>OR</h3>
                </div>

                <div class="col-sm-12">
                <a href="admin-register-page.php" style="text-decoration:none; color:white;"><button type="submit" class="btn btn-primary" style="width:200px; height:50px; margin-top: 15px; margin-bottom:137px;color:#000;background-color:#CFB53B;">Sign up as Admin!</button></a>
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
    
</body>
</html>
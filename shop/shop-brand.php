<?php
    include("../inc/dbconfig.php");

    $brand_id=$_GET["brand_id"];

    if(isset($_POST['add-to-cart']))
	{
		$product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
		$product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
		$added_date = date("Y-m-d");
		$select_query = "SELECT * FROM cart_table
							WHERE product_id='$product_id' AND customer_id='$customer_id'";
		$result = mysqli_query($conn, $select_query)  or trigger_error("Query Failed! SQL: $select_query - Error: ".mysqli_error($conn), E_USER_ERROR);

		if (mysqli_num_rows($result) > 0) 
        {
			while($row = mysqli_fetch_assoc($result)) 
			{
				$previous_quantity=$row['quantity'];
				$new_quantity=$previous_quantity+$quantity;
				$total_price=$new_quantity*$product_price;
				$query = "UPDATE cart_table SET quantity='$new_quantity', total_price='$total_price' WHERE product_id='$product_id' AND customer_id='$customer_id'";
				$result1=mysqli_query($conn, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($conn), E_USER_ERROR);
			}	
		}
		else
		{
			$total_price=$quantity*$product_price;
			$query = "INSERT INTO cart_table (product_id,customer_id, quantity, total_price, added_date) VALUES ('$product_id','$customer_id','$quantity', '$total_price','$added_date')";        
			$result1=mysqli_query($conn, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($conn), E_USER_ERROR);
		}

        echo 
        (
            "<script language='JAVASCRIPT'>
                window.alert('Product successfully added to cart.');
                window.location.href='../customer/products-in-cart.php';
            </script>"
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
	<title>Shop Based on Brand | SVS GlobalBiz Solution</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/prettyPhoto.css" rel="stylesheet">
	<link href="../css/price-range.css" rel="stylesheet">
	<link href="../css/animate.css" rel="stylesheet">
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">
	<link rel="stylesheet" href="../style.css">
	<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
	<link rel="shortcut icon" href="../images/favicon.ico">
    <style>
        html, body { 
            height:100% !important;  
            margin:0 !important;
            padding:0 !important; 
		}
		
		a#scrollUp{
			background-color:#CFB53B;
		}
    </style>
</head>
<!--/head-->

<body>
	<?php include ("header-shop.php") ?>

	<section id="advertisement">
		<div class="container">
			<img src="images/shop/advertisement.jpg" alt="" />
		</div>
	</section>

	<section>
		<div class="container">
			<div class="row" style="margin-bottom:61px;">
				<div class="left-sidebar" >
					<div class="brands_products col-sm-3">
						<!--brands_products-->
						<h2 style="color:#CFB53B">Brands</h2>
						<div class="brands-name">
							<ul class="nav nav-pills nav-stacked">
							<?php
								$sql = "SELECT * FROM brand_table ORDER BY brand_name ASC";
								$result = mysqli_query($conn, $sql)  or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
						
								if (mysqli_num_rows($result) > 0) 
								{
									// output data of each row
									while($row = mysqli_fetch_assoc($result)) 
									{
										$brand = $row["brand_name"];  
										$brand_id = $row["brand_id"];

										echo 
										'
											<li><a href="shop-brand.php?brand_id='.$brand_id.'"><span class="pull-left">'.$brand.'</span></a></li><br>
										';
									}
								}
								else
								{
									echo "No results are found.";
								}
							?>
							</ul>
						</div>
					</div>
					<!--/brands_products-->
					<div class="col-sm-9 padding-right">
						<div class="features_items">
							<!--features_items-->
							<h2 class="title text-center" style="color:#CFB53B">
							<?php 
								$brand_id=$_GET["brand_id"];
								$select_brand_query = "SELECT * FROM product_info_table  
														LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
														LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id  
														WHERE product_info_table.stock!=0 AND brand_table.brand_id='$brand_id' ORDER BY latest_updated_date DESC";
								$result = mysqli_query($conn, $select_brand_query)  or trigger_error("Query Failed! SQL: $select_brand_query - Error: ".mysqli_error($conn), E_USER_ERROR);
							
								if (mysqli_num_rows($result) > 0) 
								{
									// output data of each row
									while($row = mysqli_fetch_assoc($result)) 
									{
										echo $row["brand_name"] . " " . "Products";
										break;
									}
								}
								else
								{
									echo "No products are found for this brand";
								}
							?> 
							</h2>
							
							<?php
							$brand_id=$_GET["brand_id"];
							$select_brand_query = "SELECT * FROM product_info_table  
													LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
													LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id  
													WHERE product_info_table.stock!=0 AND brand_table.brand_id='$brand_id' ORDER BY latest_updated_date DESC";
							$result = mysqli_query($conn, $select_brand_query)  or trigger_error("Query Failed! SQL: $select_brand_query - Error: ".mysqli_error($conn), E_USER_ERROR);

							if (mysqli_num_rows($result) > 0) 
							{
								// output data of each row
								while($row = mysqli_fetch_assoc($result)) 
								{
									echo
									'
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="data:image/png;base64,' . base64_encode($row['product_img']) . '"  alt="" width="300px" height="300px"/>
													<h4 style="font-size:8.7px">'.wordwrap($row['product_name'],150,"<br>\n").'</h4>
													<p style="font-size:8.7px">RM'.$row['product_price'].'</p>
													<a href="../product-details.php?product_id='.$row['product_id'].'" class="btn btn-info add-to-cart" style="background-color:#000; color:#CFB53B; width:100px;">
												 	View
													</a>
									';
									
									if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] = true) 
									{
										if($_SESSION["user_role"]!=1)
										{

											echo
											'
											<form method="POST" style="display:inline;">
												<input type="hidden" name="customer_id" value="'.$_SESSION['customer_id'].'">
												<input type="hidden" name="product_id" value="'.$row['product_id'].'">
												<input type="hidden" name="product_price" value="'.$row['product_price'].'">
												<input type="hidden" name="quantity" value="1">
												<input type="submit" name="add-to-cart" class="btn btn-default add-to-cart" style="background-color:#000;color:#CFB53B" value="Add to Cart">
											</form>
											';
										}
										else
										{
											echo '';
										}
									}
									
									echo
									'
												</div>
											</div>
										</div>
									</div> 
									'; 
									// continue;
								}
							}
							else
							{
								echo '<div style="text-align:center;">No products are found for this brand.</div>';
							}
						
							?>

							
							<!-- <div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<img src="images/shop/product11.jpg" alt="" />
											<h2>$56</h2>
											<p>Easy Polo Black Edition</p>
											<a href="#" class="btn btn-default add-to-cart"><i
													class="fa fa-shopping-cart"></i>Add to cart</a>
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i
														class="fa fa-shopping-cart"></i>Add to cart</a>
											</div>
										</div>
									</div>
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
											<li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<img src="images/shop/product10.jpg" alt="" />
											<h2>$56</h2>
											<p>Easy Polo Black Edition</p>
											<a href="#" class="btn btn-default add-to-cart"><i
													class="fa fa-shopping-cart"></i>Add to cart</a>
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i
														class="fa fa-shopping-cart"></i>Add to cart</a>
											</div>
										</div>
									</div>
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
											<li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
										</ul>
									</div>
								</div>
							</div> -->

							<!-- <ul class="pagination">
								<li class="active"><a href="">1</a></li>
								<li><a href="">2</a></li>
								<li><a href="">3</a></li>
								<li><a href="">&raquo;</a></li>
							</ul> -->
						</div>
						<!--features_items-->
					</div>
				</div>
			</div>
		</div>
	</section>

	<!--/Footer-->
	<?php include ("../inc/footer.php") ?>
	
	<script src="../js/jquery.js"></script>
	<script src="../js/price-range.js"></script>
	<script src="../js/jquery.scrollUp.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.prettyPhoto.js"></script>
	<script src="../js/main.js"></script>
</body>

</html>
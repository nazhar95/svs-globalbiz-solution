<?php
	include("inc/dbconfig.php");
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
                window.location.href='customer/products-in-cart.php';
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
	<title>Home | SVS GlobalBiz Solution</title>
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
		a#scrollUp{
			background-color:#CFB53B;
		}
	</style>
</head>
<!--/head-->

<body>
	<?php include("inc/header.php"); ?>
	<!--/header-->

	<section id="slider">
		<!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
						</ol>

						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<h1 style="color:black;">Welcome to</h1>
									<h2 style="color:#CFB53B;">SVS GlobalBiz Solution <br> E-Commerce</h2>
									<p>Shop for your health and beauty products now!</p>
								</div>
								<div class="col-sm-6">
									<img src="images/home/girl1.jpg" class="girl img-responsive" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<h1 style="color:black;">Dear Shoppers,</h1>
									<h2 style="color:#CFB53B;">Almost everything you search are here!</h2>
									<p>We deeply cared about your entire body, so we provide products that can make your skin feel soft, smooth, and clean.</p>
								</div>
								<div class="col-sm-6">
									<img src="images/home/girl3.jpg" class="girl img-responsive" alt="" />
								</div>
							</div>
						</div>

						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/slider-->

	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2 style="color:#CFB53B;">Category</h2>
						<div class="panel-group category-products" id="accordian">
							<!--category-productsr-->
							<?php
								$sql = "SELECT * FROM product_category_table ORDER BY product_category ASC";
								$result = mysqli_query($conn, $sql)  or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
						
								if (mysqli_num_rows($result) > 0) 
								{
									// output data of each row
									while($row = mysqli_fetch_assoc($result)) 
									{
										$category = $row["product_category"];  
										$category_id = $row["category_id"];

										echo 
										'
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a href="shop/shop-category.php?category_id='.$category_id.'">
														'.$category.'
													</a>
												</h4>
											</div>
										</div>
										';
									}
								}
								else{
									echo 
									'
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a href="#">
													No result is found
												</a>
											</h4>
										</div>
									</div>
									';
								}
							?>
						</div>
						<!--/category-products-->

						<div class="brands_products">
							<!--brands_products-->
							<h2 style="color:#CFB53B;">Brands</h2>
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
												<li><a href="shop/shop-brand.php?brand_id='.$brand_id.'"><span class="pull-left">'.$brand.'</span></a></li><br>
											';
										}
									}
									else{
										echo "No results are found.";
									}
								?>
								</ul>	
							</div>
						</div>
						<!--/brands_products-->

						<!-- <div class="price-range">
							<h2>Price Range</h2>
							<div class="well text-center">
								<input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
									data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br />
								<b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
							</div>
						</div>  -->
						<!--/price-range-->
					</div>
				</div>

				<div class="col-sm-9 padding-right">
					<div class="features_items">
						<!--features_items-->
						<h2 class="title text-center" style="color:#CFB53B;">Latest Products</h2>
						<?php
						$select_latest_product_query = "SELECT * FROM product_info_table  
														LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
														LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id 
														WHERE product_info_table.stock!=0 
														ORDER BY latest_updated_date DESC LIMIT 9";
                         $result = mysqli_query($conn, $select_latest_product_query)  or trigger_error("Query Failed! SQL: $select_latest_product_query - Error: ".mysqli_error($conn), E_USER_ERROR);

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
												<img src="data:image/png;base64,' . base64_encode($row['product_img']) . '"  alt="" width="300px" height="300px" />
												<h4 style="font-size:8.7px">'.wordwrap($row['product_name'],150,"<br>\n").'</h4>
												<p style="font-size:8.7px">RM'.$row['product_price'].'</p>
												<a href="product-details.php?product_id='.$row['product_id'].'" class="btn btn-info add-to-cart" style="background-color:#000; color:#CFB53B; width:100px;">
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
												<input type="submit" name="add-to-cart" class="btn btn-default add-to-cart" style="background-color:#000; color:#CFB53B" value="Add to Cart">
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
							}
						}
						else
						{
							echo '<div style="text-align:center;">No products are found.</div>';
						}
						?>
					</div>
					<!--features_items-->
				</div>
			</div>
		</div>
	</section>

	<!--/Footer-->
	<?php include("inc/footer.php") ?>

	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
	<script src="js/jquery.prettyPhoto.js"></script>
	<script src="js/main.js"></script>
</body>

</html>
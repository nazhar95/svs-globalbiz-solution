<?php
    include("session-customer.php");
        
    if(isset($_POST['confirmOrder'])){
        $customer_id=$_SESSION["customer_id"];
        $receiver_name=mysqli_real_escape_string($conn, $_POST['receiver_name']); 
        $receiver_address=mysqli_real_escape_string($conn, $_POST['receiver_address']);   
        $receiver_phone=mysqli_real_escape_string($conn, $_POST['receiver_phone']);          
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $ordered_quantity=mysqli_real_escape_string($conn, $_POST['quantity']);
        $total_payment=mysqli_real_escape_string($conn, $_POST['total_price']);   
        $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
        $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);
        $ordered_date = mysqli_real_escape_string($conn, $_POST['ordered_date']);
       
        //insert into the products_ordered_table
        $insert_query = "INSERT INTO products_ordered_table (product_id,ordered_quantity,total_payment,customer_id,receiver_name,receiver_address,receiver_phone,order_status,ordered_date, admin_id) VALUES ('$product_id','$ordered_quantity','$total_payment','$customer_id','$receiver_name','$receiver_address','$receiver_phone','$order_status','$ordered_date','$admin_id')";        
        $result=mysqli_query($conn, $insert_query) or trigger_error("Query Failed! SQL: $insert_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        //update the cart_table (remove the items that has been placed order)
        $update_cart_query = "DELETE FROM cart_table WHERE cart_id='$cart_id'";
        $result2=mysqli_query($conn, $update_cart_query) or trigger_error("Query Failed! SQL: $update_cart_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        echo 
        (
            "<script language='JAVASCRIPT'>
                window.alert('Order is placed. Please proceed for payment.');
                window.location.href='payment.php?product_id=".$product_id."';
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
    <title>Multiple Items Checkout Page  | SVS GlobalBiz Solution</title>
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
       .sidebar .nav .nav-item.active > .nav-link i, .sidebar .nav .nav-item.active > .nav-link .menu-title, .sidebar .nav .nav-item.active > .nav-link .menu-arrow {
            color:#CFB53B;
        }
    </style>
    <script src="https://cdn.tiny.cloud/1/jqlvox6zxpy1h5n6mugmaw019hu1420xuak30zt7eavn5zdh/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
    <div class="container-scroller">
        <!-- heder -->
        <?php include("header-customer.php"); ?>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
        <!-- sidebar -->
        <?php include("sidebar-customer.php"); ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                    <h4 class="font-weight-bold mb-0">Confirm Details and Payment</h4>
                    </div> 
                </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <form class="forms-sample" id="checkoutForm" method="POST">
                        <label><b>Product Information</b></label>
                        <div class="row border border-dark">
                            <div class="col-sm-6 border border-dark">
                                <b>Product Names</b>
                            </div>
                            <div class="col-sm-3 border border-dark text-center">
                                <b>Quantity</b>
                            </div>
                            <div class="col-sm-3 border border-dark text-center">
                                <b>Total Price (RM)</b>
                            </div>
                        </div>
                    <?php
                        //Selecting the information from the cart_table for a particular customer
                        $customer_id=$_GET['customer_id'];
                        $sql = "SELECT * FROM product_info_table  
                                LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id
                                LEFT JOIN cart_table ON product_info_table.product_id = cart_table.product_id
                                WHERE customer_id='$customer_id'";
                        $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
                            
                        if (mysqli_num_rows($result) > 0) 
                        {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) 
                            {
                                $cart_id = $row["cart_id"];
                                $category = $row["product_category"];
                                $category_id = $row["category_id"];
                                $brand = $row["brand_name"];  
                                $brand_id = $row["brand_id"];
                                $product_id = $row["product_id"];
                                $product_name = $row["product_name"];
                                $total_price = number_format($row["total_price"],2);
                                $product_desc = $row["product_desc"];
                                $product_img = $row["product_img"];
                                $added_date = $row["added_date"];
                                $quantity=$row["quantity"];
                                $checkout_date = date("Y-m-d");
                                $admin_id=$row["admin_id"];

                                echo
                                '  
                                    <div class="row border border-dark">
                                        <div class="col-sm-6 border border-dark">
                                            '.$product_name.'
                                        </div>
                                        <div class="col-sm-3 border border-dark text-center">
                                            '.$quantity.'
                                        </div>
                                        <div class="col-sm-3 border border-dark text-center">
                                            '.$total_price.'
                                        </div>
                                    </div> 
                                    <input type="hidden" value="'.$product_id.'" name="product_id">
                                    <input type="hidden" value="'.$cart_id.'" name="cart_id">
                                    <input type="hidden" value="'.$total_price.'" name="total_price">
                                    <input type="hidden" value="'.$quantity.'" name="quantity">
                                                                      
                                ';
                            }
                        }

                        //Retrieve the overall price for the products that the customer added into cart
                        $sql = "SELECT *, SUM(total_price) FROM product_info_table  
                                LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id
                                LEFT JOIN cart_table ON product_info_table.product_id = cart_table.product_id
                                WHERE customer_id='$customer_id'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) 
                        {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) 
                            {
                                $cart_id = $row["cart_id"];
                                $category = $row["product_category"];
                                $category_id = $row["category_id"];
                                $brand = $row["brand_name"];  
                                $brand_id = $row["brand_id"];
                                $product_id = $row["product_id"];
                                $product_name = $row["product_name"];
                                $total_price = number_format($row["total_price"],2);
                                $product_desc = $row["product_desc"];
                                $product_img = $row["product_img"];
                                $added_date = $row["added_date"];
                                $quantity=$row["quantity"];
                                $checkout_date = date("Y-m-d");
                                $overall_price = number_format($row['SUM(total_price)'], 2);

                                echo
                                '
                                        <div class="row">
                                            <div class="col-sm-6"></div>
                                            <div class="col-sm-3 text-right border border-dark"><b>Overall Price (RM)</b>: </div>
                                            <div class="col-sm-3 text-center border border-dark" >
                                                '.$overall_price.'
                                            </div>
                                        </div>    
                                    
                                ';
                            }
                        }
                        
                        
                        //Retrieve customer detail
                        $customer_id=$_SESSION["customer_id"];        
                        $select_customer_query="SELECT * FROM customer_table WHERE customer_id='$customer_id'";
                        $result = mysqli_query($conn, $select_customer_query) or trigger_error("Query Failed! SQL: $select_customer_query - Error: ".mysqli_error($conn), E_USER_ERROR);
                        if (mysqli_num_rows($result) > 0) 
                        {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) 
                            {
                                $ordered_date=date("Y-m-d");

                                echo
                                '
                                    <hr>
                                    <div class="form-group">
                                        <label><b>Receiver Name</b></label>
                                        <input class="form-control" name="receiver_name" value="'.$row['full_name'].'" required>
                                    </div>
                                    <div class="form-group">
                                        <label><b>Receiver Address</b></label>
                                        <input class="form-control" name="receiver_address" value="'.$row['address'].'" required>
                                    </div>
                                    <div class="form-group">
                                        <label><b>Receiver Phone No.</b></label>
                                        <input class="form-control" name="receiver_phone" value="'.$row['phone'].'" required>
                                    </div>
                                    <input type="hidden" name="ordered_date" value="'.$ordered_date.'">
                                ';     
                            }
                        }
                        else
                        {
                            echo '';
                        }
                        ?> 
                        
                        <input type="hidden" name="order_status" value="Pending payment">
                        <input type="submit" name="confirmOrder" id="confirmOrder" class="btn btn-warning mr-2 text-light" value="Place Order">
                        <a href="products-in-cart.php"><input type="button" class="btn btn-danger mr-2 text-light" value="Cancel"></a>
                    </form>
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
        $('#checkoutForm').submit(function() {  
            return confirm("Are you sure the details are correct and your want to order the product?");
        });
    </script>
    <!-- End custom js for this page-->
</body>

</html>


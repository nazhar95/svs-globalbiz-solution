<?php
    include("session-customer.php");
        
    if(isset($_POST['confirmPayment'])){
        $customer_id=$_SESSION["customer_id"];
        $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);       
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $ordered_quantity=mysqli_real_escape_string($conn, $_POST['ordered_quantity']);
        $tracking_status = mysqli_real_escape_string($conn, $_POST['tracking_status']);
        $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);
        $latest_updated_date = date("Y-m-d");
       
        //update order_status to Paid in the products_ordered_table
        $update_order_query = "UPDATE products_ordered_table SET order_status='$order_status' WHERE customer_id='$customer_id' AND order_id='$order_id'";  
        $result=mysqli_query($conn, $update_order_query) or trigger_error("Query Failed! SQL: $update_order_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        //remove stock from the product_info_table        
        $remove_stock_query = "UPDATE product_info_table SET stock=(stock-'$ordered_quantity') WHERE product_id='$product_id'";  
        $result1=mysqli_query($conn, $remove_stock_query) or trigger_error("Query Failed! SQL: $remove_stock_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        // //insert status into tracking table
        $track_query="INSERT INTO track_order_table (order_id, tracking_status, latest_updated_date) VALUES ('$order_id','$tracking_status','$latest_updated_date')";
        $result2=mysqli_query($conn, $track_query) or trigger_error("Query Failed! SQL: $track_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        echo 
        (
            "<script language='JAVASCRIPT'>
                window.alert('Thank you for your order. Your order will be processed and shipped soon by the admin.');
                window.location.href='products-ordered-page.php';
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
    <title>Payment Page  | SVS GlobalBiz Solution</title>
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
            color:#000;
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
                    <h4 class="font-weight-bold mb-0">Payment</h4>
                    </div> 
                </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <form class="forms-sample" id="paymentForm" method="POST">
                        
                    <?php
                        //Selecting the information from the cart_table
                        $product_id=$_GET['product_id'];
                        $customer_id=$_SESSION['customer_id'];
                        $sql = "SELECT * FROM product_info_table  
                                LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id
                                LEFT JOIN products_ordered_table ON product_info_table.product_id = products_ordered_table.product_id
                                WHERE products_ordered_table.product_id='$product_id' AND customer_id='$customer_id' AND order_status='Pending payment'";
                        $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
                            
                        if (mysqli_num_rows($result) > 0) 
                        {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) 
                            {
                                $product_id = $row["product_id"];
                                $product_name = $row["product_name"];
                                $total_payment = number_format($row["total_payment"],2);

                                echo
                                '  
                                    <div class="p-3 border border-dark">
                                        <p><b>Pay to</b>:</p> 
                                        <p>SVS GlobalBiz Solution</p>
                                        <br>
                                        <p><b>Amount to Pay (RM)</b>:</p>
                                        <p>'.$total_payment.'</p> 
                                    </div>
                                    <br>
                                    <input type="hidden" name="order_id" value="'.$row["order_id"].'">
                                    <input type="hidden" name="ordered_quantity" value="'.$row["ordered_quantity"].'">
                                    <input type="hidden" name="product_id" value="'.$product_id.'">
                                    <input type="hidden" name="total_payment" value="'.$total_payment.'">
                                    <input type="hidden" name="order_status" value="Paid">
                                    <input type="hidden" name="tracking_status" value="Processing">
                                ';
                            }
                        }
                            
                        ?> 
                        
                        <input type="submit" name="confirmPayment" id="confirmPayment" class="btn btn-warning mr-2 text-light" value="Pay">
                        <a href="products-ordered-page.php"><input type="button" class="btn btn-danger mr-2 text-light" value="Cancel"></a>
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
        $('#paymentForm').submit(function() {  
            return confirm("Are you sure the details are correct and your want to pay for the product?");
        });
    </script>
    <!-- End custom js for this page-->
</body>

</html>


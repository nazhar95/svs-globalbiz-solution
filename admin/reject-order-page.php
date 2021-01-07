<?php
    include("session-admin.php");

    if (isset($_POST['btnRejectOrder']))
    {
        $reject_date=date("Y-m-d");
        $latest_updated_date=date("Y-m-d");
        $admin_id=$_SESSION["admin_id"];
        $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']); 
        $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
        $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);
        $reject_reason = mysqli_real_escape_string($conn, $_POST['reject_reason']);
        $reject_status="Order rejected by admin";

        //update the order status in the products_ordered_table
        $update_products_ordered_table_query="UPDATE products_ordered_table SET order_status='Rejected', total_payment='0' WHERE order_id='$order_id'";
        $result1 = mysqli_query($conn, $update_products_ordered_table_query) or trigger_error("Query Failed! SQL: $update_products_ordered_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        //update the tracking status in the track_order_table
        $update_track_order_table_query="UPDATE track_order_table SET tracking_status='N/A due to order rejected by admin' WHERE order_id='$order_id'";
        $result1 = mysqli_query($conn, $update_track_order_table_query) or trigger_error("Query Failed! SQL: $update_track_order_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        //insert into the reject_order_table
        $insert_reject_order_query="INSERT INTO reject_order_table (order_id, customer_id, admin_id, reject_status, reject_reason, reject_date) VALUES ('$order_id','$customer_id','$admin_id','$reject_status','$reject_reason','$reject_date')"; 
        $result2 = mysqli_query($conn, $insert_reject_order_query) or trigger_error("Query Failed! SQL: $insert_reject_order_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        echo 
        (
            "<script language='JAVASCRIPT'>
                window.alert('Thank you. Your request to reject the order is successful and the refund will be made to the buyer.');
                window.location.href='customer-orders-page.php';
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
    <title>Reject Order Page | SVS GlobalBiz Solution</title>
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
        .nav-pills .nav-link.active, .nav-pills .show > .nav-link 
        {
            color: #fff;
            background-color: #CFB53B !important;
        }

        .sidebar .nav .nav-item.active > .nav-link i, .sidebar .nav .nav-item.active > .nav-link .menu-title, .sidebar .nav .nav-item.active > .nav-link .menu-arrow {
        color:#000;
        }
    </style>
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
                    <h4 class="font-weight-bold mb-0">Reject Order</h4>
                    </div> 
                </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <form class="forms-sample" method="POST" name="reject-order-form">
                    <?php
                       $admin_id=$_SESSION["admin_id"];
                       $order_id=$_GET['order_id'];
                       $sql = "SELECT * FROM products_ordered_table
                               LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id
                               LEFT JOIN track_order_table ON products_ordered_table.order_id=track_order_table.order_id
                               LEFT JOIN customer_table ON products_ordered_table.customer_id = customer_table.customer_id
                               WHERE products_ordered_table.admin_id='$admin_id' AND products_ordered_table.order_id='$order_id'";
                        $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
                    
                        if (mysqli_num_rows($result) > 0) 
                        {
                            while($row = mysqli_fetch_assoc($result)) 
                            {
                                echo
                                '
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12 border border-dark p-3">
                                            <h4>Ordered Product Information</h4> 
                                            <p><b>Product Name:</b> '.$row['product_name'].' </p>
                                            <p><b>Quantity Ordered:</b> '.$row['ordered_quantity'].'</p>
                                            <p><b>Total Payment (RM):</b> '.$row['total_payment'].'</p>
                                            <p><b>Order Status:</b>'.$row['order_status'].'</p>
                                            <hr>
                                            <h4>Customer Information</h4>
                                            <p><b>Customer Name</b>: '.$row['full_name'].'</p>
                                            <p><b>Customer Phone No</b>: '.$row['phone'].'</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 p-2">
                                            <h4>Reason to reject the order</h4> 
                                            <div class="radio">
                                                <label><input type="radio" name="reject_reason" value="Admin cannot ship due to MCO between states" checked> Cannot ship due to Movement Control Order (MCO)</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="reject_reason" value="Admin current order load does not allow the admin to accept this order"> My current order load does not allow me to accept this order</label>
                                            </div>
                                            <div class="radio disabled">
                                                <label><input type="radio" name="reject_reason" value="Admin is not available during this time"> My schedule doesn’t allow me to take this order right now</label>
                                            </div>
                                            <input type="hidden" name="order_id" value="'.$order_id.'">
                                            <input type="hidden" name="order_status" value="'.$row['order_status'].'">
                                            <input type="hidden" name="customer_id" value="'.$row['customer_id'].'">
                                            <input type="submit" name="btnRejectOrder" class="btn btn-sm mt-2 text-light" style="background-color:orange;" value="Reject Order">
                                            <a href="products-ordered-page.php"><input type="button" class="btn btn-sm btn-danger mt-2 text-light" value="Cancel"></a>
                                        </div>
                                    </div>
                                </div>     
                                ';
                            }
                        }
                        else
                        {
                            echo
                            '
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 border border-dark p-3">
                                        <h4>Ordered Product Information</h4> 
                                        <p>No result found</p>
                                    </div>
                                </div>
                            </div> 
                            ';   
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
        $('#reject-order-form').submit(function() {  
            return confirm("Are you sure you want to reject this customer's order?");
        });
    </script>
    <!-- End custom js for this page-->
</body>

</html>


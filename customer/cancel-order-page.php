<?php
    include("session-customer.php");

    if (isset($_POST['btnCancelOrder']))
    {
        $cancel_date=date("Y-m-d");
        $latest_updated_date=date("Y-m-d");
        $customer_id=$_SESSION["customer_id"]; 
        $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
        $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
        $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);
        $cancel_reason = mysqli_real_escape_string($conn, $_POST['cancel_reason']);
        $cancel_status="To be approved by admin";

        //update the order status in the products_ordered_table
        $update_products_ordered_table_query="UPDATE products_ordered_table SET order_status='Cancelled' WHERE order_id='$order_id'";
        $result1 = mysqli_query($conn, $update_products_ordered_table_query) or trigger_error("Query Failed! SQL: $update_products_ordered_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        //insert into the cancel_order_table
        $insert_cancel_order_query="INSERT INTO canceL_order_table (order_id, customer_id, admin_id, cancel_reason, cancel_status, cancel_date) VALUES ('$order_id','$customer_id', '$admin_id','$cancel_reason','$cancel_status','$cancel_date')"; 
        $result2 = mysqli_query($conn, $insert_cancel_order_query) or trigger_error("Query Failed! SQL: $insert_cancel_order_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        echo 
        (
            "<script language='JAVASCRIPT'>
                window.alert('Thank you. Your cancellation is being processed.');
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
    <title>Cancel Order Page | SVS GlobalBiz Solution</title>
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
                    <h4 class="font-weight-bold mb-0">Cancel Order</h4>
                    </div> 
                </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <form class="forms-sample" method="POST" name="cancel-order-form">
                    <?php
                       $customer_id=$_SESSION["customer_id"];
                       $order_id=$_GET['order_id'];
                       $sql = "SELECT * FROM products_ordered_table
                               LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id
                               LEFT JOIN track_order_table ON products_ordered_table.order_id=track_order_table.order_id
                               WHERE products_ordered_table.customer_id='$customer_id' AND products_ordered_table.order_id='$order_id'";
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
                                            <p><b>Order Status:</b> '.$row['order_status'].'</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 p-2">
                                            <h4>Reason for cancellation</h4> 
                                            <div class="radio">
                                                <label><input type="radio" name="cancel_reason" value="Change of mind" checked> Change of mind</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="cancel_reason" value="Decided for an alternative product"> Decided for an alternative product</label>
                                            </div>
                                            <div class="radio disabled">
                                                <label><input type="radio" name="cancel_reason" value="Duplicated order"> Duplicated order</label>
                                            </div>
                                            <div class="radio disabled">
                                                <label><input type="radio" name="cancel_reason" value="Wrong quantity ordered"> Wrong quantity ordered</label>
                                            </div>
                                            <input type="hidden" name="order_id" value="'.$order_id.'">
                                            <input type="hidden" name="order_status" value="'.$row['order_status'].'">
                                            <input type="hidden" name="admin_id" value="'.$row['admin_id'].'">
                                            <input type="submit" name="btnCancelOrder" class="btn btn-sm mt-2 text-light" style="background-color:orange;" value="Cancel Order">
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
        $('#cancel-order-form').submit(function() {  
            return confirm("Are you sure you want to cancel your order?");
        });
    </script>
    <!-- End custom js for this page-->
</body>

</html>


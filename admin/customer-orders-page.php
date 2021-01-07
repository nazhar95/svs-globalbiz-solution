<?php
  include("session-admin.php");

  if (isset($_POST['btnAccept']))
  {
    $admin_id=$_SESSION["admin_id"]; 
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $latest_updated_date=date("Y-m-d");

    //update products_ordered_table
    $update_products_ordered_table_query="UPDATE products_ordered_table SET order_status='Accepted' WHERE order_id='$order_id'";
    $result1 = mysqli_query($conn, $update_products_ordered_table_query) or trigger_error("Query Failed! SQL: $update_products_ordered_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

    //update track_order_table
    $update_track_status_query="UPDATE track_order_table SET tracking_status='Preparing', latest_updated_date='$latest_updated_date'  WHERE order_id='$order_id'";
    $result2 = mysqli_query($conn, $update_track_status_query) or trigger_error("Query Failed! SQL: $update_track_status_query - Error: ".mysqli_error($conn), E_USER_ERROR);

    echo 
    (
        "<script language='JAVASCRIPT'>
            window.alert('You have accepted the customer order. Please make sure that you update the tracking status for the product periodically.');
            window.location.href='customer-orders-page.php';
        </script>"
    );
  }

  if (isset($_POST['btnAcceptCancel']))
  {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $tracking_status = mysqli_real_escape_string($conn, $_POST['tracking_status']);
    $ordered_quantity = mysqli_real_escape_string($conn, $_POST['ordered_quantity']);
    $cancel_status="Accepted by admin";
    
    if($tracking_status!="")
    {
        //update the stock of the products
        $update_stock_query = "UPDATE product_info_table SET stock=(stock+'$ordered_quantity') WHERE product_id='$product_id'";  
        $result1=mysqli_query($conn, $update_stock_query) or trigger_error("Query Failed! SQL: $update_stock_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        //update the order status in the products_ordered_table
        $update_products_ordered_table_query="UPDATE products_ordered_table SET order_status='Cancelled', total_payment='0' WHERE order_id='$order_id'";
        $result1 = mysqli_query($conn, $update_products_ordered_table_query) or trigger_error("Query Failed! SQL: $update_products_ordered_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        //update the tracking status in the track_order_table
        $update_track_order_table_query="UPDATE track_order_table SET tracking_status='N/A due to order cancelled' WHERE order_id='$order_id'";
        $result2 = mysqli_query($conn, $update_track_order_table_query) or trigger_error("Query Failed! SQL: $update_track_order_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        //update the cancel status in the cancel_order_table
        $update_cancel_order_table_query="UPDATE cancel_order_table SET cancel_status='$cancel_status' WHERE order_id='$order_id'";
        $result3 = mysqli_query($conn, $update_cancel_order_table_query) or trigger_error("Query Failed! SQL: $update_cancel_order_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        echo 
        (
            "<script language='JAVASCRIPT'>
                window.alert('You have accepted the cancellation request. The payment made by the customer will be refunded.');
                window.location.href='customer-orders-page.php';
            </script>"
        );
    }
    else
    {
        //update the order status in the products_ordered_table
        $update_products_ordered_table_query="UPDATE products_ordered_table SET order_status='Cancelled', total_payment='0' WHERE order_id='$order_id'";
        $result1 = mysqli_query($conn, $update_products_ordered_table_query) or trigger_error("Query Failed! SQL: $update_products_ordered_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        //update the cancel status in the cancel_order_table
        $update_cancel_order_table_query="UPDATE cancel_order_table SET cancel_status='$cancel_status' WHERE order_id='$order_id'";
        $result2 = mysqli_query($conn, $update_cancel_order_table_query) or trigger_error("Query Failed! SQL: $update_cancel_order_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        echo 
        (
            "<script language='JAVASCRIPT'>
                window.alert('You have accepted the cancellation request.');
                window.location.href='customer-orders-page.php';
            </script>"
        );
    }
  }

  if (isset($_POST['btnDeclineCancel']))
  {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $cancel_status="Declined by admin";
    
    //update the order status in the products_ordered_table
    $update_products_ordered_table_query="UPDATE products_ordered_table SET order_status='Accepted' WHERE order_id='$order_id'";
    $result1 = mysqli_query($conn, $update_products_ordered_table_query) or trigger_error("Query Failed! SQL: $update_products_ordered_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

    //update the cancel status in the cancel_order_table
    $update_cancel_order_table_query="UPDATE cancel_order_table SET cancel_status='$cancel_status' WHERE order_id='$order_id'";
    $result2 = mysqli_query($conn, $update_cancel_order_table_query) or trigger_error("Query Failed! SQL: $update_cancel_order_table_query - Error: ".mysqli_error($conn), E_USER_ERROR);

    echo 
    (
        "<script language='JAVASCRIPT'>
            window.alert('You have declined the cancellation request. Please make sure that you contact the customer to inform the reason.');
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
  <title>Customer Order List | SVS GlobalBiz Solution</title>
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
                        <h4 class="font-weight-bold mb-0">Customer Order List</h4>
                        </div> 
                    </div>
                    </div>
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link text-dark active" id="pills-new-order-tab" data-toggle="pill" href="#pills-new-order" role="tab" aria-controls="pills-new-order" aria-selected="true">New Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-accept-order-tab" data-toggle="pill" href="#pills-accept-order" role="tab" aria-controls="pills-accept-order" aria-selected="false">Accepted Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-completed-order-tab" data-toggle="pill" href="#pills-completed-order" role="tab" aria-controls="pills-completed-order" aria-selected="false">Completed Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-cancel-order-tab" data-toggle="pill" href="#pills-cancel-order" role="tab" aria-controls="pills-cancel-order" aria-selected="false">Cancelled Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-rejected-order-tab" data-toggle="pill" href="#pills-rejected-order" role="tab" aria-controls="pills-rejected-order" aria-selected="false">Rejected Order</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-new-order" role="tabpanel" aria-labelledby="pills-new-order-tab">
                                        <div class="table-responsive pt-3">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th style="width:150px;">
                                                        Ordered Date
                                                    </th>
                                                    <th style="width:300px;">
                                                        Product information
                                                    </th>
                                                    <th style="width:300px;">
                                                        Receiver information
                                                    </th>
                                                    <th style="width:180px;">
                                                        Ordered Quantity
                                                    </th>
                                                    <th style="width:180px;">
                                                        Total Payment (RM)
                                                    </th>
                                                    <th style="width:120px;" colspan="2">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                //Selecting the information of the products ordered
                                                $admin_id=$_SESSION["admin_id"];
                                                $sql = "SELECT * FROM product_info_table  
                                                        LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                                                        LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id
                                                        LEFT JOIN products_ordered_table ON products_ordered_table.product_id = product_info_table.product_id
                                                        WHERE products_ordered_table.admin_id='$admin_id' AND order_status='Paid' ORDER BY ordered_date DESC";
                                                $result = mysqli_query($conn, $sql);
                                                
                                                if (mysqli_num_rows($result) > 0) 
                                                {
                                                    // output data of each row
                                                    while($row = mysqli_fetch_assoc($result)) 
                                                    {
                                                        $order_id = $row["order_id"];
                                                        $receiver_name = $row["receiver_name"];
                                                        $receiver_address = $row["receiver_address"];
                                                        $receiver_phone = $row["receiver_phone"];  
                                                        $brand_id = $row["brand_id"];
                                                        $product_id = $row["product_id"];
                                                        $product_name = $row["product_name"];
                                                        $total_payment = number_format($row["total_payment"],2);
                                                        $product_desc = $row["product_desc"];
                                                        $product_img = $row["product_img"];
                                                        $ordered_date = $row["ordered_date"];
                                                        $ordered_quantity=$row["ordered_quantity"];
                                                        //$total_price = number_format($row['SUM(product_price)'], 2);

                                                        echo
                                                        '
                                                            <tr>
                                                                <td>'.$ordered_date.'</td>
                                                                <td style="text-align:center;">
                                                                <b>'.$product_name.'</b><br>
                                                                <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:200px; height:200px;" />
                                                                </td>
                                                                <td style="text-align:left;">
                                                                    <p><b>Name</b>:</p>
                                                                    <p>'.$receiver_name.'</p>
                                                                    <br>
                                                                    <p><b>Address</b>:</p>
                                                                    <p>'.$receiver_address.'</p>
                                                                    <br>
                                                                    <p><b>Phone</b>:</p>
                                                                    <p>'.$receiver_phone.'</p>
                                                                </td>
                                                                <td>
                                                                '.$ordered_quantity.' 
                                                                </td>
                                                                <td>'.$total_payment.'</td>
                                                                
                                                                <td align="center">
                                                                    <form method="POST" name="acceptForm" id="acceptForm" class="mb-2">
                                                                        <input type="hidden" value="' . $order_id . '" name="order_id">
                                                                        <button type="submit" class="btn btn-block btn-success btn-xs" style="width:120px;" name="btnAccept" id="' . $order_id . '" title="Accept Order">Accept Order</button>
                                                                    </form>
                                                                        <input type="hidden" value="' . $order_id . '" name="order_id">
                                                                        <a href="reject-order-page.php?order_id='.$row['order_id'].'" class="btn btn-block btn-danger btn-xs" style="color:white; text-decoration:none;width:120px;" name="btnReject" id="' . $order_id . '" title="Reject Order">Reject Order</a>
                                                                    <br>
                                                                    
                                                                </td>
                                                            </tr>
                                                        ';
                                                    }
                                                } 
                                                else 
                                                {
                                                    echo
                                                    '
                                                        <tr>
                                                        <td colspan="9">
                                                            <p style="text-align:center">No result found</p>
                                                        </td>
                                                        </tr>
                                                    ';
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-accept-order" role="tabpanel" aria-labelledby="pills-accept-order-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th style="width:150px;">
                                                            Ordered Date
                                                        </th>
                                                        <th style="width:250px;">
                                                            Product information
                                                        </th>
                                                        <th style="width:300px;">
                                                            Receiver information
                                                        </th>
                                                        <th style="width:180px;">
                                                            Ordered Quantity
                                                        </th>
                                                        <th style="width:180px;">
                                                            Total Payment (RM)
                                                        </th>
                                                        <th style="width:180px;">
                                                            Tracking status    
                                                        </th>
                                                        <th style="width:150px;">
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    //Selecting the information of the products 
                                                    $admin_id=$_SESSION["admin_id"];
                                                    $sql = "SELECT * FROM products_ordered_table
                                                            LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id
                                                            LEFT JOIN track_order_table ON products_ordered_table.order_id=track_order_table.order_id
                                                            WHERE products_ordered_table.admin_id='$admin_id' AND order_status='Accepted' ORDER BY ordered_date DESC";
                                                    $result = mysqli_query($conn, $sql);
                                                    
                                                    if (mysqli_num_rows($result) > 0) 
                                                    {
                                                        // output data of each row
                                                        while($row = mysqli_fetch_assoc($result)) 
                                                        {
                                                            $order_id = $row["order_id"];
                                                            $receiver_name = $row["receiver_name"];
                                                            $receiver_address = $row["receiver_address"];
                                                            $receiver_phone = $row["receiver_phone"];  
                                                            $brand_id = $row["brand_id"];
                                                            $product_id = $row["product_id"];
                                                            $product_name = $row["product_name"];
                                                            $total_payment = number_format($row["total_payment"],2);
                                                            $product_desc = $row["product_desc"];
                                                            $product_img = $row["product_img"];
                                                            $ordered_date = $row["ordered_date"];
                                                            $ordered_quantity=$row["ordered_quantity"];
                                                            $tracking_status = $row["tracking_status"];
                                                            $latest_updated_date=$row['latest_updated_date'];

                                                            echo
                                                            '
                                                            <tr>
                                                                <td>'.$ordered_date.'</td>
                                                                <td style="text-align:center;">
                                                                <b>'.$product_name.'</b><br>
                                                                <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:200px; height:200px;" />
                                                                </td>
                                                                <td style="text-align:left;">
                                                                    <p><b>Name</b>:</p>
                                                                    <p>'.$receiver_name.'</p>
                                                                    <br>
                                                                    <p><b>Address</b>:</p>
                                                                    <p>'.$receiver_address.'</p>
                                                                    <br>
                                                                    <p><b>Phone</b>:</p>
                                                                    <p>'.$receiver_phone.'</p>
                                                                </td>
                                                                <td>'.$ordered_quantity.' </td>
                                                                <td>'.$total_payment.'</td>
                                                                <td>
                                                                    '.$tracking_status.'<br>
                                                                    <span style="font-size:12px;color:orange;">Latest update on:<br> '.$latest_updated_date.'</span>
                                                                </td>
                                                                <td>
                                                                    <form method="POST" name="updateTrackingStatusForm" id="updateTrackingStatusForm" class="mb-2">
                                                                        <input type="hidden" value="' . $order_id . '" name="order_id">
                                                                        <a href="edit-tracking-status.php?order_id='.$order_id.'" class="btn btn-block btn-xs btn-dark text-light" name="btnUpdateTrackingStatus" id="' . $order_id . '" title="Update Tracking Status">Update<br>Tracking Status</a>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            ';
                                                        }
                                                    } 
                                                    else 
                                                    {
                                                        echo
                                                        '
                                                            <tr>
                                                            <td colspan="9">
                                                                <p style="text-align:center">No result found</p>
                                                            </td>
                                                            </tr>
                                                        ';
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-completed-order" role="tabpanel" aria-labelledby="pills-completed-order-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th style="width:150px;">
                                                            Ordered Date
                                                        </th>
                                                        <th style="width:300px;">
                                                            Product information
                                                        </th>
                                                        <th style="width:300px;">
                                                            Receiver information
                                                        </th>
                                                        <th style="width:180px;">
                                                            Ordered Quantity
                                                        </th>
                                                        <th style="width:180px;">
                                                            Total Payment (RM)
                                                        </th>
                                                        <th style="width:180px">
                                                            Tracking status    
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    //Selecting the information of the products 
                                                    $admin_id=$_SESSION["admin_id"];
                                                    $sql = "SELECT * FROM products_ordered_table
                                                            LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id
                                                            LEFT JOIN track_order_table ON products_ordered_table.order_id=track_order_table.order_id
                                                            WHERE products_ordered_table.admin_id='$admin_id' AND order_status='Completed' ORDER BY track_order_table.latest_updated_date DESC";
                                                    $result = mysqli_query($conn, $sql);
                                                    
                                                    if (mysqli_num_rows($result) > 0) 
                                                    {
                                                        // output data of each row
                                                        while($row = mysqli_fetch_assoc($result)) 
                                                        {
                                                            $order_id = $row["order_id"];
                                                            $receiver_name = $row["receiver_name"];
                                                            $receiver_address = $row["receiver_address"];
                                                            $receiver_phone = $row["receiver_phone"];  
                                                            $brand_id = $row["brand_id"];
                                                            $product_id = $row["product_id"];
                                                            $product_name = $row["product_name"];
                                                            $total_payment = number_format($row["total_payment"],2);
                                                            $product_desc = $row["product_desc"];
                                                            $product_img = $row["product_img"];
                                                            $ordered_date = $row["ordered_date"];
                                                            $ordered_quantity=$row["ordered_quantity"];
                                                            $tracking_status = $row["tracking_status"];
                                                            $latest_updated_date=$row["latest_updated_date"];

                                                            echo
                                                            '
                                                            <tr>
                                                                <td>'.$ordered_date.'</td>
                                                                <td style="text-align:center;">
                                                                <b>'.$product_name.'</b><br>
                                                                <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:200px; height:200px;" />
                                                                </td>
                                                                <td style="text-align:left;">
                                                                    <p><b>Name</b>:</p>
                                                                    <p>'.$receiver_name.'</p>
                                                                    <br>
                                                                    <p><b>Address</b>:</p>
                                                                    <p>'.$receiver_address.'</p>
                                                                    <br>
                                                                    <p><b>Phone</b>:</p>
                                                                    <p>'.$receiver_phone.'</p>
                                                                </td>
                                                                <td>
                                                                '.$ordered_quantity.' 
                                                                </td>
                                                                <td>'.$total_payment.'</td>
                                                                <td>
                                                                    '.$tracking_status.'<br>
                                                                    <span style="font-size:12px;color:orange;">Latest update on:<br> '.$latest_updated_date.'</span>
                                                                </td>
                                                            </tr>
                                                            ';
                                                        }
                                                    } 
                                                    else 
                                                    {
                                                        echo
                                                        '
                                                            <tr>
                                                            <td colspan="9">
                                                                <p style="text-align:center">No result found</p>
                                                            </td>
                                                            </tr>
                                                        ';
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-cancel-order" role="tabpanel" aria-labelledby="pills-cancel-order-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th style="width:350px;">
                                                            Cancelled product information
                                                        </th>
                                                        <th style="width:300px;">
                                                            Customer information
                                                        </th>
                                                        <th style="width:300px;">
                                                            Receiver information
                                                        </th>
                                                        <th style="width:180px;">
                                                            Tracking status    
                                                        </th>
                                                        <th style="width:150px;">
                                                            Cancelled date 
                                                        </th>
                                                        <th style="width:200px;">
                                                            Reason for cancellation
                                                        </th>
                                                        <th style="width:200px;">
                                                            Cancel Status
                                                        </th>
                                                        <th style="width:50px;">
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    //Selecting the information of the products ordered
                                                    $admin_id=$_SESSION["admin_id"];
                                                    $sql = "SELECT * FROM products_ordered_table
                                                            LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id
                                                            LEFT JOIN track_order_table ON products_ordered_table.order_id=track_order_table.order_id
                                                            LEFT JOIN customer_table ON products_ordered_table.customer_id = customer_table.customer_id
                                                            LEFT JOIN cancel_order_table ON products_ordered_table.order_id=cancel_order_table.order_id  
                                                            WHERE products_ordered_table.admin_id='$admin_id' AND order_status='Cancelled' ORDER BY ordered_date DESC";
                                                    $result = mysqli_query($conn, $sql);
                                                    
                                                    if (mysqli_num_rows($result) > 0) 
                                                    {
                                                        // output data of each row
                                                        while($row = mysqli_fetch_assoc($result)) 
                                                        {
                                                            $order_id = $row["order_id"];
                                                            $receiver_name = $row["receiver_name"];
                                                            $customer_name = $row["full_name"];
                                                            $customer_phone = $row["phone"];  
                                                            $receiver_address = $row["receiver_address"];
                                                            $receiver_phone = $row["receiver_phone"];  
                                                            $brand_id = $row["brand_id"];
                                                            $product_id = $row["product_id"];
                                                            $product_name = $row["product_name"];
                                                            $total_payment = number_format($row["total_payment"],2);
                                                            $product_desc = $row["product_desc"];
                                                            $ordered_date = $row["ordered_date"];
                                                            $ordered_quantity=$row["ordered_quantity"];
                                                            $tracking_status=$row["tracking_status"];
                                                            $cancel_reason=$row["cancel_reason"];
                                                            $cancel_status=$row["cancel_status"];
                                                            $cancel_date=$row["cancel_date"];
                                                            $latest_updated_date=$row['latest_updated_date'];

                                                            echo
                                                            '
                                                            <tr>
                                                                <td style="text-align:left;">
                                                                    <p><b>Ordered date:</b></p>
                                                                    <p>'.$ordered_date.'</p>
                                                                    <br>
                                                                    <p><b>Product Name:</b></p>
                                                                    <p>'.$product_name.'</p>
                                                                    <br>
                                                                    <p><b>Ordered Quantity:</b></p>
                                                                    <p>'.$ordered_quantity.'</p>
                                                                    <br>
                                                                    <p><b>Total Payment (RM):</b></p>
                                                                    <p>'.$total_payment.'</p>
                                                                </td>
                                                                <td style="text-align:left;">
                                                                    <p><b>Name</b>:</p>
                                                                    <p>'.$customer_name.'</p>
                                                                    <br>
                                                                    <p><b>Address</b>:</p>
                                                                    <p>'.$customer_phone.'</p>
                                                                    <br>
                                                                </td>
                                                                <td style="text-align:left;">
                                                                    <p><b>Name</b>:</p>
                                                                    <p>'.$receiver_name.'</p>
                                                                    <br>
                                                                    <p><b>Address</b>:</p>
                                                                    <p>'.$receiver_address.'</p>
                                                                    <br>
                                                                    <p><b>Phone</b>:</p>
                                                                    <p>'.$receiver_phone.'</p>
                                                                </td>
                                                            ';
                                                            
                                                            if($tracking_status!="")
                                                            {
                                                                echo
                                                                '
                                                                    <td>
                                                                        '.$tracking_status.'<br>
                                                                        <span style="font-size:12px;color:orange;">Latest update on:<br> '.$latest_updated_date.'</span>
                                                                    </td>
                                                                '; 
                                                            }
                                                            else
                                                            {
                                                                echo
                                                                '
                                                                    <td>
                                                                        N/A due to pending payment
                                                                    </td>
                                                                '; 
                                                            } 
                                                            
                                                            echo
                                                            '
                                                                <td>'.$cancel_date.'</td>
                                                                <td>'.$cancel_reason.'</td>
                                                                <td>'.$cancel_status.'</td>
                                                            ';
                                                            
                                                            if ($cancel_status=="To be approved by admin")
                                                            {
                                                                if($tracking_status!="")
                                                                {
                                                                    echo
                                                                    '
                                                                        <td>
                                                                            <form method="POST" name="acceptCancelForm" id="acceptCancelForm" class="mb-2">
                                                                                <input type="hidden" value="' . $order_id . '" name="order_id">
                                                                                <input type="hidden" value="' . $ordered_quantity . '" name="ordered_quantity">
                                                                                <input type="hidden" value="' .$tracking_status. '" name="tracking_status">
                                                                                <input type="hidden" value="' . $product_id . '" name="product_id">
                                                                                <button type="submit" class="btn btn-block btn-info btn-xs text-light" name="btnAcceptCancel" title="Accept Cancellation">Accept<br>Cancellation</button>
                                                                            </form>
                                                                            <br>
                                                                            <form method="POST" name="declineCancelForm" id="declineCancelForm" class="mb-2">
                                                                                <input type="hidden" value="' . $order_id . '" name="order_id">
                                                                                <button type="submit" class="btn btn-block btn-danger btn-xs text-light" name="btnDeclineCancel" title="Decline Cancellation">Decline<br>Cancellation</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    ';
                                                                }
                                                                else
                                                                {
                                                                    echo
                                                                    '
                                                                        <td>
                                                                            <form method="POST" name="acceptCancelForm" id="acceptCancelForm" class="mb-2">
                                                                                <input type="hidden" value="' . $order_id . '" name="order_id">
                                                                                <input type="hidden" value="' . $ordered_quantity . '" name="ordered_quantity">
                                                                                <input type="hidden" value="' .$tracking_status. '" name="tracking_status">
                                                                                <input type="hidden" value="' . $product_id . '" name="product_id">
                                                                                <button type="submit" class="btn btn-block btn-info btn-xs text-light" name="btnAcceptCancel" title="Accept Cancellation">Accept<br>Cancellation</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    ';
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo
                                                                '
                                                                    <td>None</td>

                                                                ';
                                                            }    
                                                        }
                                                    } 
                                                    else 
                                                    {
                                                        echo
                                                        '
                                                            <tr>
                                                            <td colspan="9">
                                                                <p style="text-align:center">No result found</p>
                                                            </td>
                                                            </tr>
                                                        ';
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-rejected-order" role="tabpanel" aria-labelledby="pills-rejected-order-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                    <th style="width:150px;">
                                                            Ordered Date
                                                        </th>
                                                        <th style="width:350px;">
                                                            Rejected product information
                                                        </th>
                                                        <th style="width:300px;">
                                                            Customer information
                                                        </th>
                                                        <th style="width:180px;">
                                                            Tracking status    
                                                        </th>
                                                        <th style="width:150px;">
                                                            Rejected date 
                                                        </th>
                                                        <th style="width:200px;">
                                                            Reason for rejecting
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    //Selecting the information of the products ordered
                                                    $admin_id=$_SESSION["admin_id"];
                                                    $sql = "SELECT * FROM products_ordered_table
                                                            LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id
                                                            LEFT JOIN track_order_table ON products_ordered_table.order_id=track_order_table.order_id
                                                            LEFT JOIN customer_table ON products_ordered_table.customer_id = customer_table.customer_id
                                                            LEFT JOIN reject_order_table ON products_ordered_table.order_id=reject_order_table.order_id  
                                                            WHERE products_ordered_table.admin_id='$admin_id' AND order_status='Rejected' ORDER BY ordered_date DESC";
                                                    $result = mysqli_query($conn, $sql);
                                                    
                                                    if (mysqli_num_rows($result) > 0) 
                                                    {
                                                        // output data of each row
                                                        while($row = mysqli_fetch_assoc($result)) 
                                                        {
                                                            $order_id = $row["order_id"];
                                                            $customer_name = $row["full_name"];
                                                            $customer_phone = $row["phone"];  
                                                            $brand_id = $row["brand_id"];
                                                            $product_id = $row["product_id"];
                                                            $product_name = $row["product_name"];
                                                            $total_payment = number_format($row["total_payment"],2);
                                                            $product_desc = $row["product_desc"];
                                                            $ordered_date = $row["ordered_date"];
                                                            $ordered_quantity=$row["ordered_quantity"];
                                                            $tracking_status=$row["tracking_status"];
                                                            $reject_reason=$row["reject_reason"];
                                                            $reject_date=$row["reject_date"];
                                                            $latest_updated_date=$row['latest_updated_date'];

                                                            echo
                                                            '
                                                            <tr>
                                                                <td>'.$ordered_date.'</td>
                                                                <td style="text-align:left;">
                                                                    <p><b>Product Name:</b></p>
                                                                    <p>'.$product_name.'</p>
                                                                    <br>
                                                                    <p><b>Ordered Quantity:</b></p>
                                                                    <p>'.$ordered_quantity.'</p>
                                                                    <br>
                                                                    <p><b>Total Payment (RM):</b></p>
                                                                    <p>'.$total_payment.'</p>
                                                                    <br>
                                                                    <p><b>Ordered date:</b></p>
                                                                    <p>'.$ordered_date.'</p>
                                                                </td>
                                                                <td style="text-align:left;">
                                                                    <p><b>Name</b>:</p>
                                                                    <p>'.$customer_name.'</p>
                                                                    <br>
                                                                    <p><b>Phone</b>:</p>
                                                                    <p>'.$customer_phone.'</p>
                                                                </td>
                                                            ';
                                                            
                                                            if($tracking_status!="")
                                                            {
                                                                echo
                                                                '
                                                                    <td>
                                                                        '.$tracking_status.'<br>
                                                                        <span style="font-size:12px;color:orange;">Latest update on:<br> '.$latest_updated_date.'</span>
                                                                    </td>
                                                                '; 
                                                            }
                                                            else
                                                            {
                                                                echo
                                                                '
                                                                    <td>
                                                                        N/A due to pending payment
                                                                    </td>
                                                                '; 
                                                            } 
                                                            
                                                            echo
                                                            '
                                                                <td>'.$reject_date.'</td>
                                                                <td align="left">'.$reject_reason.'</td>
                                                            ';
                                                        }
                                                    } 
                                                    else 
                                                    {
                                                        echo
                                                        '
                                                            <tr>
                                                            <td colspan="9">
                                                                <p style="text-align:center">No result found</p>
                                                            </td>
                                                            </tr>
                                                        ';
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
    $('#acceptCancelForm').submit(function() {  
        return confirm("Are you sure you want to accept the cancellation of the order?");
    });

    $('#declineCancelForm').submit(function() {  
        return confirm("Are you sure you want to decline the cancellation of the order?");
    });  
  </script>
  <!-- End custom js for this page-->
</body>

</html>


<?php
  include("session-admin.php");

  if (isset($_POST['btnUpdate']))
  {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $tracking_status = mysqli_real_escape_string($conn, $_POST['tracking_status']);

    if ($tracking_status!="Order delivered")
    {
        //update the tracking status in the track_order_table
        $update_tracking_status_query="UPDATE track_order_table SET tracking_status='$tracking_status' WHERE order_id='$order_id'";
        $result = mysqli_query($conn, $update_tracking_status_query) or trigger_error("Query Failed! SQL: $update_tracking_status_query - Error: ".mysqli_error($conn), E_USER_ERROR);
    }
    else
    {
        //update the tracking status in the track_order_table
        $update_tracking_status_query="UPDATE track_order_table SET tracking_status='$tracking_status' WHERE order_id='$order_id'";
        $result1 = mysqli_query($conn, $update_tracking_status_query) or trigger_error("Query Failed! SQL: $update_tracking_status_query - Error: ".mysqli_error($conn), E_USER_ERROR);

        //update the order_status in the products_ordered_table
        $update_order_status_query="UPDATE products_ordered_table SET order_status='Completed' WHERE order_id='$order_id'";
        $result2 = mysqli_query($conn, $update_order_status_query) or trigger_error("Query Failed! SQL: $update_order_status_query - Error: ".mysqli_error($conn), E_USER_ERROR);

    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit Tracking Status | SVS GlobalBiz Solution</title>
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
                  <h4 class="font-weight-bold mb-0">Edit Order Tracking Status</h4>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th style="width:600px;text-align:left;">
                                    Product Information
                                </th>
                                <th style="width:300px;">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            //Selecting the information of the order
                            $order_id = $_GET['order_id'];
                            $sql = "SELECT * FROM products_ordered_table
                                    LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id
                                    LEFT JOIN track_order_table ON products_ordered_table.order_id=track_order_table.order_id
                                    WHERE track_order_table.order_id='$order_id'";
                                    $result = mysqli_query($conn, $sql);
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) 
                            {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) 
                                {
                                    $order_id = $row["order_id"];
                                    $product_id = $row["product_id"];
                                    $product_name = $row["product_name"];
                                    $product_price = $row["product_price"];
                                    $ordered_quantity = $row["ordered_quantity"];
                                    $product_img = $row["product_img"];
                                    $tracking_status = $row["tracking_status"];
                                    $latest_updated_date=$row["latest_updated_date"];
                                    $total_payment = number_format($row["total_payment"],2);
                                    $receiver_name = $row["receiver_name"];
                                    $receiver_address = $row["receiver_address"];
                                    $receiver_phone = $row["receiver_phone"];  

                                    echo
                                    '
                                    <tr>
                                        <td style="text-align:left;">
                                          <ul>
                                            <li><b>Product Name:</b> '.$product_name.'</li>
                                            <li><b>Total Payment (RM):</b> '.$total_payment.'</li>
                                            <li><b>Ordered Quantity</b>: '.$ordered_quantity.'</li>
                                            <li><b>Current tracking status</b>: '.$tracking_status.' <span style="color:orange;">(Latest update on: '.$latest_updated_date.')</span></li>
                                          </ul>  
                                          <hr>
                                          <ul>
                                            <li><b>Receiver Name:</b> '.$receiver_name.'</li>
                                            <li><b>Receiver Address:</b> '.$receiver_address.'</li>
                                            <li><b>Receiver Phone:</b> '.$receiver_phone.'</li>
                                          </ul>
                                        </td>
                                        <td>
                                            <form method="POST" action="" name="updateForm" id="updateForm">
                                                <select id="tracking_status" name="tracking_status" class="form-control">
                                                    <option value="Sent to delivery partner">Sent to delivery partner</option>
                                                    <option value="Out for delivery">Out for delivery</option>
                                                    <option value="Order delivered">Order delivered</option>
                                                </select>
                                                <input type="hidden" value="' . $order_id . '" name="order_id">
                                                <br>
                                                <button type="submit" class="btn btn-block btn-dark btn-xs" name="btnUpdate" id="' . $order_id . '" title="Update product quantity">Update Tracking Status</button>
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
                                    <td colspan="2">
                                        <p style="text-align:center">No result found</p>
                                    </td>
                                    </tr>
                                ';
                            }
                        ?>
                        </tbody>
                    </table>
                  </div>
                  <br>
                  <a href="customer-orders-page.php"><button type="button" class="btn btn-warning text-light">Back</button></a> 
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
    $('#updateForm').submit(function() {  
        return confirm("Are you sure you want to update the tracking status for this order?");
    });  
  </script>
  <!-- End custom js for this page-->
</body>

</html>


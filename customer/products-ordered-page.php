<?php
  include("session-customer.php");

  if (isset($_POST['btnDelete']))
  {
    $customer_id=$_SESSION["customer_id"]; 
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $delete_query="DELETE FROM cart_table WHERE cart_id='$cart_id'";
    $result = mysqli_query($conn, $delete_query) or trigger_error("Query Failed! SQL: $delete_query - Error: ".mysqli_error($conn), E_USER_ERROR);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Products Ordered | SVS GlobalBiz Solution</title>
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
                  <h4 class="font-weight-bold mb-0">Products Ordered</h4>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link text-dark active" id="pills-pending-tab" data-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-pending" aria-selected="true">Pending Payment Order</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link text-dark" id="pills-paid-tab" data-toggle="pill" href="#pills-paid" role="tab" aria-controls="pills-paid" aria-selected="true">Paid Order</a>
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
                      <div class="tab-pane fade show active" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                        <div class="table-responsive pt-3">
                          <table class="table table-bordered text-center">
                              <thead>
                                  <tr>
                                      <th style="width:200px;">
                                          Product
                                      </th>
                                      <th style="width:300px;">Receiver Information</th>
                                      <th style="width:50px;">
                                          Quantity
                                      </th>
                                      <th style="width:200px;">
                                          Total Payment (RM)
                                      </th>
                                      <th style="width:120px;">
                                          Order Date
                                      </th>
                                      <th style="width:150px;">
                                          Order Status
                                      </th>
                                      <th style="width:150px;">
                                          Tracking status    
                                      </th>
                                      <th style="width:120px;" colspan="2">
                                          Action
                                      </th>
                                  </tr>
                              </thead>
                              <tbody>
                              <?php
                                  //Selecting the information of the products ordered
                                  $customer_id=$_SESSION["customer_id"];
                                  $sql = "SELECT *, products_ordered_table.order_id AS o_id FROM products_ordered_table 
                                          LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id 
                                          LEFT JOIN track_order_table ON products_ordered_table.order_id =track_order_table.order_id 
                                          WHERE products_ordered_table.customer_id='$customer_id' AND order_status='Pending payment' ORDER BY ordered_date DESC";
                                  $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);;
                                  
                                  if (mysqli_num_rows($result) > 0) 
                                  {
                                    // output data of each row
                                    while($row = mysqli_fetch_assoc($result)) 
                                    {
                                      $order_id = $row["o_id"];
                                      $product_id = $row["product_id"];
                                      $product_name = $row["product_name"];
                                      $total_payment = number_format($row["total_payment"],2);
                                      $order_status = $row["order_status"];
                                      $product_img = $row["product_img"];
                                      $ordered_date = $row["ordered_date"];
                                      $ordered_quantity=$row["ordered_quantity"];
                                      $tracking_status=$row['tracking_status'];
                                      $receiver_name = $row["receiver_name"];
                                      $receiver_address = $row["receiver_address"];
                                      $receiver_phone = $row["receiver_phone"];  

                                      echo
                                      '
                                        <tr>
                                          <td style="text-align:center;">
                                            <b>'.$product_name.'</b><br>
                                            <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:100px; height:100px;" />
                                          </td>
                                          <td style="text-align:left;">  
                                            <p><b>Receiver Name:</b></p>
                                            <p>'.$receiver_name.'</p>
                                            <p><b>Receiver Address:</b></p>
                                            <p>'.$receiver_address.'</p>
                                            <p><b>Receiver Phone:</b></p>
                                            <p>'.$receiver_phone.'</p>
                                          </td>
                                          <td>
                                          '.$ordered_quantity.' 
                                          </td>
                                          <td>'.$total_payment.'</td>
                                          <td>'.$ordered_date.'</td>
                                          <td>'.$order_status.'</td>
                                      '; 
                                      
                                      if($tracking_status=="")
                                      {
                                        echo
                                        '
                                          <td class="text-danger"> 
                                            Need to complete payment first<br>
                                            <a href="payment.php?product_id='.$product_id.'" class="mt-1 btn btn-dark btn-xs text-light">Pay now</a>
                                          </td>
                                        ';
                                      }
                                      else
                                      {
                                        echo
                                        '
                                          <td>
                                            '.$tracking_status.'
                                          </td>
                                        ';
                                      }
                                       
                                      echo
                                      '    
                                          <td align="center">
                                            <input type="hidden" value="'.$order_id.'" name="order_id">
                                            <a href="cancel-order-page.php?order_id='.$order_id.'" class="mt-1 btn btn-danger btn-xs text-light">Cancel Order</a>
                                          </td>
                                      </tr>
                                      ';
                                      continue;
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
                      <div class="tab-pane fade" id="pills-paid" role="tabpanel" aria-labelledby="pills-paid-tab">
                        <div class="table-responsive pt-3">
                          <table class="table table-bordered text-center">
                              <thead>
                                  <tr>
                                      <th style="width:200px;">
                                          Product
                                      </th>
                                      <th style="width:300px;">Receiver Information</th>
                                      <th style="width:50px;">
                                          Quantity
                                      </th>
                                      <th style="width:150px;">
                                          Total Payment (RM)
                                      </th>
                                      <th style="width:120px;">
                                          Order Date
                                      </th>
                                      <th style="width:150px;">
                                          Order Status
                                      </th>
                                      <th style="width:150px;">
                                          Tracking status    
                                      </th>
                                      <th style="width:150px;">
                                          Action
                                      </th>
                                  </tr>
                              </thead>
                              <tbody>
                              <?php
                                  //Selecting the information of the products that are added to cart
                                  $customer_id=$_SESSION["customer_id"];
                                  $sql = "SELECT *, products_ordered_table.order_id AS o_id, products_ordered_table.customer_id AS c_id   
                                          FROM products_ordered_table 
                                          LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id 
                                          LEFT JOIN track_order_table ON products_ordered_table.order_id =track_order_table.order_id 
                                          LEFT JOIN cancel_order_table ON products_ordered_table.order_id=cancel_order_table.order_id  
                                          WHERE products_ordered_table.customer_id='$customer_id' AND (products_ordered_table.order_status='Paid' OR products_ordered_table.order_status='Accepted') ORDER BY ordered_date DESC";
                                  $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
                                  
                                  if (mysqli_num_rows($result) > 0) 
                                  {
                                    // output data of each row
                                    while($row = mysqli_fetch_assoc($result)) 
                                    {
                                      $order_id = $row["o_id"];
                                      $product_id = $row["product_id"];
                                      $product_name = $row["product_name"];
                                      $total_payment = number_format($row["total_payment"],2);
                                      $order_status = $row["order_status"];
                                      $product_img = $row["product_img"];
                                      $ordered_date = $row["ordered_date"];
                                      $ordered_quantity=$row["ordered_quantity"];
                                      $tracking_status=$row['tracking_status'];
                                      $latest_updated_date=$row['latest_updated_date'];
                                      $receiver_name = $row["receiver_name"];
                                      $receiver_address = $row["receiver_address"];
                                      $receiver_phone = $row["receiver_phone"];  
                                      $cancel_status=$row["cancel_status"];

                                      echo
                                      '
                                        <tr>
                                          <td style="text-align:center;">
                                            <b>'.$product_name.'</b><br>
                                            <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:100px; height:100px;" />
                                          </td>
                                          <td style="text-align:left;">  
                                            <p><b>Receiver Name:</b></p>
                                            <p>'.$receiver_name.'</p>
                                            <p><b>Receiver Address:</b></p>
                                            <p>'.$receiver_address.'</p>
                                            <p><b>Receiver Phone:</b></p>
                                            <p>'.$receiver_phone.'</p>
                                          </td>
                                          <td>
                                          '.$ordered_quantity.' 
                                          </td>
                                          <td>'.$total_payment.'</td>
                                          <td>'.$ordered_date.'</td>
                                      ';
                                        
                                      if($cancel_status!="Declined by admin")
                                      {
                                        echo
                                        '
                                          <td>'.$order_status.'</td>
                                        ';
                                      }
                                      else
                                      {
                                        echo
                                        '
                                          <td>
                                            '.$order_status.'<br>
                                            <span style="font-size:12px;color:red;">Cancellation request: '.$cancel_status.'</span>
                                          </td>
                                        ';
                                      }
                                      
                                      if($tracking_status=="")
                                      {
                                        echo
                                        '
                                          <td class="text-danger"> 
                                            Need to complete payment first<br>
                                            <a href="payment.php?product_id='.$product_id.'" class="mt-1 btn btn-dark btn-xs text-light">Pay now</a>
                                          </td>
                                        ';
                                      }
                                      else
                                      {
                                        echo
                                        '
                                          <td>
                                            '.$tracking_status.'<br>
                                            <span style="font-size:12px;color:orange;">Latest update on:<br> '.$latest_updated_date.'</span>
                                          </td>
                                        ';
                                      }
                                      
                                      if($cancel_status!="Declined by admin")
                                      {
                                        echo
                                        '    
                                            <td align="center">
                                              <input type="hidden" value="'.$order_id.'" name="order_id">
                                              <a href="cancel-order-page.php?order_id='.$order_id.'" class="mt-1 btn btn-danger btn-xs text-light">Cancel Order</a>
                                            </td>
                                        </tr>
                                        ';
                                      }
                                      else
                                      {
                                        echo
                                        '    
                                            <td align="center">
                                              Not Available
                                            </td>
                                        </tr>
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
                      <div class="tab-pane fade" id="pills-completed-order" role="tabpanel" aria-labelledby="pills-completed-order-tab">
                        <div class="table-responsive pt-3">
                          <table class="table table-bordered text-center">
                              <thead>
                                  <tr>
                                      <th style="width:200px;">
                                          Product
                                      </th>
                                      <th style="width:300px;">Receiver Information</th>
                                      <th style="width:50px;">
                                          Quantity
                                      </th>
                                      <th style="width:200px;">
                                          Total Payment (RM)
                                      </th>
                                      <th style="width:120px;">
                                          Order Date
                                      </th>
                                      <th style="width:150px;">
                                          Order Status
                                      </th>
                                      <th style="width:150px;">
                                          Tracking status    
                                      </th>
                                  </tr>
                              </thead>
                              <tbody>
                              <?php
                                  //Selecting the information of the products 
                                  $customer_id=$_SESSION["customer_id"];
                                  $sql = "SELECT * FROM products_ordered_table
                                          LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id
                                          LEFT JOIN track_order_table ON products_ordered_table.order_id=track_order_table.order_id  
                                          WHERE products_ordered_table.customer_id='$customer_id' AND order_status='Completed' ORDER BY track_order_table.latest_updated_date DESC";
                                  $result = mysqli_query($conn, $sql);
                                  
                                  if (mysqli_num_rows($result) > 0) 
                                  {
                                      // output data of each row
                                      while($row = mysqli_fetch_assoc($result)) 
                                      {
                                          $order_id = $row["order_id"];
                                          $product_id = $row["product_id"];
                                          $product_name = $row["product_name"];
                                          $total_payment = number_format($row["total_payment"],2);
                                          $order_status = $row["order_status"];
                                          $product_img = $row["product_img"];
                                          $ordered_date = $row["ordered_date"];
                                          $ordered_quantity=$row["ordered_quantity"];
                                          $tracking_status=$row['tracking_status'];
                                          $receiver_name = $row["receiver_name"];
                                          $receiver_address = $row["receiver_address"];
                                          $receiver_phone = $row["receiver_phone"];  
                                          $latest_updated_date=$row["latest_updated_date"];

                                          echo
                                          '
                                            <tr>
                                              <td style="text-align:center;">
                                                <b>'.$product_name.'</b><br>
                                                <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:100px; height:100px;" />
                                              </td>
                                              <td style="text-align:left;">  
                                                <p><b>Receiver Name:</b></p>
                                                <p>'.$receiver_name.'</p>
                                                <p><b>Receiver Address:</b></p>
                                                <p>'.$receiver_address.'</p>
                                                <p><b>Receiver Phone:</b></p>
                                                <p>'.$receiver_phone.'</p>
                                              </td>
                                              <td>
                                              '.$ordered_quantity.' 
                                              </td>
                                              <td>'.$total_payment.'</td>
                                              <td>'.$ordered_date.'</td>
                                          '; 
                                          
                                            echo
                                            '
                                              <td class="text-success">
                                              '.$order_status.'
                                              </td>
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
                                      <th style="width:200px;">
                                        Product
                                      </th>
                                      <th style="width:300px;">Receiver Information</th>
                                      <th style="width:50px;">
                                        Quantity
                                      </th>
                                      <th style="width:200px;">
                                        Total Payment (RM)
                                      </th>
                                      <th style="width:150px;">
                                        Order Date
                                      </th>
                                      <th style="width:150px;">
                                        Order Status
                                      </th>
                                      <th style="width:150px;">
                                          Tracking status    
                                      </th>
                                      <th style="width:120px;">
                                        Reason for cancellation
                                      </th>
                                      <th>
                                        Cancel Status
                                      </th>
                                  </tr>
                              </thead>
                              <tbody>
                              <?php
                                  $customer_id=$_SESSION["customer_id"];
                                  $sql = "SELECT * FROM products_ordered_table
                                          LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id
                                          LEFT JOIN track_order_table ON products_ordered_table.order_id=track_order_table.order_id
                                          LEFT JOIN cancel_order_table ON products_ordered_table.order_id=cancel_order_table.order_id  
                                          WHERE products_ordered_table.customer_id='$customer_id' AND order_status='Cancelled' ORDER BY track_order_table.latest_updated_date ASC";
                                  $result = mysqli_query($conn, $sql);
                                  
                                  if (mysqli_num_rows($result) > 0) 
                                  {
                                      // output data of each row
                                      while($row = mysqli_fetch_assoc($result)) 
                                      {
                                          $order_id = $row["order_id"];
                                          $product_id = $row["product_id"];
                                          $product_name = $row["product_name"];
                                          $total_payment = number_format($row["total_payment"],2);
                                          $order_status = $row["order_status"];
                                          $product_img = $row["product_img"];
                                          $ordered_date = $row["ordered_date"];
                                          $ordered_quantity=$row["ordered_quantity"];
                                          $tracking_status=$row['tracking_status'];
                                          $cancel_reason=$row['cancel_reason'];
                                          $cancel_status=$row['cancel_status'];
                                          $receiver_name = $row["receiver_name"];
                                          $receiver_address = $row["receiver_address"];
                                          $receiver_phone = $row["receiver_phone"];  
                                          $latest_updated_date = $row["latest_updated_date"];  

                                          echo
                                          '
                                            <tr>
                                              <td style="text-align:center;">
                                                <b>'.$product_name.'</b><br>
                                                <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:100px; height:100px;" />
                                              </td>
                                              <td style="text-align:left;">  
                                                <p><b>Receiver Name:</b></p>
                                                <p>'.$receiver_name.'</p>
                                                <p><b>Receiver Address:</b></p>
                                                <p>'.$receiver_address.'</p>
                                                <p><b>Receiver Phone:</b></p>
                                                <p>'.$receiver_phone.'</p>
                                              </td>
                                              <td>
                                              '.$ordered_quantity.' 
                                              </td>
                                              <td>'.$total_payment.'</td>
                                              <td>'.$ordered_date.'</td>
                                          '; 
                                          
                                            echo
                                            '
                                              <td >
                                              '.$order_status.'
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
                                                <td align="center">
                                                  '.$cancel_reason.'
                                                </td>
                                            ';
                                              
                                          if($cancel_status!="Accepted by admin")
                                          {
                                            echo
                                            '    
                                                <td align="center" class="text-danger">
                                                  '.$cancel_status.'
                                                </td>
                                              </tr>
                                            ';
                                          }
                                          else
                                          {
                                            echo
                                            '    
                                                <td align="center">
                                                  '.$cancel_status.'
                                                </td>
                                              </tr>
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
                                      <th style="width:200px;">
                                          Product
                                      </th>
                                      <th style="width:300px;">Receiver Information</td>
                                      <th style="width:50px;">
                                          Quantity
                                      </th>
                                      <th style="width:150px;">
                                          Total Payment (RM)
                                      </th>
                                      <th style="width:120px;">
                                          Order Date
                                      </th>
                                      <th style="width:150px;">
                                          Order Status
                                      </th>
                                      <th style="width:150px;">
                                          Tracking status    
                                      </th>
                                      <th style="width:180px;">
                                          Reason for rejected
                                      </th>
                                  </tr>
                              </thead>
                              <tbody>
                              <?php
                                //Selecting the information of the products that are added to cart
                                $customer_id=$_SESSION["customer_id"];
                                $sql = "SELECT * FROM products_ordered_table
                                        LEFT JOIN product_info_table ON products_ordered_table.product_id=product_info_table.product_id
                                        LEFT JOIN track_order_table ON products_ordered_table.order_id=track_order_table.order_id
                                        LEFT JOIN reject_order_table ON products_ordered_table.order_id=reject_order_table.order_id   
                                        WHERE products_ordered_table.customer_id='$customer_id' AND order_status='Rejected'";
                                $result = mysqli_query($conn, $sql);
                                
                                if (mysqli_num_rows($result) > 0) 
                                {
                                  // output data of each row
                                  while($row = mysqli_fetch_assoc($result)) 
                                  {
                                      $order_id = $row["order_id"];
                                      $product_id = $row["product_id"];
                                      $product_name = $row["product_name"];
                                      $total_payment = number_format($row["total_payment"],2);
                                      $order_status = $row["order_status"];
                                      $product_img = $row["product_img"];
                                      $ordered_date = $row["ordered_date"];
                                      $ordered_quantity=$row["ordered_quantity"];
                                      $tracking_status=$row['tracking_status'];
                                      $receiver_name = $row["receiver_name"];
                                      $receiver_address = $row["receiver_address"];
                                      $receiver_phone = $row["receiver_phone"];  
                                      $reject_reason=$row["reject_reason"];
                                      $reject_date=$row["reject_date"];
                                      $latest_updated_date=$row['latest_updated_date'];

                                      echo
                                      '
                                        <tr>
                                          <td style="text-align:center;">
                                            <b>'.$product_name.'</b><br>
                                            <img src = "data:image/png;base64,' . base64_encode($row['product_img']) . '" style="width:100px; height:100px;" />
                                          </td>
                                          <td style="text-align:left;">  
                                            <p><b>Receiver Name:</b></p>
                                            <p>'.$receiver_name.'</p>
                                            <p><b>Receiver Address:</b></p>
                                            <p>'.$receiver_address.'</p>
                                            <p><b>Receiver Phone:</b></p>
                                            <p>'.$receiver_phone.'</p>
                                          </td>
                                          <td>
                                          '.$ordered_quantity.' 
                                          </td>
                                          <td>'.$total_payment.'</td>
                                          <td>'.$ordered_date.'</td>
                                      '; 
                                      
                                      if($order_status!='Paid')
                                      {
                                        echo
                                        '
                                          <td class="text-danger">
                                          '.$order_status.'
                                          </td>
                                        ';
                                      }
                                      else
                                      {
                                        echo
                                        '
                                          <td class="text-success">
                                          '.$order_status.'
                                          </td>
                                        ';
                                      }

                                      echo
                                      '
                                        <td>
                                          '.$tracking_status.'
                                        </td>
                                      ';
                                        
                                      echo
                                      '    
                                          <td align="left">
                                              '.$reject_reason.'
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
    $('#deleteForm').submit(function() {  
        return confirm("Are you sure you want to delete this product from the cart?");
    }); 
    $('#deleteForm2').submit(function() {  
        return confirm("Are you sure you want to delete this product from the cart?");
    });  
  </script>
  <!-- End custom js for this page-->
</body>

</html>


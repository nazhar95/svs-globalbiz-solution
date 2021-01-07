<?php
  include("session-admin.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>List Report By Month | SVS GlobalBiz Solution</title>
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
                        <h4 class="font-weight-bold mb-0">Report By Month</h4>
                        </div> 
                    </div>
                    </div>
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link text-dark active" id="pills-january-tab" data-toggle="pill" href="#pills-january" role="tab" aria-controls="pills-january" aria-selected="true">Jan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-february-tab" data-toggle="pill" href="#pills-february" role="tab" aria-controls="pills-february" aria-selected="false">Feb</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-march-tab" data-toggle="pill" href="#pills-march" role="tab" aria-controls="pills-march" aria-selected="false">March</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-april-tab" data-toggle="pill" href="#pills-april" role="tab" aria-controls="pills-april" aria-selected="false">April</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-may-tab" data-toggle="pill" href="#pills-may" role="tab" aria-controls="pills-may" aria-selected="false">May</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-jun-tab" data-toggle="pill" href="#pills-jun" role="tab" aria-controls="pills-jun" aria-selected="false">Jun</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-jul-tab" data-toggle="pill" href="#pills-jul" role="tab" aria-controls="pills-jul" aria-selected="false">July</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-aug-tab" data-toggle="pill" href="#pills-aug" role="tab" aria-controls="pills-aug" aria-selected="false">August</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-sep-tab" data-toggle="pill" href="#pills-sep" role="tab" aria-controls="pills-sep" aria-selected="false">Sep</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-oct-tab" data-toggle="pill" href="#pills-oct" role="tab" aria-controls="pills-oct" aria-selected="false">Oct</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-nov-tab" data-toggle="pill" href="#pills-nov" role="tab" aria-controls="pills-nov" aria-selected="false">Nov</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="pills-dec-tab" data-toggle="pill" href="#pills-dec" role="tab" aria-controls="pills-dec" aria-selected="false">Dec</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-january" role="tabpanel" aria-labelledby="pills-january-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='01' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='01'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='01'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                // $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                // $total_rejected_order=  $row["COUNT(reject_order_table.reject_id)"];
                                                            
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-february" role="tabpanel" aria-labelledby="pills-february-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='02' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='02'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='02'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                // $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                // $total_rejected_order=  $row["COUNT(reject_order_table.reject_id)"];
                                                            
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-march" role="tabpanel" aria-labelledby="pills-march-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='03' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='03'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='03'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                // $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                // $total_rejected_order=  $row["COUNT(reject_order_table.reject_id)"];
                                                            
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-april" role="tabpanel" aria-labelledby="pills-april-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='04' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='04'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='04'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                // $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                // $total_rejected_order=  $row["COUNT(reject_order_table.reject_id)"];
                                                            
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-may" role="tabpanel" aria-labelledby="pills-may-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='05' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='05'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='05'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                // $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                // $total_rejected_order=  $row["COUNT(reject_order_table.reject_id)"];
                                                            
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-jun" role="tabpanel" aria-labelledby="pills-jun-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='06' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='06'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='06'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                // $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                // $total_rejected_order=  $row["COUNT(reject_order_table.reject_id)"];
                                                            
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-july" role="tabpanel" aria-labelledby="pills-july-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='07' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='07'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='07'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                // $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                // $total_rejected_order=  $row["COUNT(reject_order_table.reject_id)"];
                                                            
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-aug" role="tabpanel" aria-labelledby="pills-aug-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='08' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='08'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='08'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                // $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                // $total_rejected_order=  $row["COUNT(reject_order_table.reject_id)"];
                                                            
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-sep" role="tabpanel" aria-labelledby="pills-sep-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='09' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='09'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='09'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                // $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                // $total_rejected_order=  $row["COUNT(reject_order_table.reject_id)"];
                                                            
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-oct" role="tabpanel" aria-labelledby="pills-oct-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='10' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='10'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='10'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                // $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                // $total_rejected_order=  $row["COUNT(reject_order_table.reject_id)"];
                                                            
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-nov" role="tabpanel" aria-labelledby="pills-nov-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='11' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='11'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='11'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                               
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-dec" role="tabpanel" aria-labelledby="pills-dec-tab">
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Total No. of Customers
                                                        </th>
                                                        <th>
                                                            Total Products Sold
                                                        </th>
                                                        <th >
                                                            Total Profit (RM)
                                                        </th>
                                                        <th >
                                                            Total Cancelled Order
                                                        </th>
                                                        <th>
                                                            Total Rejected Order
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <?php
                                                        $admin_id=$_SESSION["admin_id"];

                                                        //select the total profit, total no of customer and total number of products sold
                                                        $sql1 = "SELECT 
                                                                SUM(products_ordered_table.total_payment), 
                                                                COUNT(DISTINCT products_ordered_table.customer_id), 
                                                                COUNT(products_ordered_table.ordered_quantity) 
                                                                FROM products_ordered_table 
                                                                WHERE SUBSTRING(products_ordered_table.ordered_date, 6,2) ='12' AND products_ordered_table.order_status='Completed' AND products_ordered_table.admin_id='$admin_id'";
                                                        $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of cancelled order 
                                                        $sql2 = "SELECT COUNT(cancel_order_table.cancel_id) FROM cancel_order_table 
                                                                WHERE SUBSTRING(cancel_order_table.cancel_date, 6,2) ='12'  AND cancel_order_table.admin_id='$admin_id'";
                                                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: ".mysqli_error($conn), E_USER_ERROR);

                                                        //select the total number of rejected order
                                                        $sql3 = "SELECT COUNT(reject_order_table.reject_id) FROM reject_order_table 
                                                                WHERE SUBSTRING(reject_order_table.reject_date, 6,2) ='12'  AND reject_order_table.admin_id='$admin_id'";
                                                        $result3 = mysqli_query($conn, $sql3) or trigger_error("Query Failed! SQL: $sql3 - Error: ".mysqli_error($conn), E_USER_ERROR);
                                                        
                                                        //display the total profit, total no of customer and total number of products sold
                                                        if (mysqli_num_rows($result1) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result1)) 
                                                            {
                                                                $total_customer = $row["COUNT(DISTINCT products_ordered_table.customer_id)"];
                                                                $total_no_products_sold = $row["COUNT(products_ordered_table.ordered_quantity)"];
                                                                $total_profit = number_format($row["SUM(products_ordered_table.total_payment)"],2);
                                                                
                                                                echo
                                                                '
                                                                
                                                                        <td>'.$total_customer.'</td>
                                                                        <td>'.$total_no_products_sold.'                                                         
                                                                        </td>
                                                                        <td>'.$total_profit.'</td>
                                                                    
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of cancelled order
                                                        if (mysqli_num_rows($result2) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result2)) 
                                                            {
                                                                $total_cancelled_order=  $row["COUNT(cancel_order_table.cancel_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_cancelled_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }

                                                        //display the total number of rejected order
                                                        if (mysqli_num_rows($result3) > 0) 
                                                        {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($result3)) 
                                                            {
                                                                $total_rejected_order= $row["COUNT(reject_order_table.reject_id)"];
                                                                echo
                                                                '
                                                                    <td>'.$total_rejected_order.'</td>
                                                                ';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo
                                                            '
                                                                <td>
                                                                    <p style="text-align:center">N/A</p>
                                                                </td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tr>
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


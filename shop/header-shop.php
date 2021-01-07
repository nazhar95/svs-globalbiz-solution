<?php
    //DB Connection
    // include("../inc/dbconfig.php");

    //start session
    session_start();
    // echo ($_SESSION["user_role"]);
    echo
    '
    <header id="header">
        <!--header-->
        <div class="header_top" style="background-color:black;">
            <!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="https://api.whatsapp.com/send?phone=60174327624" style="color:#CFB53B;><i class="fa fa-phone"></i> 0174327624</a></li>
                                <li><a href="mailto:svsbiz23@gmail.com" style="color:#CFB53B;><i class="fa fa-envelope"></i> svsbiz23@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header_top-->

        <div class="header-middle">
            <!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href=".././index.php"><img src="../images/logo.jpeg" alt="logo" class="logo-img img-responsive" style="display:inline;"></a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
    ';
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] = true) 
                        {
                            if($_SESSION["user_role"]!=2)
                            {
                                echo 
                                '                       
                                    <li><a href="http://localhost/SVS-GlobalBiz-Solution/admin/admin-page.php"><i class="fa fa-user"></i> Account</a></li>
                                    <li><a href="../logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                                
                                ';
                            }
                            else
                            {
                                echo 
                                '                       
                                    <li><a href="http://localhost/SVS-GlobalBiz-Solution/customer/customer-page.php"><i class="fa fa-user"></i> Account</a></li>
                                    <li><a href="../customer/products-in-cart.php"><i class="fa fa-shopping-cart"></i> Cart</a></li>
                                    <li><a href="../logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                                
                                ';
                            }
                        }
                        else
                        {
                            echo
                            '
                                <li><a href="../login.php"><i class="fa fa-lock"></i> Login</a></li>
                                <li><a href="register-page.php"><i class="fa fa-lock"></i> Register</a></li>
                            ';
                        }

    echo
    '
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-middle-->

        <div class="header-bottom">
            <!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="../index.php">Home</a></li>
                                <li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
    ';

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
                                            <li><a href="shop-category.php?category_id='.$category_id.'">'.$category.'</a></li>
                                            ';
                                        }
                                    }
                                    else
                                    {
                                        echo 
                                        '
                                        <li><a href="#">No category found</a></li>
                                        ';
                                    }

    echo
    '   
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="#">Brand<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
    ';
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
                                            <li><a href="shop-brand.php?brand_id='.$brand_id.'">'.$brand.'</a></li>
                                            ';
                                        }
                                    }
                                    else
                                    {
                                        echo 
                                        '
                                        <li><a href="#">No brand found</a></li>
                                        ';
                                    }
                                
    echo
    '
                                </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-bottom-->
    </header>
    ';
?>
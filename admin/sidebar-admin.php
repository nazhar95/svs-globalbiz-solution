<?php
    //Selecting the information from the user_table
    $admin_id = $_SESSION["admin_id"];
    $sql = "SELECT * FROM admin_table WHERE admin_id='$admin_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) 
    {
    // output data of each row
        while($row = mysqli_fetch_assoc($result)) 
        {
            $admin_id = $row["admin_id"];
            $full_name = $row["full_name"];
            $admin_status=$row['admin_status'];
        }
    }
    else
    {
        echo "No result found";
    }

    echo
    '
    <nav class="sidebar sidebar-offcanvas" id="sidebar" style="background-color:#000;">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="admin-page.php" style="color:#CFB53B;">
                <i class="ti-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-customer" aria-expanded="false" aria-controls="ui-customer" style="color:#CFB53B;">
                <i class="ti-comments-smiley menu-icon"></i>
                <span class="menu-title">Customer Related</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-customer">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="customer-orders-page.php" style="color:#CFB53B;">Customer Orders</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic" style="color:#CFB53B;">
                <i class="ti-view-list menu-icon"></i>
                <span class="menu-title">Product Related</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="admin-add-product.php" style="color:#CFB53B;">Add New Product</a></li>
                        <li class="nav-item"> <a class="nav-link" href="admin-product-list.php" style="color:#CFB53B;">View All Products</a></li>
                        <li class="nav-item"> <a class="nav-link" href="view-product-by-category.php" style="color:#CFB53B;">View By Category</a></li>
                        <li class="nav-item"> <a class="nav-link" href="view-product-by-brand.php" style="color:#CFB53B;">View By Brand</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-sales" aria-expanded="false" aria-controls="ui-sales" style="color:#CFB53B;">
                <i class="ti-file menu-icon"></i>
                <span class="menu-title">Sales Report</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-sales">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="list-report-by-month.php" style="color:#CFB53B;">View Report By Month</a></li>
                        <!--<li class="nav-item"> <a class="nav-link" href="list-report-by-year.php" style="color:#CFB53B;">View Report By Year</a></li>-->
                    </ul>
                </div>
            </li>
        ';

        if($admin_status=="super_admin")
        {
            echo
            '
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-admin" aria-expanded="false" aria-controls="ui-admin" style="color:#CFB53B;">
                <i class="ti-file menu-icon"></i>
                <span class="menu-title">Admin Related</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-admin">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="list-new-admin.php" style="color:#CFB53B;">Approve New Admin </a></li>
                        <li class="nav-item"><a class="nav-link" href="create-admin.php" style="color:#CFB53B;">Create New Admin</a></li>
                        <li class="nav-item"><a class="nav-link" href="list-existing-admin.php" style="color:#CFB53B;">List All Admin</a></li>
                    </ul>
                </div>
            </li>  
            ';
        }

        echo
        '

            <li class="nav-item">
                <a class="nav-link" href="admin-profile-setting.php" style="color:#CFB53B;">
                <i class="ti-user menu-icon"></i>
                <span class="menu-title" style="color:#CFB53B;">Settings</span>
                </a>
            </li> 
        </ul>
    </nav>
    ';

?>
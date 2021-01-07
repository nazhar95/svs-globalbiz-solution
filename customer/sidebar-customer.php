<?php
    echo
    '
    <nav class="sidebar sidebar-offcanvas" id="sidebar" style="background-color:#000;">
        <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="customer-page.php" style="color:#CFB53B;">
            <i class="ti-home menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic" style="color:#CFB53B;">
            <i class="ti-view-list menu-icon"></i>
            <span class="menu-title">Products</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="products-in-cart.php" style="color:#CFB53B;">Products in Cart</a></li>
                <li class="nav-item"> <a class="nav-link" href="products-ordered-page.php" style="color:#CFB53B;">Products Ordered</a></li>
            </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="customer-profile-setting.php" style="color:#CFB53B;">
            <i class="ti-user menu-icon"></i>
            <span class="menu-title">Settings</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../index.php" style="color:#CFB53B;">
            <i class="ti-bag menu-icon"></i>
            <span class="menu-title">Shop</span>
            </a>
        </li> 
        </ul>
    </nav>
    ';

?>
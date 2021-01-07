<?php
  //Selecting the information from the admin table
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
    }
  }
  else
  {
    echo "No result found";
  }


    echo
    '
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="background-color:#000;">
        <a class="navbar-brand brand-logo mr-5" href="../index.php"><img src="../images/logo.jpeg" class="logo-img mr-2" alt="logo"></a>
        <a class="navbar-brand brand-logo-mini" href="../index.php"><span class="text-center" style="color:#CFB53B; background-color:black;">SVS</span></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="background-color:#000;color:#CFB53B">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-view-list"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown mr-1">
            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
              <b>Welcome, '.$full_name.'</b>
            </a>
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="../images/avatar.png" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="../logout.php">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="ti-view-list"></span>
        </button>
      </div>
    </nav>
    ';
?>
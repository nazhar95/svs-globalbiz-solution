<?php
    include("session-admin.php");

    if (isset($_POST['edit-product']))
    { 
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);

        //select the products based on the product_id and admin_id
        $sql = "SELECT * FROM product_info_table  
                LEFT JOIN product_category_table ON product_info_table.category_id = product_category_table.category_id 
                LEFT JOIN brand_table ON product_info_table.brand_id = brand_table.brand_id  
                WHERE admin_id='$admin_id' AND product_id='$product_id'";
        $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);

        if (mysqli_num_rows($result) > 0) 
        {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) 
            {
                $category = $row["product_category"];
                $category_id = $row["category_id"];
                $brand = $row["brand_name"];  
                $brand_id = $row["brand_id"];
                $product_id = $row["product_id"];
                $product_name = $row["product_name"];
                $product_price = $row["product_price"];
                $product_desc = $row["product_desc"];
                // $product_img = $row["product_img"];
                $stock = $row["stock"];
                $latest_updated_date = $row["latest_updated_date"];
                $admin_id = $row["admin_id"];
            }
        }
    }

    if(isset($_POST['update-product'])){
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $file = addslashes(file_get_contents($_FILES["product_img"]["tmp_name"]));
        $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
        $brand_id = mysqli_real_escape_string($conn, $_POST['brand_id']);
        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
        $product_desc = mysqli_real_escape_string($conn, $_POST['product_desc']);
        $stock = mysqli_real_escape_string($conn, $_POST['stock']);
        $admin_id = $_SESSION["admin_id"];
        $latest_updated_date = date("Y-m-d");

        $query = "UPDATE product_info_table SET 
                category_id='$category_id',
                brand_id='$brand_id',
                product_name='$product_name',
                product_price='$product_price',
                product_desc='$product_desc',
                stock='$stock',
                latest_updated_date='$latest_updated_date',
                product_img='$file'
                WHERE product_id='$product_id'; 
                ";        
        $result1=mysqli_query($conn, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($conn), E_USER_ERROR);

        echo 
        (
            "<script language='JAVASCRIPT'>
                window.alert('Product successfully updated.');
                window.location.href='admin-product-list.php';
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
    <title>Admin Edit Product Page | SVS GlobalBiz Solution</title>
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
    <script src="https://cdn.tiny.cloud/1/jqlvox6zxpy1h5n6mugmaw019hu1420xuak30zt7eavn5zdh/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
                    <h4 class="font-weight-bold mb-0">Edit Product</h4>
                    </div> 
                </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <form class="forms-sample" method="POST" id="update-product-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Product Category</label>
                            <select class="form-control" name="category_id" id="">
                                <option value="<?php echo $category_id; ?>"><?php echo $category; ?></option>
                            <?php
                                //Selecting the information from the product_category_table
                                $sql = "SELECT * FROM product_category_table ORDER BY product_category ASC";
                                $result = mysqli_query($conn, $sql); 
                                while ($row = mysqli_fetch_assoc($result))
                                {
                                    echo '<option value="'.$row['category_id'].'" >'.$row["product_category"].'</option>';  
                                }
                            ?> 
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Product Brand</label>
                            <select class="form-control" name="brand_id" id="">
                                <option value="<?php echo $brand_id; ?>"><?php echo $brand; ?></option>
                            <?php
                                //Selecting the information from the brand_table
                                $sql = "SELECT * FROM brand_table ORDER BY brand_name ASC";
                                $result = mysqli_query($conn, $sql); 
                                while ($row = mysqli_fetch_assoc($result))
                                {
                                    echo '<option value="'.$row['brand_id'].'" >'.$row["brand_name"].'</option>';  
                                }
                            ?> 
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Product Name" value="<?php echo $product_name; ?>" required/>
                        </div>
                        <div class="form-group">
                            <label>Product Price (RM)</label>
                            <input type="number" class="form-control" placeholder="0" value="<?php echo $product_price; ?>" name="product_price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" required/>
                        </div>
                        <div class="form-group">
                            <label>Product Description</label>
                            <textarea class="form-control" name="product_desc" rows="5" placeholder="Type in your product details here" min="10" max="300" required/><?php echo $product_desc; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Product Stock</label>
                            <input type="number" class="form-control" placeholder="0" name="stock" min="0" max="100" value="<?php echo $stock; ?>"required/>
                        </div>
                        <div class="form-group">
                            <label>Product Image</label>
                            <!-- <input type="file" name="product_img" class="file-upload-default"> -->
                            <div class="input-group col-xs-12">
                                <input type="file" class="form-control" name="product_img" id="product_img" placeholder="Upload Image">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="product_id" value="<?php echo $product_id; ?>">
                        </div>
                        <input type="submit" name="update-product" id="update-product" class="btn btn-warning mr-2 text-light" value="Submit">
                        <a href="admin-product-list.php"><input type="button" class="btn btn-danger mr-2 text-light" value="Cancel"></a>
                    </form>
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
    tinymce.init({
        selector: '#product_desc',
        width: 270,
        height: 300
    });
    </script>
    <script>
        $(document).ready(function(){
            $('#update-product').click(function(){
                var image_name = $('#product_img').val();
                if(image_name==''){
                    alert("Please select an image");
                    return false;
                }
                else{
                    var extension = $('#product_img').val().split('.').pop().toLowerCase();
                    if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1){
                        alert("Invalid image file!");
                        $('#product_img').val('');
                        return false;
                    }
                }
            })
        });
    </script>
    <script>
     $('#update-product-form').submit(function() {  
            return confirm("Are you sure you want to update this product information?");
        });
    </script>
    <!-- End custom js for this page-->
</body>

</html>


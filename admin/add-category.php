<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Add Category</title>

    <link rel="stylesheet" href="../css/admin.css" />

</head>
<body>

<!-- Start of the Header -->

    <?php include('partials/menu.inc.php'); ?>

<!-- End of the Header -->

<!-- Start of the Main Content -->

    <div class="main-content">
        <div class="wrapper">
            <h1 class="main-heading">Add Category</h1>

            <?php 
            
                if(isset($_SESSION['addCategory'])) {
                    ?>
                        <h3>
                            <?php 
                                echo $_SESSION['addCategory']; 
                                unset($_SESSION['addCategory']);
                            ?>
                        </h3>
                    <?php
                }

                if(isset($_SESSION['upload'])) {
                    ?>
                        <h3>
                            <?php
                                 echo $_SESSION['upload'];
                                 unset($_SESSION['upload']);
                             ?>
                        </h3>
                    <?php
                }

            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="table-30">

                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Category Title"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Image: </td>
                        <td>
                            <input type="file" name="image" />
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes"/> Yes
                            <input type="radio" name="featured" value="No"/> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="active" value="Yes"/> Yes
                            <input type="radio" name="active" value="No"/> No
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="submit" name="submit" class="btn-admin-add"/>
                        </td>
                    </tr>


                </table>
            </form>

        </div>
    </div>

<!-- End of the Main Content -->

<!-- Start of the Footer -->

    <?php include('partials/footer.inc.php'); ?>

<!-- End of the Footer -->
    
</body>
</html>


<?php 

    if(isset($_POST['submit'])) {
        // echo "Button Clicked";

        // 1. Get the data from the form and store in the variables

        $title = $_POST['title'];

        if(isset($_POST['featured'])) {
            
            $featured = $_POST['featured'];

        } else {

            $featured = "No";

        }

        if(isset($_POST['active'])) {

            $active = $_POST['active'];

        } else {

            $active = "No";

        }

        // print_r($_FILES['image']);
        // die();

        if(isset($_FILES['image']['name'])) {
            // Upload the image
            // To upload the image we need the image name, source path and destination path

            $image_name         =  $_FILES['image']['name'];

            if($image_name != "") {

                // Auto Rename the image
                // Get the extension of out image (jpg, png, gif, etc);

                // explode() = break from the dot
                // end() = take the image extension

                $extension = end(explode('.', $image_name)); // 'MediumPizza.jpg'

                // Rename the image

                $image_name = "Food_Category_" . rand(000, 999) . '.' . $extension; // Food_Category_223.jpg    

                $source_path         =  $_FILES['image']['tmp_name'];
                $destination_path   =  "../images/category/" . $image_name;

                // Finally upload the image

                $uploadFile = move_uploaded_file($source_path, $destination_path);

                // Check whether the file is upload or not

                if($uploadFile == false) {
                    
                    // Session Message to Print if image not uploaded
                    $_SESSION['upload'] = "<h3 class='error padding-bottom'>Failed to Upload Image. Try Again!</h3>";

                    // Redirect to to add category page
                    header('location:' . SITE_URL . 'admin/add-category.php');

                    // stop running from here
                    die();

                }

            }

        }



        // 2. Query to insert the data

        $sqlInsertCategory = "INSERT INTO tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
        ";

        //  3. Execute the Query

        $sqlInsertCategoryExecuted = mysqli_query($databaseConnection, $sqlInsertCategory);

        // 4. Checl whether the query is executed or not

        if($sqlInsertCategoryExecuted == TRUE) {

            // 5. Query Executed and Data Added

            $_SESSION['addCategory'] = "<h3 class='success' style='padding-bottom: 3%;'>Category Added Successfully</h3>";

            // Redirect to the Manage Cateogry page
            header('location:' . SITE_URL . 'admin/manage-category.php');

        } else {

            // 5. Query no executed and data not inserted
            $_SESSION['addCategory'] = "<h3 class='error' style='padding-bottom: 3%;'>Failed to Add Category. Try Again!</h3>";

            // Redirect to the manage-category page
            header('location: ' . SITE_URL . 'admin/add-category.php');

        }

    }

?>
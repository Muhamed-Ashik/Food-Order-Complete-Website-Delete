<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Update Category</title>

    <link rel="stylesheet" href="../css/admin.css" />

</head>
<body>


<!-- Start of the Menu -->

    <?php include('partials/menu.inc.php'); ?>

<!-- End of the Menu -->

<?php 

    if(isset($_GET['id'])) {

        // Data Found

        // echo "Data avaialable";

        // Get the id and store in the variable
        $id = $_GET['id'];

        // Fetch the data from the database
        $sqlUpdateCategory = "SELECT * FROM tbl_category WHERE id = $id";

        // Execute the query
        $sqlUpdateCategoryExecuted = mysqli_query($databaseConnection, $sqlUpdateCategory);

        // count the rows to check whether the id available or not
        $countRows = mysqli_num_rows($sqlUpdateCategoryExecuted);

        if($countRows == 1) {
            // Data avaiable

            // echo "Data Found";

            // Get the data
            $rows = mysqli_fetch_assoc($sqlUpdateCategoryExecuted);

            $title = $rows['title'];
            $current_image = $rows['image_name'];
            $featured = $rows['featured'];
            $active = $rows['active'];

        } else {
            // Data not available

            // Print a message 
            $_SESSION['category-not-found'] = "<h3 class='error padding-bottom'>Category Not Found. Try Again!</h3>";

            // Redirect to manage category
            header('location: ' . SITE_URL . 'admin/manage-category.php');
        }

    } else {

        // Redirect to the manage category page
        header('location:' . SITE_URL . 'admin/manage-category.php');

    }

?>


<!-- Start of the Main Area -->

    <div class="main-content">
        <div class="wrapper">
            <h1 class="main-heading">Update Category</h1>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="table-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title; ?>"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Current Image: </td>
                        <td>
                            <?php 
                            
                                if($current_image != "") {
                                    
                                    ?>

                                        <img src="../images/category/<?php echo $current_image; ?>" width="100px" /> 

                                    <?php
                                    
                                } else {
                                    
                                        echo "<div class='error'>No Image Added</div>";
                                    
                                }
                            
                            ?>

                        </td>
                    </tr>

                    <tr>
                        <td>New Image: </td>
                        <td>
                            <input type="file" name="image"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if($featured == "Yes") { echo "checked"; } ?> type="radio" name="featured" value="Yes"/> Yes
                            <input <?php if($featured == "No") { echo "checked"; } ?> type="radio" name="featured" value="No"/> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if($active == "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes" /> Yes
                            <input <?php if($active == "No") { echo "checked"; } ?> type="radio" name="active" value="No" /> No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <!-- Get the id from the form -->
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <!-- Get the image -->
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>"/>

                            <input type="submit" name="submit" value="Update Category" class="btn-update"/>
                        </td>
                    </tr>

                </table>
            </form>

            <?php 
            
                if(isset($_POST['submit'])) {
                    // echo "Button Clicked";

                    // Get all the data from the form
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $current_image = $_POST['image_name'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    // Update the image if image is not exists

                    if(isset($_FILES['image']['name'])) {
                        
                        // Get the image details
                        $image_name = $_FILES['image']['name'];

                        if($image_name != "") {
                            // Image Available
                            // Upload the Image

                            // Rename the image

                            $extension = end(explode('.', $image_name)); // break the extension

                            $image_name = "Food_Category_".rand(000, 999).'.'.$extension; // eg: Food_Category_737.jpg

                            $source_path = $_FILES['image']['tmp_name'];

                            $destination_path = "../images/category/".$image_name;

                            $upload = move_uploaded_file($source_path, $destination_path);

                            // Check whether the image is uploaded or not
                            if($upload == false) {

                                $_SESSION['upload'] = "<h3 class='error padding-bottom'>Failed to Update Image.</h3>";
                                header('location: ' . SITE_URL . 'admin/manage-category.php');
                                die();

                            }

                            // Remove the current image
                            if($current_image != "") {

                                $remove_path = "../images/category/".$current_image;
                                 $remove = unlink($remove_path);

                            // Check whether the image is removed or not
                                if($remove == false) {

                                     $_SESSION['failed-remove'] = "<h3 class='error padding-bottom'>Failed to Remove Current Image</h3>";
                                     header('location: ' . SITE_URL . 'admin/manage-category.php');
                                     die();
                                     
                                 }

                            }

                        }  else {

                            // use the current old image
                            $image_name = $current_image;   

                        }
                            
                    } else {

                        // if the new image not selected then use the old image                        
                        $image_name = $current_image;

                    }

                    // Update the database

                    $sqlUpdateCategoryNew = "UPDATE tbl_category SET
                        title = '$title',
                        image_name = '$image_name',
                        featured = '$featured',
                        active = '$active'
                        WHERE id = $id
                    ";


                    // Execute the Query
                    $sqlUpdateCategoryNewExecuted = mysqli_query($databaseConnection, $sqlUpdateCategoryNew);

                    // Check wther updated or not and redirect
                    if($sqlUpdateCategoryNewExecuted == TRUE) {
                        
                        // Print the session essage and redirect
                        $_SESSION['update'] = "<h3 class='success padding-bottom'>Category Updated Successfully.</h3>";
                        header('location: ' . SITE_URL . 'admin/manage-category.php');

                    } else {
                    
                        $_SESSION['update'] = "<h3 class='error padding-bottom'>Failed to Updated Category. Try Again!</h3>";
                        header('location: ' . SITE_URL . 'admin/manage-admin.php');

                    }

                }
            
            ?>

        </div>
    </div>

<!-- End of the Main Area -->

<!-- Start of the Footer -->

    <?php include('partials/footer.inc.php'); ?>

<!-- End of the Footer -->
    
</body>
</html>



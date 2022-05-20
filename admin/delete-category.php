<?php include('../config/constants.php'); ?>


<?php 
    
    // echo "Delete Category";

    // check whether the id and image as set or not

    if(isset($_GET['id']) AND isset($_GET['image_name'])) {

        // image and id set
        // echo "Image and id found";

        // Get the data and store in the variable
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Check whether the image is avaialbe or not
        if($image_name != "") {
            // Image Available then remove it

            // Path of the image folder
            $path = "../images/category/" . $image_name;

            // Remove it
            $remove = unlink($path);

            // check whether the image removed or not
            if($remove == false) {
                // Print a session message
                $_SESSION['remove'] = "<h3 class='error padding-bottom'>Failed to Remove the Category Image</h3>";

                // Redirect to the manage category page
                header('location:' . SITE_URL . 'admin/manage-category.php');

                // Stop the process
                die();
            }

        }

        // Delete the data from database
        $sqlDeleteCategory = "DELETE FROM tbl_category WHERE id = $id";

        // Execute the query
        $sqlDeleteCategoryExecuted = mysqli_query($databaseConnection, $sqlDeleteCategory);

        // Check whether the data is deleted or not
        if($sqlDeleteCategoryExecuted == TRUE) {

            // Data deleted

            // Print a Session with message
            $_SESSION['delete'] = "<h3 class='success padding-bottom'>Category Deleted Successfully</h3>";

            // Redirect to manage category page
            header('location:' . SITE_URL . 'admin/manage-category.php');

        } else {

            // Data not deleted

            // Print a Session with amessage
            $_SESSION['delete'] = "<h3 class='error padding-bottom'>Failed to Delete Category</h3>";

            // Redirect to Manage Category .phpp
            header('location:' . SITE_URL . 'admin/manage-category.php');

        }


    } else {

        // Image and id not set

        // Redirect to the manage category page
        header('location:' . SITE_URL . 'admin/manage-category.php');
    
    }

?>
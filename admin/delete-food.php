<?php include('../config/constants.php'); ?>

<?php 
    // Check whether we are getting the id and image name and if true, then process to deelte
    if(isset($_GET['id']) && isset($_GET['image_name'])) {

        // echo "Process to delete";

        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Check whether the image_name is available or not
        if($image_name != "") {

            // Image Available and find the path of the image
            $path = "../images/food/" . $image_name;
            
            // remove the image
            $removed = unlink($path);

            // Check whether the image is remove or not
            if($removed == false) {
                // Image Not Removed then, pass a Session message with redirection and stop the proces
                $_SESSION['image-remove'] = "<h3 class='error padding-bottom'>Failed to Remove Image</h3>";
                header('location: ' . SITE_URL . 'admin/manage-food.php'); // redirection
                die(); //stop

            }
            

        } // END OF THE IMAGE CHECK VALIDATION IF

        // IF IMAGE IS NOT AVAILABLE THEN DIRECTLY RUN THE BELOW COMMAND

        // Query to delete the record
        $sqlDeleteFoodQuery = "DELETE FROM tbl_food WHERE id = $id";

        // Execute the query
        $sqlDeleteFoodQueryExecuted = mysqli_query($databaseConnection, $sqlDeleteFoodQuery);

        // Check whether the query is executed and data deleted or not
        if($sqlDeleteFoodQueryExecuted == TRUE) {

            // Executed and data deleted and print session and redirection
            $_SESSION['delete-data'] = "<h3 class='success padding-bottom'>Record Deleted Successfully</h3>";
            header('location: ' . SITE_URL . 'admin/manage-food.php'); // redirection

        } else {

            // Executed but data not deleted then, Print session and redirection
            $_SESSION['delete-data'] = "<h3 class='error padding-bottom'>Failed to Delete Record.</h3>";
            header('location: ' . SITE_URL . 'admin/manage-food.php'); // redirection

        }


    } else {

        // id and image_name not getting
        $_SESSION['unauthorized-access'] = "<div class='error' style='padding-bottom: 3%;'>Unauthorized Access</div>";
        header('location: '. SITE_URL . 'admin/manage-food.php');

    } // END OF THE ID AND IMAGE_NAME GET IF

?>
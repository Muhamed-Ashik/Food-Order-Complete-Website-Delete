<?php ob_start(); ?>

<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Update Food</title>

    <link rel="stylesheet" href="../css/admin.css"/>

</head>
<body>

<!-- START OF THE MENU -->
    <?php include('partials/menu.inc.php'); ?>
<!-- END OF THE MENU-->

<!-- START OF THE MAIN AREA -->
    <div class="main-content">
        <div class="wrapper">
            <h1 class="main-heading">Update Food</h1>

            
<?php 

    if(isset($_GET['id'])){

          // Id found then, fetch the data

        $id = $_GET['id'];

        // Query to fetch the data
        $sqlFetchFoodQuery = "SELECT * FROM tbl_food WHERE id = $id";

        // Execute the Query
        $sqlFetchFoodQueryExecuted = mysqli_query($databaseConnection, $sqlFetchFoodQuery);

        // Get the data and store in the associative array
        $sqlRows = mysqli_fetch_assoc($sqlFetchFoodQueryExecuted);

        // store the data in to variable from the array

        $title = $sqlRows['title'];
        $description = $sqlRows['description'];
        $price = $sqlRows['price'];
        $current_image = $sqlRows['image_name'];
        $current_category = $sqlRows['category_id'];
        $featured = $sqlRows['featured'];
        $active = $sqlRows['active'];

    } else {

       
         // Id no found the, print the session and redirection
        $_SESSION['no-access'] = "<h3 class='error padding-bottom'>Unauthorized Access</h3>";
        header('location: ' . SITE_URL . 'admin/manage-food.php');
       
    }

?>
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="table-30">

                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title; ?>"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="num" name="price" value="<?php echo $price; ?>"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Current Image: </td>
                        <td>
                            <?php 
                            
                                if($current_image == "") {

                                    // Image Not Available them, display the message
                                    echo "<div class='error'>Image Not Available</div>";

                                } else {

                                    // Image Available then, grap the image
                                    ?>
                                       <img src="<?php echo SITE_URL ?>images/food/<?php echo $current_image; ?>" width="100px">
                                    <?php

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
                        <td>Category: </td>
                        <td>
                            <select name="category">

                            <?php 
                            
                                // Query to fetch the active category
                                $sqlFetchCategoryQuery = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                                // Execute the query
                                $sqlFetchCategoryQueryExecuted = mysqli_query($databaseConnection, $sqlFetchCategoryQuery);

                                // check whether the query executed or not by counting the rows
                                $sqlCountRows = mysqli_num_rows($sqlFetchCategoryQueryExecuted);

                                // check whether the record is fetched or not
                                if($sqlCountRows > 0) {

                                    // Category Fetched then, display the category using the while loop
                                    while($sqlRows = mysqli_fetch_assoc($sqlFetchCategoryQueryExecuted)) {

                                        $category_id = $sqlRows['id'];
                                        $category_title = $sqlRows['title'];

                                        // echo "<option value='$category_id'> $category_title </option>";

                                        ?>
                                            <!-- $category_id = coming from the tbl_category -->
                                            <!-- $current_category = coming from category table id but saved in food -->
                                            <option <?php if($current_category == $category_id) { echo "selected"; } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                        <?php

                                    } // END OF THE WHILE LOOP


                                } else {

                                     // Catrgory Not Fetched then, display the messages
                                    //echo "<option value='0' class='error'>Category Not Available</option>";
                                    ?>
                                        <option value="0"><?php echo "<div class='error'>Catrgory Not Avalialble</div>"; ?></option>
                                    <?php

                                }
                            
                            ?>

                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if($featured == 'Yes') { echo "checked"; } ?> type="radio" name="featured" value="Yes"/> Yes
                            <input <?php if($featured == 'No') { echo "checked"; } ?> type="radio" name="featured" value="No"/> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if($active == 'Yes') { echo "checked"; } ?> type="radio" name="active" value="Yes"/> Yes
                            <input <?php if($active == 'No') { echo "checked"; } ?> type="radio" name="active" value="No"/> No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <!-- Get the id -->
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>

                            <!-- Get the current image -->
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>"/>

                            <input type="submit" name="submit" value="Update Food" class="btn-update"/>
                        </td>
                    </tr>
                    
                </table>
            </form>

        </div><!--END OF THE WRAPPER-->
    </div> <!--END OF THE MAIN-CONTENT-->

<!-- END OF THE MAIN AREA-->

<!-- START OF THE FOOTER -->
    <?php include('partials/footer.inc.php'); ?>    
<!-- END OF THE FOOTER-->

  <?php 
            
                if(isset($_POST['submit'])) {
                    // echo "Button Cliked";

                    // 1. Get the data from the form and store in the variables
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $category = $_POST['category'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    // 2. upload the image if new image is selected

                    if(isset($_FILES['image']['name'])) {

                        // get the image and store in the variable
                        $image_name = $_FILES['image']['name'];
                        

                        // check whether the image is available or not in the variable
                        if($image_name != "") {
                            

                            // image available then, break the image name and get the extension
                            $extension = end(explode('.', $image_name)); // eg: Pizza.jpg = .jpg

                            // Rename the image and combind with random values
                            $image_name = "Food_Category_" . rand(0000, 9999) . '.' . $extension; // eg: Food_Category_1234.jpg

                            // Get the source path
                            $source_path = $_FILES['image']['tmp_name'];

                            // Set Destination path to save the image
                            $destination_path = "../images/food/".$image_name;

                            // upload the image to the new location
                            $uploaded = move_uploaded_file($source_path, $destination_path);

                            // check whether the image is uploaded or not and if not then, print a message and redirect and stop
                            if($uploaded == false) {

                                // Image Not Uploaded
                                $_SESSION['upload'] = "<h3 class='error padding-bottom'>Failed to Upload Image</h3>";
                                header('location: ' . SITE_URL . 'admin/manage-food.php'); // redirection
                                die(); // stop

                            }

                            // 3. if the new image is uploaded then remove the old image

                           if($current_image != "") {

                                // image available then, then find the path
                              $remove_path = "../images/food/".$current_image;

                                // remove the image
                              $remove = unlink($remove_path);

                                // check whether the image is removed or not
                               if($remove == false) {

                                    // image not removed then, print session and redirect and stop
                                  $_SESSION['remove-failed'] = "<h3 class='error padding-bottom'>Failed to Remove Image</h3>";
                                  header('location:' . SITE_URL . 'admin/manage-food.php'); // redirection
                                  die(); // stop

                               }
                               
                            }
                            

                        } else {

                            // image not available, grap the current image
                           $image_name = $current_image;

                        }
                        
                    } else {

                        // if new image not set then, use the current image
                       $image_name = $current_image;
                        
                    }

                    // 4. Query to update the food database

                    $sqlUpdateQuery = "UPDATE tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = '$category',
                        featured = '$featured',
                        active = '$active'
                        WHERE id = $id;
                    ";

                    // Execute the query
                    $sqlUpdateQueryExecuted = mysqli_query($databaseConnection, $sqlUpdateQuery);

                    // check whether the query executed and data updated or not
                    if($sqlUpdateQueryExecuted == TRUE) {

                        // Data updated and session printed and redirection
                        $_SESSION['updateFood'] = "<h3 class='success padding-bottom'>Food Updated Successfully</h3>";
                        header('location:' . SITE_URL . 'admin/manage-food.php');

                    } else {

                        // data not updated session printed and redirection
                        $_SESSION['updateFood'] = "<h3 class='error padding-bottom'>Failed to Updated Food</h3>";
                        header('location:' . SITE_URL . 'admin/manage-food.php');
                         
                    }


                }
            
            ?>
    
</body>
</html>

<?php ob_end_flush(); ?>

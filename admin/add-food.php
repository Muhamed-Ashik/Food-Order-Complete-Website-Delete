<?php ob_start(); ?>

<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Add Food</title>

    <link rel="stylesheet" href="../css/admin.css"/>

</head>
<body>

<!-- Start of the Menu -->

    <?php include('partials/menu.inc.php'); ?>

<!-- End of the Menu -->

<!-- Start of the Main Area -->

    <div class="main-content">
        <div class="wrapper">
            <h1 class='main-heading'>Add Food</h1>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class='table-30'>
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Enter the Food Title"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description For the Food"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="num" name="price" placeholder="Enter the Price"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Image Name: </td>
                        <td>
                            <input type="file" name="image"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category">

                            <?php 
                            
                                // Sql Query to fetch the record
                                $sqlFetchCategory = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                                // Execute the query
                                $sqlFetchCategoryExecuted = mysqli_query($databaseConnection, $sqlFetchCategory);

                                // if executed then count the rows
                                $sqlCount = mysqli_num_rows($sqlFetchCategoryExecuted);

                                // check whether the data fetched or not
                                if($sqlCount > 0) {

                                    // Data Fetched and get all the data using while loop
                                    while($sqlCountRows = mysqli_fetch_assoc($sqlFetchCategoryExecuted)) {

                                        $id = $sqlCountRows['id'];
                                        $title = $sqlCountRows['title'];

                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php

                                    } // End of the while loop

                                    
                                } else {

                                    // Data Not Available then Display Message
                                    ?>
                                        <option value="0">No Category Found</option>
                                    <?php

                                }
                            
                            ?>

                            </select>
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
                            <input type="radio" name="active" value="Yes" /> Yes
                            <input type="radio" name="active" value="No" /> No
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="submit" name="submit" value="Add Food" class='btn-admin-add'/>
                        </td>
                    </tr>

                </table>
            </form>

<?php

    if(isset($_POST['submit'])) {
        // echo "Button Cliked";

        // Get all the form data into variables
         $title = $_POST['title'];
         $description = $_POST['description'];
         $price = $_POST['price'];
         $category = $_POST['category'];

        if(isset($_POST['featured'])) {

             $featured = $_POST['featured'];  // Get the featured

        } else {

             $featured = "No";   // Add default value

        } // END OF THE FEATURED IF AND ELSE

        if(isset($_POST['active'])) {

             $active = $_POST['active']; // Get the active

        } else {

             $active = "No";  // Default value

        } // END OF THE ACTIVE IF AND ELSE

    
        if(isset($_FILES['image']['name'])) {
            // Once the chose file clicked and seleted and image

            // Get the image details
            $image_name = $_FILES['image']['name'];

            // the image_name is not blank then execute other
            if($image_name != "") {

                // To Rename Image Get Image name and break the extension
                $extension = end(explode('.', $image_name)); // eg: Pizza.jpg = Pizza jpg

                // Rename the image name using the random
                $image_name = "Food_Category_" . rand(0000, 9999) . '.' . $extension;


                // To upload the image Get the source path
                $source_path = $_FILES['image']['tmp_name'];

                // Set the destination path
                $destination_path = "../images/food/" . $image_name;

                // upload the image
                $uploaded = move_uploaded_file($source_path, $destination_path);

                // check whether the image is uploaded or not
                if($uploaded == false) {

                    // image not uploaded then, print a session and redirect and die
                    $_SESSION['upload'] = "<h3 class='error padding-bottom'>Failed to Upload the Image</h3>";
                    header('location: ' . SITE_URL . 'admin/manage-food.php');
                    die();
                
                }

            }
            
        } else {
            // Once the chose file clicked but no image was selected 

            // Not selected 
            $image_name = "";

        } // END OF THE IMAGE GET AND UPLOAD IF AND ELSE

        // INSERT INTO DATABASE

        // Query to insert into database
        $sqlInsertQuery = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = '$category',
            featured = '$featured',
            active = '$active'
        ";

        // Execute the Query
        $sqlInsertQueryExecuted = mysqli_query($databaseConnection, $sqlInsertQuery);

        // Check whether the query is executed and data added or not and redirect
        if($sqlInsertQueryExecuted == TRUE) {

            // Data Added
            $_SESSION['add'] = "<h3 class='success padding-bottom'>Food Successfully Added</h3>";
            header('location: ' . SITE_URL . 'admin/manage-food.php');

        } else {

            // Data Not Added
            $_SESSION['add'] = "<div class='error padding-bottom'>Failed to Add Food</div>";
            header('location: ' . SITE_URL . 'admin/manage-food.php');

        }
       

    } // END OF THE SUBMIT BUTTON                         

?>


        </div><!--END OF THE WRAPPER DIV -->
    </div><!--END OF THE MAIN-CONTENT DIV-->

<!-- END OF THE MAIN AREA -->

<!-- START OF THE FOOTER-->

    <?php include('partials/footer.inc.php'); ?>

<!-- END OF THE FOOTER -->
    
</body>
</html>

<?php ob_end_flush(); ?>
<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Manage Category</title>

    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>


<?php 
    include('partials/menu.inc.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="main-heading">Manage Category</h1>

        <?php 

            if(isset($_SESSION['addCategory'])) {
                
                echo $_SESSION['addCategory']; 
                unset($_SESSION['addCategory']);
                  
            }


            if(isset($_SESSION['delete'])) {
                ?>
                    <h3>
                        <?php
                             echo $_SESSION['delete']; 
                             unset($_SESSION['delete']);
                        ?>
                    </h3>
                    
                <?php
            }

            if(isset($_SESSION['category-not-found'])) {
                 
                echo $_SESSION['category-not-found'];
                unset($_SESSION['category-not-found']);
            
            }

            if(isset($_SESSION['update'])) {
                
                echo $_SESSION['update'];
                unset($_SESSION['update']);
                  
            }

            if(isset($_SESSION['upload'])) {
                
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            
            }

            if(isset($_SESSION['remove'])) {
                
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
                   
            }
        
        ?>

        
            <!-- Button for Add Admin -->
            <a href="<?php echo SITE_URL; ?>admin/add-category.php" class="btn-add">Add Category</a>

            <table class="admin-view-table">
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Image Name</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php 
                
                    // Query to get the data
                    $sqlFetchCategory = "SELECT * FROM tbl_category";

                    // Execute the Query
                    $sqlFetchCategoryExecuted = mysqli_query($databaseConnection, $sqlFetchCategory);

                    //   Count the rows
                    $countRows = mysqli_num_rows($sqlFetchCategoryExecuted);

                    // Create a seiral number and store it

                    $serial_number = 1;

                    // check whether is there any data or not in the database

                    if($countRows > 0) {

                        // Data avaiable

                        while($rows = mysqli_fetch_assoc($sqlFetchCategoryExecuted)) {

                       
                            $id = $rows['id'];
                            $title = $rows['title'];
                            $image_name = $rows['image_name'];
                            $featured = $rows['featured'];
                            $active = $rows['active'];

                            ?>

                            <tr>

                                <td><?php echo $serial_number++; ?></td>
                                <td><?php echo $title; ?></td>

                                   <td>

                                        <?php 

                                            if($image_name != "") {

                                                // Display the Image

                                                // echo $image_name;

                                                ?>

                                                    <img src="<?php echo SITE_URL; ?>images/category/<?php echo $image_name; ?>" width="100px">

                                                <?php
                                                
                                            } else {

                                                echo "<div class='error'>No Image Added</div>";

                                            }
                                
                                        ?>

                                </td>
                                
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="<?php echo SITE_URL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-update">Update Category</a>
                                    <a href="<?php echo SITE_URL; ?>admin/delete-category.php?id=<?php echo $id; ?> & image_name=<?php echo $image_name; ?>" class="btn-delete">Delete Category</a>
                                </td>
                            </tr>

                            <?php

                        } // end of the while loop


                    } else {

                        // Data not available

                         ?>

                            <tr>
                                <td colspan="6"><div class="error">No Category Added.</div></td>
                            </tr>

                        <?php   

                    }
                
                ?>
     
            </table>


    </div><!--End of the Wrapper Div-->
</div><!--End of the Main Content Div-->

<?php 
    include('partials/footer.inc.php');
?>

</body>
</html>

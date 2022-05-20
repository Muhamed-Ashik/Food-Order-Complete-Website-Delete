<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Manage Food</title>

    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

<?php 
    include('partials/menu.inc.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="main-heading">Manage Food</h1>

        <?php 
     
            if(isset($_SESSION['add'])) {
                 
                echo $_SESSION['add'];
                unset($_SESSION['add']);
                 
            }

            if(isset($_SESSION['unauthorized-access'])) {
                
                echo $_SESSION['unauthorized-access']; 
                unset($_SESSION['unauthorized-access']);
                      
            }

            if(isset($_SESSION['image-remove'])) {
                
                echo $_SESSION['image-remove'];
                unset($_SESSION['image-remove']);
                   
            }

            if(isset($_SESSION['delete-data'])) {
                
                echo $_SESSION['delete-data'];
                unset($_SESSION['delete-data']);
                    
            }

            if(isset($_SESSION['upload'])) {
                
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
                   
            }

            if(isset($_SESSION['remove-failed'])) {
                
                echo $_SESSION['remove-failed'];
                unset($_SESSION['remove-failed']);
                   
            }

            if(isset($_SESSION['updateFood'])) {
               
                echo $_SESSION['updateFood'];
                unset($_SESSION['updateFood']);
                    
            }

            if(isset($_SESSION['no-access'])) {
              
                echo $_SESSION['no-access'];
                unset($_SESSION['no-access']);
                   
            }

        
        ?>

          <!-- Button for Add Admin -->
            <a href="<?php echo SITE_URL; ?>admin/add-food.php" class="btn-add">Add Food</a>

            <table class="admin-view-table">
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>


                <?php 
                
                    // Query to Fetch the data
                    $sqlFetchFoodQuery = "SELECT * FROM tbl_food";

                    // Execute the query
                    $sqlFetchFoodQueryExecuted = mysqli_query($databaseConnection, $sqlFetchFoodQuery);

                    // Count the rows to check whether the data is fetched or not
                    $sqlCountRows = mysqli_num_rows($sqlFetchFoodQueryExecuted);

                    // Serial number
                    $serial_number = 0;

                    // Check whether data is available or not and display it
                    if($sqlCountRows > 0) {
                        // Use the while loop get all the data

                        while($sqlRows = mysqli_fetch_assoc($sqlFetchFoodQueryExecuted)) {

                            // store in the variables

                            $id = $sqlRows['id'];
                            $title = $sqlRows['title'];
                            $price = $sqlRows['price'];
                            $image_name = $sqlRows['image_name'];
                            $featured = $sqlRows['featured'];
                            $active = $sqlRows['active'];
                            $serial_number++;

                            ?>

                            <tr>
                                <td> <?php echo $serial_number; ?> </td>
                                <td> <?php echo $title;    ?> </td>
                                <td> <?php echo $price;    ?> </td>
                                <td> 
                                    <?php 
                                        if($image_name == "") {

                                            // Not available
                                            echo "<div class='error'>Image Not Added</div>";

                                        } else {

                                            // Image Avaibale
                                            ?>
                                                <img src="<?php echo SITE_URL; ?>images/food/<?php echo $image_name; ?>" width="100px;"/>
                                            <?php

                                        }
                                    ?> 
                                </td>
                                <td> <?php echo $featured; ?> </td>
                                <td> <?php echo $active;   ?> </td>
                                <td>
                                    <a href="<?php echo SITE_URL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-update">Update Food</a>
                                    <a href="<?php echo SITE_URL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-delete">Delete Food</a>
                                </td>
                            </tr>

                            <?php

                        } // END OF THE WHILE LOOP

                    } else {

                        // Data not Available, then display a error message
                        echo "<tr>
                                <td class='error'>Food Not Added Yet</td>
                             </tr>";

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
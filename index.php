<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website - Home</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- START OF THE NAVBAR SECTION -->
    
        <?php 
        
            include('front-partials/menu.inc.php');
        
        ?>

    <!-- END OF THE NAVBAR SECTION -->

    <!-- START OF THE FOOD SEARCH SECTION  -->

    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITE_URL ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

            <?php
            
                // Food Order Confirmation Session

                if(isset($_SESSION['upload'])) {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            
            ?>

        </div>
    </section>

    <!-- END OF THE FOOD SEARCH SECTION-->

    <!-- START OF THE CATEGORIES SECTION -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center text-orange">Explore Foods</h2>

            <!-- CODE TO FETCH CATEGORY -->

            <?php
            
                $sqlFetchCategory = "SELECT * FROM tbl_category WHERE featured = 'Yes' AND active = 'Yes' LIMIT 3"; // SQL query to fetch category 
                $sqlFetchCategoryExecuted = mysqli_query($databaseConnection, $sqlFetchCategory); // Execute the sql query
                $sqlCountRows = mysqli_num_rows($sqlFetchCategoryExecuted); // check whether the query executed and fetched the count of data

                // check the count of data and fetch the data
                if($sqlCountRows > 0) {

                    // Data Available then, fetched the data using the while loop
                    while($sqlRows = mysqli_fetch_assoc($sqlFetchCategoryExecuted)) {

                        // Fetch the data and store in the variable
                        $id = $sqlRows['id'];
                        $title = $sqlRows['title'];
                        $image_name = $sqlRows['image_name'];

                        ?>

                        <a href="<?php echo SITE_URL ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                            
                                <?php
                                
                                 // Check whether the image is available or not and if not print the message 
                                    if($image_name == "") {

                                        //  Print the message
                                        echo "<h5 class='error'>Image Not Available</h5>";
                                        
                                    } else {

                                        // Print the image
                                        ?>
                                            <img src="<?php echo SITE_URL ?>images/category/<?php echo $image_name; ?>" class="img-responsive img-curve">
                                        <?php
                                        
                                       
                                    } // END OF THE IMAGE AVAILABLE CHECK IF AND ELSE

                                ?>

                                <h3 class="float-text text-white"><?php echo $title; ?></h3>

                            </div>
                        </a>

                        <?php

                    } // END OF THE WHILE LOOP
                    

                } else {

                    // Category Not Available then, print the session message
                    echo "<h1 class='error'>Category Not Available</h1>";

                }


            
            ?>

            

            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- END OF THE CATEGORIES SECTION -->

    <!-- START OF THE MENU SECTION -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center text-orange">Food Menu</h2>

            <!-- FETCH THE FOOD  -->

            <?php 
                // query to fetch the food if the active and feature yes only
                $sqlFetchFood = "SELECT * FROM tbl_food WHERE featured = 'Yes' AND active = 'Yes' LIMIT 6";

                // Execute the query
                $sqlFetchFoodExecuted = mysqli_query($databaseConnection, $sqlFetchFood);
                
                // get the count of all the data
                $sqlRowsCount = mysqli_num_rows($sqlFetchFoodExecuted);
                
                // check wether the data count is avaialable or not
                if($sqlRowsCount > 0) {
                    // data available
                    // echo "Data found";

                    // get the record using the while looop
                    while($sqlRows = mysqli_fetch_assoc($sqlFetchFoodExecuted)) {

                        // store the data in variables
                        $id = $sqlRows['id'];
                        $title = $sqlRows['title'];
                        $price = $sqlRows['price'];
                        $description = $sqlRows['description'];
                        $image_name = $sqlRows['image_name'];

                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">

                                <?php 
                                    // check whether image is or not, if not then display message
                                    if($image_name == "") {

                                        // display the message
                                        echo "<h5 class='error'>Image Not Available</h5>";

                                    } else {

                                        // display the image
                                        ?>
                                            <img src="<?php echo SITE_URL ?>/images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">
                                        <?php

                                    }
                                ?>

                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">Rs: <?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITE_URL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary text-bold">Order Now</a>
                            </div>
                        </div>

                    <?php

                    } // END OF THE WHILE LOOP

                } else {

                    // Food not available, the display the message
                    echo "<h1 class='error'>Food Not Available</h1>";

                }

            ?>

            

            <div class="clearfix"></div>

            

        </div>

        <p class="text-center text-bold">
            <a href="<?php echo SITE_URL ?>foods.php">See All Foods</a>
        </p>
    </section>
    <!-- END OF THE MENU SECTION -->

    <!-- START OF THE FOOTER SECTION -->
        <?php 

            include('front-partials/footer.inc.php');

        ?>
    <!-- END OF THE FOOTER SECTION -->

   

</body>
</html>
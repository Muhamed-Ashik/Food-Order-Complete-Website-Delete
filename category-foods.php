<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website - Category Foods</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    
    <!-- START OF THE NAVBAR SECTION -->
        <?php 
        
            include('front-partials/menu.inc.php');

        ?>
    <!-- END OF THE NAVBAR SECTION -->

    <!-- START OF THE FOOD SEARCH SECTION-->
    <section class="food-search text-center">
        <div class="container">

        <?php 
        
            // check whether the category_id is set or not
            if(isset($_GET['category_id'])) {

                // Get the category_id and store
                $category_id = $_GET['category_id'];

                // query to get the categoru title according to the category_id
                $sqlFetchTitle = "SELECT title FROM tbl_category WHERE id = $category_id";
                
                // execute the query
                $sqlFetchTitleExecuted = mysqli_query($databaseConnection, $sqlFetchTitle);
                
                // fetch the record
                $sqlRow = mysqli_fetch_assoc($sqlFetchTitleExecuted);

                $category_title = $sqlRow['title'];
                // echo $category_title;
                
            } else{

                // if category_id not set, then direct
                header('location: '. SITE_URL);

            }
        
        ?>
            
            <h2>Foods on <a href="#" class="text-orange text-bold">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- END OF THE FOOD SEARCH SECTION-->



    <!-- START OF THE MENU SECTION -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center text-orange">Food Menu</h2>

            <?php 
            
                // query to fetch the food based on the category id
                $sqlFetchFood = "SELECT * FROM tbl_food WHERE category_id = $category_id";

                // execute the query
                $sqlFetchFoodExecuted = mysqli_query($databaseConnection, $sqlFetchFood);

                // get the count of all record
                $sqlRowsCount = mysqli_num_rows($sqlFetchFoodExecuted);

                // check whether count if found or not
                if($sqlRowsCount > 0) {
                    // Food Found
                    // echo "Food Available";

                    // get the food using while
                    while($sqlRows = mysqli_fetch_assoc($sqlFetchFoodExecuted)) {

                        // store the food
                        $id = $sqlRows['id'];
                        $title = $sqlRows['title'];
                        $price = $sqlRows['price'];
                        $description = $sqlRows['description'];
                        $image_name = $sqlRows['image_name'];

                    ?>
                         <div class="food-menu-box">
                            <div class="food-menu-img">

                                <?php
                                
                                    // check whether the image is available or not
                                    if($image_name == "") {

                                        // image not found, then display the message
                                        echo "<h5 class='error'>Image Not Available</h5>";

                                    } else {

                                        // image found, then display the image
                                        ?>
                                            <img src="<?php echo SITE_URL ?>images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">
                                        <?php

                                    }
                                
                                ?>

                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">Rs. <?php echo $price; ?></p>
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
                    
                    // Food not found
                    echo "<h1 class='error'>Food Not Available</h1>";
                }
            
            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- END OF THE MENU SECTION -->

    <!-- START OF THE FOOTER SECTION -->
        <?php 
            include('front-partials/footer.inc.php');
        ?>
    <!-- END OF THE FOOTER SECTION -->

</body>
</html>
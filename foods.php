<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website - Foods</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <!-- START OF THE NAVBAR SECTION -->
        <?php 

            include('front-partials/menu.inc.php');

        ?>
    <!-- END OF THE NAVBAR SECTION -->

    <!-- START OF THE FOOD SEARCH SECTION -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITE_URL ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- END OF THE FOOD SEARCH SECTION -->



    <!-- START OF THE FOOD MENU SECTION -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center text-orange">Food Menu</h2>

            <!-- FETCH THE FOOD -->

                <?php 
                    // query fetch the food which are only active YES
                    $sqlFetchFood = "SELECT * FROM tbl_food WHERE active = 'Yes'";

                    // execute the query
                    $sqlFetchFoodExecuted = mysqli_query($databaseConnection, $sqlFetchFood);

                    // get the count of all food
                    $sqlRowsCount = mysqli_num_rows($sqlFetchFoodExecuted);

                    // check wether the count is available or not
                    if($sqlRowsCount > 0) {

                        
                         // Food Availalbe, then fetch it using while loop
                        while($sqlRows = mysqli_fetch_assoc($sqlFetchFoodExecuted)) {

                            // store the data in vaiables
                            $id = $sqlRows['id'];
                            $title = $sqlRows['title'];
                            $price = $sqlRows['price'];
                            $description = $sqlRows['description'];
                            $image_name = $sqlRows['image_name'];

                            ?>

                            <div class="food-menu-box">
                                <div class="food-menu-img">

                                    <?php

                                        // check whether image is available or not
                                        if($image_name == "") {
                                            // Image Not Available, then display the message
                                            echo "<h5 class='error'>Image Not Available</h5>";
                                        } else {
                                            // Image Available, then display image
                                            ?>
                                                <img src="<?php echo SITE_URL ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
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

                                    <a href="<?php echo SITE_URL ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary text-bold">Order Now</a>
                                </div>
                            </div>

                            <?php

                        }


                    } else {

                        // Food not available, display the message
                        echo "<h1 class='error'>Food Not Available</h1>";

                    }
                ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- END OF THE FOOD MENU SECTION -->

    <!-- START OF THE FOOTER SECTION -->
        <?php 

            include('front-partials/footer.inc.php');

        ?>
    <!-- END OF THE FOOTER SECTION -->

</body>
</html>
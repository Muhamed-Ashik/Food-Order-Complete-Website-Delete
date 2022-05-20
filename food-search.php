<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Websit - Food Search</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
<!-- START OF THE NAVBAR SECTION -->
    <?php 

        include('front-partials/menu.inc.php');

    ?>
<!-- END OF THE NAVBAR SECTION -->

    <?php
                // get the search keywork from the form
                //$search = $_POST['search'];

                /* The below function will avoid form the sql injection, in case hackers can use the 
                form field send query and how ever make the database or unwanted things, because if pass the data 
                without this function then, the data will passed as sql query and if use the function it will
                consider as string*/
                
                // mysqli_real_escape_string(databaseConnection, passed item from the form);

                $search = mysqli_real_escape_string($databaseConnection, $_POST['search']); 
                
                // echo $search;
     ?>

    <!-- START OF THE FOOD SEARCH SECTION  -->
    <section class="food-search text-center">
        <div class="container">

            <h2>Foods on Your Search <a href="#" class="text-orange text-bold">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- END OF THE FOOD SEARCH SECTION  -->



    <!-- START OF THE FOOD MENU SECTION  -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center text-orange">Food Menu</h2>

            <?php
            
               

                // query to fetch food according to the title and description search desult
                $sqlFetchSearchFood = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR  description LIKE '%$search%'";

                // execute the query
                $sqlFetchSearchFoodExecuted =  mysqli_query($databaseConnection, $sqlFetchSearchFood);

                // get the count of all record that searched
                $sqlRowsCount = mysqli_num_rows($sqlFetchSearchFoodExecuted);

                // check whehter the count is available or not
                if($sqlRowsCount > 0) {

                    // Record Found, then take it using while loop
                    while($sqlRows = mysqli_fetch_assoc($sqlFetchSearchFoodExecuted)) {

                        // store it in the variable
                        $id = $sqlRows['id'];
                        $title = $sqlRows['title'];
                        $price = $sqlRows['price'];
                        $description = $sqlRows['description'];
                        $image_name = $sqlRows['image_name'];

                    ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                
                                    // check whether the image available or not
                                    if($image_name == "") {

                                        // image not found, then display the message
                                        echo "<h5 class='error'>Image Not Available</h5>";

                                    } else {

                                        //  image found, then display the image
                                        ?>
                                            <img src="images/menu-pizza.jpg" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
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

                                <a href="<?php echo SITE_URL ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary text-bold">Order Now</a>
                            </div>
                        </div>

                    <?php

                    } // END OF THE WHILE LOOP

                } else {

                    // Food Not Found
                    echo "<h1 class='error'>Food Not Available</h1>";

                }

            ?>

            

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- END OF THE FOOD MENU SECTION  -->

   <!-- START OF THE FOOTER SECTION -->
        <?php 

            include('front-partials/footer.inc.php');

        ?>
   <!-- END OF THE FOOTER SECTION -->

</body>
</html>
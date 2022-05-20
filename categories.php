<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website - Categories</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <!-- START OF THE NAVBAR SECTION -->
        <?php 
            include('front-partials/menu.inc.php');
        ?>
    <!-- END OF THE NAVBAR SECTION -->

    <!-- START OF THE CATEGORY SECTION-->
    <section class="categories">
        <div class="container">
            <h2 class="text-center text-orange">Explore Foods</h2>

            <?php

                $sqlFetchCategory = "SELECT * FROM tbl_category WHERE active = 'Yes' "; // create a query to fetch categories
                $sqlFetchCategoryExecuted = mysqli_query($databaseConnection, $sqlFetchCategory);// execute the query
                $sqlRowCount = mysqli_num_rows($sqlFetchCategoryExecuted); // get the count of all the data 

                // check whether the count is availalbe or not
                if($sqlRowCount > 0) {

                    // Data Available
                    // echo "Data found";

                    // get all the data using the while loop
                    while($sqlRows = mysqli_fetch_assoc($sqlFetchCategoryExecuted)) {

                        // get the data and store in the variable
                        $id = $sqlRows['id'];
                        $title = $sqlRows['title'];
                        $image_name = $sqlRows['image_name'];

                    ?>

                        <a href="<?php echo SITE_URL ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">

                                <?php 
                                
                                    if($image_name == "") {

                                        // No Image Found, then print the message
                                        echo "<h5 class='error'>Image Not Available</h5>";

                                    } else {

                                        // Image Found ,then display the image
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

                    // Category not available
                    echo "<h1 class='error'>Category Not Available</h1>";

                }


             ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- END OF THE CATEGORY SECTION-->

    <!-- START OF THE FOOTER SECTION -->
        <?php 

            include('front-partials/footer.inc.php');

        ?>
    <!-- END OF THE FOOTER SECTION -->

</body>
</html>
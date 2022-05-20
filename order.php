<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website - Order</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
   
    <!--   START OF THE NAVBAR SECTION  -->
        <?php 

            include('front-partials/menu.inc.php');

        ?>
    <!-- END OF THE NAVBAR SECTION -->

    <?php
    
        // check whether the id set or not
        if($_GET['food_id']) {

            // id set, then Access Granted and get the id
            $food_id = $_GET['food_id'];

            // query to fetch the food from the food table based on ID
            $sqlFetchFood = "SELECT * FROM tbl_food WHERE id = $food_id";

            // execute the query
            $sqlFetchFoodExecuted = mysqli_query($databaseConnection, $sqlFetchFood);

            // count the rows of fetch record
            $sqlRowsCount = mysqli_num_rows($sqlFetchFoodExecuted);

            // check the count is available or not
            if($sqlRowsCount == 1) {

                // Food Available
                //  get the data form the database
                $sqlRows=  mysqli_fetch_assoc($sqlFetchFoodExecuted);
                $title = $sqlRows['title'];
                $price = $sqlRows['price'];
                $image_name = $sqlRows['image_name'];

            } else {

                // Food not available then redirect to home page
                header('location: ' . SITE_URL);

            }
            
            
        } else {

            // id not set, then Access denied then redirect
            header('location: ' . SITE_URL);
        }
    
    
    ?>

    <!-- START OF THE FOOD SEARCH SECTION -->
    <section class="food-search-order text-bold">
        <div class="container">
            
            <h2 class="text-center text-range">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset class="border-black">
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">

                        <?php 
                        
                        // check image is available or not
                        if($image_name == "") {

                            // image not available, then print the message
                            echo "<h5 class='error'>Image Not Available</h5>";

                        } else {

                            // image available
                            ?>
                                <img src="<?php echo SITE_URL ?>images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">
                            <?php

                        }
                        
                        ?>

                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="title" value="<?php echo $title; ?>"/>

                        <p class="food-price">Rs. <?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>"/>

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset class="border-black">
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Mohamed Ashik" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 07xxxxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@xxxxxx.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary btn-medium-size text-bold">
                </fieldset>

            </form>

            <!-- END OF THE FOOD SEARCH SECTION -->

            <?php 
            
                // check the whether the submit button clicked or not
                if(isset($_POST['submit'])) {

                    // Get the form details and store
                    $food_title = $_POST['title'];
                    $price = $_POST['price'];
                    $quantity = $_POST['qty'];
                    
                    $total = $price * $quantity; // 10 * 2 = 20

                    $order_date = date('Y-m-d h:i:sa'); // Order date

                    $status = "Ordered"; // Ordered, Delivered, On Delivery, Cancelled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    // query to insert the data in table order
                    $sqlInsertOrder = "INSERT INTO tbl_order SET

                        food = '$food_title',
                        price = $price,
                        quantity = $quantity,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'

                    ";

                     // echo $sqlInsertOrder; // printed to find the bug
                     // die();

                    // execute the query
                    $sqlInsertOrderExecuted = mysqli_query($databaseConnection, $sqlInsertOrder);

                    // check whether the query executed and data inserted
                    if($sqlInsertOrderExecuted == TRUE) {

                        // data inseted, then display the successs
                        $_SESSION['upload'] = "<h3 class='success' style='padding-top: 3%;'>Order Placed Successfullly</h3>";
                        header('location: ' . SITE_URL);

                    } else {

                        // data not inserted, then display the error
                        $_SESSION['upload'] = "<h3 class='error' style='padding-top: 3%;'>Failed to Place Order</h3>";
                        header('location: ' . SITE_URL);

                    }


                }// END OF THE SUBMIT BUTTON IF
            
            
            ?>

        </div>
    </section>
    <!-- END OF THE FOOD SEARCH SECTION -->

    <!-- START OF THE FOOTER SECTION -->
        <?php 

            include('front-partials/footer.inc.php');

        ?>
    <!-- END OF THE FOOTER SECION -->
    
</body>
</html>
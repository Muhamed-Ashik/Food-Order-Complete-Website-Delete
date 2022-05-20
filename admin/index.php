<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Dashboard</title>

    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

<!-- Including the Menu File -->
<?php  include('partials/menu.inc.php'); ?>

    <!-- Start of the Main Content -->
    <div class="main-content">
        <div class="wrapper">
            <h1 class="main-heading">Dashboard</h1>

            <?php 

                // if the login succesfull  then print the this login succesfull message
                if(isset($_SESSION['login-password-check'])) {
                                        
                    echo $_SESSION['login-password-check'] ;
                    unset($_SESSION['login-password-check']);
                    
                }
                
                    // display the loged user username 
                    echo $_SESSION['logedUser']; 
                    
                ?>
            
            <div class="dashboard-box col-4 text-align">

            <?php 
            
                // create query to fetch the category
                $sqlFetchCategory = "SELECT * FROM tbl_category";

                // execute the query
                $sqlFetchCategoryExecuted = mysqli_query($databaseConnection, $sqlFetchCategory);

                // check the count of all catgories
                $sqlCategoryCount = mysqli_num_rows($sqlFetchCategoryExecuted);
            
            ?>

                <h1><?php echo $sqlCategoryCount; ?></h1>
                <br>
                Categories
            </div><!--END OF THE Dashboard Box Div-->

            <div class="dashboard-box col-4 text-align">

                <?php 
                
                    // create query to fetch food
                    $sqlFetchFood = "SELECT * FROM tbl_food";

                    // execute the query
                    $sqlFetchFoodExecuted = mysqli_query($databaseConnection, $sqlFetchFood);

                    // check the count of all food
                    $sqlFoodCount = mysqli_num_rows($sqlFetchFoodExecuted);
                
                ?>

                <h1><?php echo $sqlFoodCount; ?></h1>
                <br>
                Foods
            </div>

            <div class="dashboard-box col-4 text-align">

            <?php 
            
                // create query to fetch total order
                $sqlFetchOrders = "SELECT * FROM tbl_order";

                // execute the query
                $sqlFetchOrdersExecuted = mysqli_query($databaseConnection, $sqlFetchOrders);

                // check the count of all orders
                $sqlOrdersCount = mysqli_num_rows($sqlFetchOrdersExecuted);
            
            ?>

                <h1><?php echo $sqlOrdersCount; ?></h1>
                <br>
                Total Orders
            </div>

            <div class="dashboard-box col-4 text-align">

            <?php 
            
                // query to find total amount genereatted which are only delivered
                $sqlFetchTotalRevenue = "SELECT SUM(total) AS Total FROM tbl_order WHERE status = 'Delivered'";

                // execute the query
                $sqlFetchTotalRevenueExecuted = mysqli_query($databaseConnection, $sqlFetchTotalRevenue);

                // get the revenue amount
                $orderRevenue = mysqli_fetch_assoc($sqlFetchTotalRevenueExecuted);

                // get the total varibale in the qeury and store it
                $totalRevenue = $orderRevenue['Total']
            
            ?>

                <h1>Rs. <?php echo $totalRevenue; ?></h1>
                <br>
                Revenue Generated
            </div>

            <div class="clear-fix"></div>

        </div>
    </div>

    <!-- End of the Main Content -->

  <!-- Include Footer File -->
  <?php include('partials/footer.inc.php'); ?>


</body>
</html>
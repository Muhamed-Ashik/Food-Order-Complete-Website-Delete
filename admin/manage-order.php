<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Manage Order</title>

    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

<?php 
    include('partials/menu.inc.php');
?>

    <div class="main-content">
        <div class="wrapper">
            <h1 class="main-heading">Manage Order</h1>        

            <?php
            
                if(isset($_SESSION['access'])) {
                    echo $_SESSION['access'];
                    unset($_SESSION['access']);
                }


                if(isset($_SESSION['update'])) {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            
            ?>

            <table class="admin-view-table">
                <tr>
                    <th>S.N</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>

            <?php 
            
                // query to fetch the order from order table
                $sqlFetchOrder = "SELECT * FROM tbl_order ORDER BY id DESC";

                // execute the query
                $sqlFetchOrderExecuted = mysqli_query($databaseConnection, $sqlFetchOrder);

                // count the rows of check whether order available or not
                $sqlRowsCount = mysqli_num_rows($sqlFetchOrderExecuted);

                // serial number
                $serial_number  = 0;

                // check order available or not
                if($sqlRowsCount > 0) {

                    // orders available, then get the orders
                    while($sqlRows = mysqli_fetch_assoc($sqlFetchOrderExecuted)) {
                        
                        // get and store it in variables
                        $id = $sqlRows['id'];
                        $title = $sqlRows['food'];
                        $price = $sqlRows['price'];
                        $quantity = $sqlRows['quantity'];
                        $total = $sqlRows['total'];
                        $order_date = $sqlRows['order_date'];
                        $status = $sqlRows['status'];
                        $customer_name = $sqlRows['customer_name'];
                        $customer_contact = $sqlRows['customer_contact'];
                        $customer_email = $sqlRows['customer_email'];
                        $customer_address = $sqlRows['customer_address'];
                        $serial_number++;

                        ?>

                             <tr>
                                <td><?php echo $serial_number; ?></td>
                                <td><?php echo $title; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $order_date; ?></td>


                                <td>

                                <?php 
                                
                             // change the color of status based on the delivery type
                                    if($status == "Ordered") {
                                        echo "<div><b>$status</b></div>";
                                    } elseif ($status == "Delivered") {
                                        echo "<div style='color: green;'><b>$status</b></div>";
                                    } elseif ($status == "On Delivery") {
                                        echo "<div style='color: orange;'><b>$status</b></div>";
                                    } elseif ($status == "Cancelled") {
                                        echo "<div style='color: red;'><b>$status</b></div>";
                                    }

                                
                                ?>

                                    <!-- <?php echo $status; ?> -->
                                </td>

                                
                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $customer_contact; ?></td>
                                <td><?php echo $customer_email; ?></td>
                                <td><?php echo $customer_address; ?></td>
                                <td>
                                    <a href="<?php echo SITE_URL ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-update btn-medium-size">Update</a> <br>
                                    <!-- <a href="#" class="btn-delete">Delete Order</a> -->
                                </td>
                            </tr>

                        <?php

                    } // END OF THE WHILE LOOP
                } else {
                    // order not avaialble, the display the message
                    echo "<h3 class='error'>No Orders Available</h3>";
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
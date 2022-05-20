<?php ob_start(); ?>
<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Update Order</title>

    <link rel="stylesheet" href="../css/admin.css"/>

</head>
<body>

    <!-- START OF THE MENU -->
    
        <?php 
            include('partials/menu.inc.php');
        ?>

    <!-- END OF THE MENU -->

    <!-- START OF THE MAIN AREA -->

        <div class="main-content">
            <div class="wrapper">
                <h1 class="main-heading">Update Order</h1>

                <?php 
                
                    // check whether the id is set or not
                    if(isset($_GET['id'])) {
                        // ID found, then access granted

                        // store the id
                        $id = $_GET['id'];

                        // query to fetch the order
                        $sqlFetchOrder = "SELECT * FROM tbl_order WHERE id = $id";

                        // execute the query
                        $sqlFetchOrderExecuted = mysqli_query($databaseConnection, $sqlFetchOrder);

                        $sqlRowCount = mysqli_num_rows($sqlFetchOrderExecuted);

                        // fetch the order details 
                        if($sqlRowCount == 1) {
                            // order available, then fetch it
                            $sqlRow = mysqli_fetch_assoc($sqlFetchOrderExecuted);

                            $food_title = $sqlRow['food'];
                            $customer_name = $sqlRow['customer_name'];
                            $customer_contact = $sqlRow['customer_contact'];
                            $customer_email = $sqlRow['customer_email'];
                            $customer_address = $sqlRow['customer_address'];
                            $price = $sqlRow['price'];
                            $quantity = $sqlRow['quantity'];
                            $status = $sqlRow['status'];
                            
                        }   else {

                            // order not found, then redirect
                            // $_SESSION['access'] = "<h3>Access Denied</h3>";
                            $_SESSION['access'] = "<h3 class='error padding-bottom'>Access Denied</h3>";
                            header('location:' . SITE_URL . 'admin/manage-order.php');
                            
                        }
                        
                    } else {
                        
                        // id not set, access denied, redirect
                        $_SESSION['access'] = "<h3 class='error padding-bottom'>Access Denied</h3>";
                        header('location:' . SITE_URL . 'admin/manage-order.php');

                    }
                
                ?>

                <form action="" method="POST">
                    <table class="table-30">
                        <tr>
                            <td>Food Name: </td>
                            <td> 
                                <b><?php echo $food_title; ?></b>
                            </td>
                        </tr>

                        <tr>
                            <td>Customer Name:</td>
                            <td>
                                <input type="text" name="customer_name" value="<?php echo $customer_name; ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td>Customer Contact:</td>
                            <td>
                                <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td>Customer Email: </td>
                            <td>
                                <input type="text" name="customer_email" value="<?php echo $customer_email; ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td>Customer Address: </td>
                            <td>
                                <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Price: </td>
                            <td>
                                <b>Rs. <?php echo $price; ?></b>
                            </td>
                        </tr>

                        <tr>
                            <td>Quanity :</td>
                            <td>
                                <input type="num" name="quantity" value="<?php echo $quantity; ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td>Status : </td>
                            <td>
                                <select name="status">
                                    <option <?php if($status == "Ordered") { echo "Selected"; } ?> value="Ordered">Ordered</option>
                                    <option <?php if($status == "Delivered") { echo "Selected"; } ?> value="Delivered">Delivered</option>
                                    <option <?php if($status == "On Delivery") { echo "Selected"; } ?> value="On Delivery">On Delivery</option>
                                    <option <?php if($status == "Cancelled") { echo "Selected"; } ?>value="Cancelled">Cancelled</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">

                                <!-- get the id as input -->
                                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>

                                <!-- get the price as input -->
                                    <input type="hidden" name="price" value="<?php echo $price; ?>"/>

                                    <input type="submit" name="submit" value="Update Order" class="btn-update"/>

                            </td>
                        </tr>

                    </table>
                </form>

                <?php 
                
                    // check whether the submit button clicked or not
                    if(isset($_POST['submit'])) {
                        // Button set, then process 
                        
                        // fetch the data from the form and store it
                        $id = $_POST['id'];
                        $customer_name = $_POST['customer_name'];
                        $customer_contact = $_POST['customer_contact'];
                        $customer_email = $_POST['customer_email'];
                        $customer_address = $_POST['customer_address'];

                        $price = $_POST['price']; // no need to add because it be same

                        $quantity = $_POST['quantity'];
                        $status = $_POST['status'];

                        $total = $price * $quantity;

                        // query to update
                        $sqlUpdateOrder = "UPDATE tbl_order SET
                            customer_name = '$customer_name',
                            customer_contact = '$customer_contact',
                            customer_email = '$customer_email',
                            customer_address = '$customer_address',
                            quantity = $quantity,
                            status = '$status',
                            total = '$total'
                            WHERE id = $id;
                        ";

                        // execute the query
                        $sqlUpdateOrderExecuted = mysqli_query($databaseConnection, $sqlUpdateOrder);

                        // check whether the query is executed and data updated or not
                        if($sqlUpdateOrderExecuted == TRUE) {

                            // Data updated, display the session and redirect
                            $_SESSION['update'] = "<h3 class='success padding-bottom'>Order Updated Successfully.</h3>";
                            header('location: ' . SITE_URL . 'admin/manage-order.php');

                        } else {

                            // Data not updated, display the session and redirect
                            $_SESSION['update'] = "<h3 class='error padding-bottom'>Order Update Failed</h3>";
                            header('location: ' . SITE_URL . 'admin/manage-order.php');

                        }
                    }
                
                ?>

            </div>
        </div>

    <!-- END OF THE MAIN AREA -->

    <!-- START OF THE MAIN FOOTER -->

        <?php
            include('partials/footer.inc.php');
         ?>

    <!-- END OF THE MAIN FOOTER -->
    
</body>
</html>

<?php ob_end_flush(); ?>
<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Update Admin</title>

    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

<!-- Start of the Menu -->

    <?php include('partials/menu.inc.php'); ?>

<!-- End of the Menu -->

<!-- Start of the Main Content -->

<div class="main-content">
    <div class="wrapper">
        <h1 class="main-heading">Update Admin</h1>

        <?php 

        // check whether the id is set or not
            if(isset($_GET['id'])) {

                $id = $_GET['id']; // Get the id admin store ti

                // query to fetch the admin
                $sqlAdminFetchQuery = "SELECT * FROM tbl_admin WHERE id = $id";

                // execute the query
                $sqlAdminFetchQueryExecuted = mysqli_query($databaseConnection, $sqlAdminFetchQuery);

                // check whethe the query executed or not
                if($sqlAdminFetchQueryExecuted == TRUE) {
                    
                    // if executed then get the count of fetch admin
                    $sqlCount = mysqli_num_rows($sqlAdminFetchQueryExecuted);

                    // count 1 then, admin fetched
                    if($sqlCount == 1) {

                        // get the detials of the admin to this array and store in the vriable
                        $sqlRow = mysqli_fetch_assoc($sqlAdminFetchQueryExecuted);

                        // echo "Record Available";

                        // strore the details to varibale
                        $full_name  = $sqlRow['full_name'];
                        $username = $sqlRow['username'];

                    } else {
                        // if count 0 then direct
                        header("location:". SITE_URL . 'admin/manage-admin.php');

                    }

                }

            } else {

                // id not fetched then, print session and redirect
                $_SESSION['update-access'] = "<h3 class='error padding-bottom'>Unauthorized Access</h3>";
                header('location: ' . SITE_URL . 'admin/manage-admin.php');

            }
        
           

        ?>

        <form action="" method="POST">
            <table class="table-30"> 

                <input type="hidden" name="id" value="<?php echo $id; ?>"> <!--send the id as hidden -->

                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Admin" class="btn-update">
                    </td>
                </tr>

            </table>
        </form>

    </div> <!--END OF THE WRAPPER DIV-->
</div> <!--END OF THE MAIN-CONTENT -->

<!-- Start of the Footer -->

    <?php include('partials/footer.inc.php'); ?>

<!-- End of the Footer -->

</body>
</html>


<?php 

    // check whehter the submit button is clicked or not
    if(isset($_POST['submit'])) {

        // clicked, then get the details from the form and store it
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        // query to update the admin
        $sqlUpdateAdminQuery = "UPDATE tbl_admin SET 
            full_name = '$full_name',
            username = '$username'
            WHERE id = $id;
        ";

        // execute the query
        $sqlUpdateAdminQueryExecuted = mysqli_query($databaseConnection, $sqlUpdateAdminQuery);

        // check whether the query is executed or not
        if($sqlUpdateAdminQueryExecuted == TRUE) {

            // executed then print the session and redirect
            $_SESSION['update'] = "<h3 class='success padding-bottom'>Admin Updated Successfully</h3>";
            header('location:' . SITE_URL . 'admin/manage-admin.php');

        } else {
            // not executed then, print the session and redreict
            $_SESSION['update'] = "<h3 class='error padding-bottom'>Failed to Update Admin. Try Again!</h3>";
            header("location:" . SITE_URL . 'admin/manage-admin.php');

        }

        
    }

?>
<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Update Password</title>

    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

<?php include('partials/menu.inc.php'); ?>

<!-- Start of the Main Content -->

    <div class="main-content">
        <div class="wrapper">
            <h1 class="main-heading">Change Password</h1>

            <?php

             if(isset($_SESSION['fill'])) {
                     
                    echo $_SESSION['fill'];
                    unset($_SESSION['fill']);

                }

            ?>

            <form action="" method="POST">
                <table class="table-30">

                    <tr>
                        <td>Current Password</td>
                        <td>
                            <input type="password" name="current-password" placeholder="Enter the Current Password"/>
                        </td>
                    </tr>

                    <tr>
                        <td>New Password: </td>
                        <td>
                            <input type="password" name="new-password" placeholder="Enter the New Password" />
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password: </td>
                        <td>
                            <input type="password" name="confirm-password" placeholder="Re-type Confirm Password" />
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Change Password" class="btn-update"/>
                        </td>
                    </tr>

                </table>
            </form> 

        </div>
    </div>

<!-- End of the Main Content -->

<?php include('partials/footer.inc.php'); ?>
    
</body>
</html>


<?php 

if(isset($_GET['id'])) {

    if(isset($_POST['submit'])) {

        $id = $_GET['id']; 
        // echo $id;
        // die();

        $current_password = mysqli_real_escape_string(md5($_POST['current-password']));
        $new_password = mysqli_real_escape_string(md5($_POST['new-password']));
        $confirm_password = mysqli_real_escape_string(md5($_POST['confirm-password']));

        // echo $current_password;
        // echo $new_password;
        // echo $confirm_password;

        // die();

        // query to fetch admin
        $sqlFetchPassword = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";

        // execute the query
        $sqlFetchPasswordExecuted = mysqli_query($databaseConnection, $sqlFetchPassword);

            // check whether this query executed or not
            if($sqlFetchPasswordExecuted == TRUE) {
                // executed
                
                // check the count of executed query to find whether the data is fetched or not
                $sqlRow = mysqli_num_rows($sqlFetchPasswordExecuted);

                // check whether the count is there or not
                if($sqlRow == 1) {
                    // data found
                    // echo "data found";

                    if($new_password == $confirm_password) {
                        
                        // echo "User Found";

                        $sqlUpdatePassword = "UPDATE tbl_admin SET
                            password = '$new_password'
                            WHERE id = $id;
                        ";

                        // execute the query
                        $sqlUpdatePasswordExecuted = mysqli_query($databaseConnection, $sqlUpdatePassword);

                        // check whether executed or not
                        if($sqlUpdatePasswordExecuted == TRUE) {

                            // data updated then display the message
                            $_SESSION['password-changed'] = "<h3 class='success padding-bottom'>Password Changed Successfully</h3>";
                            header('location:' . SITE_URL . 'admin/manage-admin.php');

                        } else {

                            // data not updated, then display the message
                             $_SESSION['password-changed'] = "<h3 class='error padding-bottom'>Password Not Changed. Try Again!</h3>";
                            header('location:' . SITE_URL . 'admin/manage-admin.php');

                        }

                    } else {

                        $_SESSION['password-check'] = "<h3 class='error padding-bottom'>Password Not Match</h3>";
                        header('location: ' . SITE_URL . 'admin/manage-admin.php');
                    }

                } else {

                    $_SESSION['user-not-found'] = "<h3 class='error padding-bottom'>User Not Found</h3>";
                    header('location: ' . SITE_URL . 'admin/manage-admin.php');

                }

                
            } // END OF THE CHECK EXECUTED IF   
        
    } // END OF THE ISSET SUBMIT BUTTON 


} else {
    $_SESSION['no-access'] = "<h3 class='error padding-bottom'>Can not acess</h3>";
    header('location: '. SITE_URL . 'admin/manage-admin.php');
}

 
?>
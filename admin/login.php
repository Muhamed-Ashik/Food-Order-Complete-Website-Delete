<?php include('../config/constants.php'); ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Login Page</title>

    <link rel="stylesheet" href="../css/admin.css"/> 

</head>
<body>

<!-- START OF THE LOGIN DIV -->

    <div class="login">

        <h1 class="login-heading text-align">Login</h1>

        <?php 
        
            // display when try to login if fields are empty 
            if(isset($_SESSION['field-empty'])) {

                echo $_SESSION['field-empty']; 
                unset($_SESSION['field-empty']);

            }
            
            // display if the password and username was not correct
            if(isset($_SESSION['login-password-check'])) {
                
                echo $_SESSION['login-password-check']; 
                unset($_SESSION['login-password-check']);

            }

            // display the when username and password correct
            if(isset($_SESSION['logedUser'])) {
             
                 echo $_SESSION['logedUser']; 
                 unset($_SESSION['logedUser']);
                    
            }


        ?>
        
        <form action="" method="POST" class="text-align">

            <label for="">Username: </label>
            <input type="text" name="username" placeholder="Enter the Username Here"/> <br> <br> <br>

            <label for="">Password: </label>
            <input type="password" name="password" placeholder="Enter the Password Here"/> <br> <br> <br>

            <input type="submit" name="submit" value="Login" class="btn-add btn-medium-size"/>

        </form>
        
    </div> <!-- END OF THE LOGIN DIV -->
    
    <?php include('partials/footer.inc.php'); ?> <!-- include the footer file -->

</body>
</html>

<?php 

    // check whether the button is clicked or not

    if(isset($_POST['submit'])) {

        // check whether the username and password empty and if empty, print the message and redirect
        if(empty($_POST['username']) && empty($_POST['password'])) {

           $_SESSION['field-empty'] = "<h3 class='error text-align padding-bottom'>All Fields Must be Fill</h3>";
           header('location:' . SITE_URL . 'admin/login.php');

        } else { 
            
            // if username and password not empty, then get and store it in the variable

            // $username = $_POST['username'];
            // $password = md5($_POST['password']);

            $username = mysqli_real_escape_string($databaseConnection, $_POST['username']);
            $password = mysqli_real_escape_string($databaseConnection, md5($_POST['password']));

            // query to fetch the login from the talbe admin
            $sqlFetchAdminQuery = "SELECT * FROM tbl_admin WHERE username = '$username' && password = '$password'";

            // execute the query
            $sqlFetchAdminQueryExecuted = mysqli_query($databaseConnection, $sqlFetchAdminQuery);

            // check executed or not
            if($sqlFetchAdminQueryExecuted == TRUE) {

                // count the row, to check whehther the data found or not
                $sqlFetchCount = mysqli_num_rows($sqlFetchAdminQueryExecuted);

                // if count is 1, then found
                if($sqlFetchCount == 1) {

                    // Loging done, then prin the message and direct to the dashboard
                    $_SESSION['login-password-check'] = "<h3 class='success padding-bottom'>Login Successfull</h3>";
                    header('location:' . SITE_URL . 'admin/');

                    $_SESSION['logedUser'] = "<h3 class='success'>$username</h3>"; // once the record found take tha username

                } else {

                    // Failed to login, print the message to and redirec to login back
                    $_SESSION['login-password-check'] = "<h3 class='error text-align padding-bottom'>Username or Password Wrong. Try Again!</h3>";
                    header('location:' . SITE_URL . 'admin/login.php');
                    
                }

            }

        }

    } // end of the post submit button
    
?>
<!-- Database Including -->
<?php include('../config/constants.php'); ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Add Admin</title>

    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

<?php include('partials/menu.inc.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="main-heading">Add Admin</h1>

        <?php 

            // display when new admin added or not
            if(isset($_SESSION['add'])  ) {
                
                echo $_SESSION['add'];
                unset($_SESSION['add']);

            }

            // display when the fields are not filled
            if(isset($_SESSION['recordFill'])) {
              
                echo $_SESSION['recordFill'];
                unset($_SESSION['recordFill']);

            }

        ?>
        
        <!-- <br> <br> -->
        
        <form action="" method="POST">
            <table class="table-30">

                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter your username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter your password">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" name="submit" value="Add Admin" class="btn-admin-add">
                    </td>
                </tr>

            </table>
        </form>

    </div><!--End of the Wrapper Div-->
</div><!--End of the Main-Content Div-->


<?php include('partials/footer.inc.php'); ?>
    
</body>
</html>

<?php 

    if(isset($_POST['submit'])) {

        if(!empty($_POST['full_name']) && !empty($_POST['username'] && !empty($_POST['password']))) {

            // 1. Collect the data from the input and store
            $full_name = $_POST['full_name'];
            $username = $_POST['username'];
            $password = md5($_POST['password']); // Password encrypted with md5()

            // 2. Make a SQL query and inser it
            $sqlInsertQuery = "INSERT INTO tbl_admin SET 
                full_name = '$full_name',
                username = '$username',
                password = '$password'
            ";

            // 3. Execute the query 
            $databaseExecution = mysqli_query($databaseConnection, $sqlInsertQuery) or die(mysqli_error());

            // 4. Check whether the executed data is stored or not
                if($databaseExecution==TRUE) {

                    $_SESSION['add'] = "<h3 class='success padding-bottom'>New Admin Added Successfully</h3>";
                    header("location: " . SITE_URL . 'admin/manage-admin.php');
                    

                } else {

                    $_SESSION['add'] = "<h3 class='error padding-bottom'>Adding New Admin Failed</h3>";
                    header("location:" . SITE_URL . 'admin/add-admin.php');

                }

        } else {

            $_SESSION['recordFill'] = "<h3 class='error padding-bottom'>All Fields Must Be Fill</h3>";
            header("location:".SITE_URL.'admin/add-admin.php');
                
        } // end of the empty check if

    } 

?>
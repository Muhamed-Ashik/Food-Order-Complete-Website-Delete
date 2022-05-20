<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foor Order - Manage Admin</title>

    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>
    

<!-- Include the Menu File -->
<?php include('partials/menu.inc.php'); ?>

    <!-- START OF THE MAIN CONTENT  -->

    <div class="main-content">
        <div class="wrapper">
            <h1 class="main-heading">Manage Admin</h1>

            <?php 

                // display when admin added successfully
                if(isset($_SESSION['add'])){
                    
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);

                }

                // display when admin deleted succssfully
                if(isset($_SESSION['delete'])) {
                   
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);

                }

                // display when admin updated 
                if(isset($_SESSION['update'])) {
    
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);

                }
                
                // display when update record id not found
                if(isset($_SESSION['update-access'])) {

                    echo $_SESSION['update-access'];
                    unset($_SESSION['update-access']);
                    
                }
         
            // display when password not match
                if(isset($_SESSION['password-check'])) {
                    
                    echo $_SESSION['password-check'];
                    unset($_SESSION['password-check']);

                 }  
                 
                // display when the password changed
                 if(isset($_SESSION['password-changed'])) {
                         
                    echo $_SESSION['password-changed']; 
                    unset($_SESSION['password-changed']);

                 }

                //  display, when the user not found
                  if(isset($_SESSION['user-not-found'])) {
                         
                    echo $_SESSION['user-not-found']; 
                    unset($_SESSION['user-not-found']);

                 }

                //  display, access the page without id
                 if(isset($_SESSION['no-access'])) {
                         
                    echo $_SESSION['no-access']; 
                    unset($_SESSION['no-access']);

                 }

                

            
            
            ?>

            <!-- <br> <br> -->

            <!-- Button for Add Admin -->
            <a href="add-admin.php" class="btn-add">Add Admin</a>

            <table class="admin-view-table" border="1">

                <tr>
                    <th>S.N</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <?php 

                    $sqlAdminFetchQuery = "SELECT * FROM tbl_admin";

                    $sqlAdminFetchQueryExecuted = mysqli_query($databaseConnection, $sqlAdminFetchQuery);

                    if($sqlAdminFetchQueryExecuted == TRUE) {
                        
                        $count = mysqli_num_rows($sqlAdminFetchQueryExecuted);

                        if($count > 0) {
                            
                            $serial_number_count = 1;

                            while($fetchRows = mysqli_fetch_assoc($sqlAdminFetchQueryExecuted)) {

                                $id = $fetchRows['id'];
                                $full_name = $fetchRows['full_name'];
                                $username = $fetchRows['username'];

                                ?>

                                <tr>
                                        <td><?php echo $serial_number_count++; ?></td>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                    <td>
                                        <a href="<?php echo SITE_URL ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-update">Change Password</a>
                                        <a href="<?php echo SITE_URL ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-update">Update Admin</a>
                                        <a href="<?php echo SITE_URL ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-delete">Delete Admin</a>
                                    </td>
                                </tr>

                                <?php

                            }

                        } 

                    } 

                ?>
                 
            </table>

        </div><!--END OF THE WRAPPER DIV-->
    </div><!-- END OF THE MAIN CONTENT DIV -->



<!-- Include the Foote File -->
<?php 
    include('partials/footer.inc.php');
?>

</body>
</html>




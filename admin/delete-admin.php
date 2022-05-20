<?php include('../config/constants.php'); ?>

<?php 

    $id = $_GET['id']; // get the id
    
    // query to delete admin
    $sqlDeleteAdminQuery = "DELETE FROM tbl_admin WHERE id = $id";

    // execute the query
    $sqlDeleteAdminQueryExecuted = mysqli_query($databaseConnection, $sqlDeleteAdminQuery);
    
    // check query executed or not
    if($sqlDeleteAdminQueryExecuted == TRUE) {
        
        // echo "Admin Deleted Successfully";
        $_SESSION['delete'] = "<h3 class='success padding-bottom'>Admin Deleted Successfully</h3>";
        header("location:" . SITE_URL . 'admin/manage-admin.php');

    } else {
        
        // echo "Failed to Delete Admin. Try Again!";
        $_SESSION['delete'] = "<h3 class='error padding-bottom'>Failed to Delete Admin. Try Again!</h3>";
        header("location:" . SITE_URL . 'admin/manage-admin.php');

    }

?>
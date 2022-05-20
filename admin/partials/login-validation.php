<?php 

    if(!isset($_SESSION['logedUser'])) {

        $_SESSION['logedUser'] = "<div class='error'>Please Login to Access the Admin Panel</div>";
        header('location:' . SITE_URL . 'admin/login.php');

    }

?>
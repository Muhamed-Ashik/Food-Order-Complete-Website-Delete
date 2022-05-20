<?php include('../config/constants.php'); ?>

<?php

    session_destroy(); // destroy the session and $_SESSION['user] also will destroy

    header('location:' . SITE_URL . 'admin/login.php'); // redirect

?>
<?php
// check_login.php

session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    // User is not logged in
    header('Location: ../loginSignup/signup.php');
    exit;
}

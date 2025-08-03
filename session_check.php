<?php
ini_set('session.gc_maxlifetime', 3600); 
session_set_cookie_params(3600); 
session_start();

if (empty($_SESSION['loggedin']) || $_SESSION['role'] !== 'profile') {
    header("Location: admin_dashboard.php");
    exit;
}

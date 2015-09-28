<?php
session_start();
if (isset($_SESSION['login_user'])) {
    header("Location: php/Dashboard.php");
} else {
    header("Location: login.php");
}

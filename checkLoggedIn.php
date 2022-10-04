<?php
if (!isset($_SESSION['isLoggedIn']) ||  $_SESSION['isLoggedIn'] != true) {
    header('Location: login.php');
}

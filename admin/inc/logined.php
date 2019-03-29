<?php
session_start();
function baixiu_get_current_user() {
  if(empty($_SESSION['current_login_user']) || empty($_COOKIE['PHPSESSID'])) {
    header("location: ./login.php");
    exit(0);
  };
  return $_SESSION['current_login_user'];
}
?>
<?php 
include "db.php";
session_start(); 

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_query = mysqli_query($connection, $query);
    if(!$select_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }

    $select_user = mysqli_fetch_assoc($select_user_query);
    if($select_user === null) {
        $_SESSION['login_error'] = true;
        header("Location: ../index.php");
        exit();
    }

    $db_user_id = $select_user['user_id'];
    $db_username = $select_user['username'];
    $db_user_password = $select_user['user_password'];
    $db_user_firstname = $select_user['user_firstname'];
    $db_user_lastname = $select_user['user_lastname'];
    $db_user_role = $select_user['user_role'];

    if($username != $db_username || !password_verify($password, $db_user_password)) {
        header("Location: ../index.php");
        exit();
    }

    $_SESSION['username'] = $db_username;
    $_SESSION['firstname'] = $db_user_firstname;
    $_SESSION['lastname'] = $db_user_lastname;
    $_SESSION['user_role'] = $db_user_role;
    
    header("Location: ../admin/index.php");
    exit();
}

<?php

const db_host = 'localhost';
const db_user = 'root';
const db_pass = '';
const db_name = 'cms';


$connection = mysqli_connect(db_host, db_user, db_pass, db_name);
if(!isset($connection)) {
    die("Database Connection failed");
}
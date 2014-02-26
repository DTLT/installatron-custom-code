<?php

//==================================
//! Global Configuration for Installatron Custom Code
//==================================

$wp_databasename = "XXXXXX";
$wp_databaseuser = "XXXXXX";
$wp_databasepassword = "XXXXXX";
$wp_databasehost = "localhost";
$wp_db = 'mysql:host=' . $wp_databasehost . ';dbname=' . $wp_databasename;
$thedb = new PDO($wp_db, $wp_databaseuser, $wp_databasepassword);
$wp_apiurl = "XXXXXX";
$googlespreadsheeturl = "XXXXXX";

?>
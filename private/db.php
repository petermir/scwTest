<?php

use App\ProductType\Product;

require_once('vendor/autoload.php');
include_once('functions.php');

// Connect to database
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "scandiweb");
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Set the database for the classes
Product::set_database($database);
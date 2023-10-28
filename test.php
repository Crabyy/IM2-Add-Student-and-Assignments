<?php

require_once('config/dbconfig.php');

$database = new Database();

if ($database->dbState()) {
    echo "Connected to the database!";
} else {
    echo "Failed to connect to the database.";
}
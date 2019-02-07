<?php

if (isset($_GET['edit'])) {
$id = $_GET['id'];

$mysqli->query("SELECT * FROM products WHERE products_id=$id");
}
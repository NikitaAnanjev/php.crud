<?php

// include database connection
include 'database.php';

// delete message prompt will be here
$action = isset($_GET['action']) ? $_GET['action'] : "";

// if it was redirected from delete.php
if ($action == 'deleted') {
    echo "<div class='alert alert-success text-center'>Record was deleted.</div>";
}

$language_id_shift = $_POST['select_language'];
if ($language_id_shift == null ) {
    $language_id_shift = '1';
}
// select all data from two tables

$query2 = "SELECT * FROM languages";
$stmt2 = $con->prepare($query2);
$stmt2->execute();

if(isset($_POST['submit']) && $_POST['language'] != 0){
    $language_id_shift = $_POST['language'];  // Storing Selected Value In Variable
}

$select ='<form    method="POST" >';
$select .= '<select name="select_language"  id="select_language">';
$select .= '<option value="" selected="selected">Select Language</option>';

while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)):
    extract($row2);
    $select .= '<option value="' . $languages_id . '">' . $languages_name . '</option>';
endwhile;

$select .= '</select>';
$select .= '<input type="submit" name="submit" value="Choose Language" />';
$select .= '</form>';

if(isset($_POST['submit']) && $_POST['select_language'] != 0){
    unset($language_id_shift);
    $language_id_shift = $_POST['select_language'];  // Storing Selected Value In Variable
}

$query = "SELECT * FROM products INNER JOIN products_description ON products.products_id = products_description.products_id WHERE languages_id = '$language_id_shift' ORDER BY products.products_id ASC";
$stmt = $con->prepare($query);
$stmt->execute();
// this is how to get number of rows returned
$num = $stmt->rowCount();?>


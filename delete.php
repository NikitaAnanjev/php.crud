<?php


// Delete BTN
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM products WHERE products_id=$id")
    or die($mysqli->error());


    $_SESSION['message']= "Record has been deleted";
    $_SESSION['msg_type']= "danger";
    header("location.index.php");
}
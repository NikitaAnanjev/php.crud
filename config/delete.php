<?php
// include database connection
include 'database.php';

try {
    // get record ID
    // Check value is there or not
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    $query = "DELETE products_description, products
              FROM products_description
              INNER JOIN
              products ON products.products_id = products_description.products_id
              WHERE products_description.products_id = ?";

    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);

    if($stmt->execute()){
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: ../index.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }
}
// Display error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

<?php

include 'config/database.php';


$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');


try {
    $query ="UPDATE products_description
            JOIN products
            ON products_description.products_id = products.products_id
            SET products_description_name = :name,
                    products_description_short_description = :short_descr,
                    products_description_description = :long_descr,
                    products_reference=:refer,
                    products_price=:price
                    WHERE products_description_id = :id";

    $stmt = $con->prepare($query);


    $name = htmlspecialchars(strip_tags($_POST['name']));
    $description = htmlspecialchars(strip_tags($_POST['short_descr']));
    $descriptionLong = htmlspecialchars(strip_tags($_POST['long_descr']));
    $price = htmlspecialchars(strip_tags($_POST['price']));
    $reference = htmlspecialchars(strip_tags($_POST['refer']));


//

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':short_descr', $description);
    $stmt->bindParam(':long_descr', $descriptionLong);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':refer', $reference);
//    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {

        echo "<div class='alert alert-success'>Record was updated.</div>";
        header('Location: update.php?action=updated');
    } else {
        echo "<div class='alert alert-danger'>Unable to update record. Please  dsadastry again.</div>";
    }
} // show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>

<!--<script type='text/javascript'>-->
<!--    // confirm record deletion-->
<!--    function update_product( id ){-->
<!--        var answer = confirm('Are you sure?');-->
<!--        if (answer){-->
<!--            // if user clicked ok,-->
<!--            // pass the id to delete.php and execute the delete query-->
<!--            window.location = 'edit.php?id=' + id;-->
<!--        }-->
<!--    }-->
<!--</script>-->
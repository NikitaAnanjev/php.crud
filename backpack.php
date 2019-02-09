<?php require 'header.php';
?>

<?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
//include database connection

include 'config/database.php';

try {
    $query = "SELECT * FROM products_description 
                  LEFT JOIN products 
                  ON  products.products_id =  products_description.products_id 
                  JOIN languages 
                  ON products_description.languages_id = languages.languages_id
                  WHERE products_description.products_description_id = ? LIMIT 0,1";

    $stmt = $con->prepare($query);

    // this is the first question markV
    $stmt->bindParam(1, $id);

    // execute our query
    $stmt->execute();

    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // values to fill up our form

    $price = $row['products_price'];
    $reference = $row['products_reference'];
    $name = $row['products_description_name'];
    $description = $row['products_description_short_description'];
    $descriptionLong = $row['products_description_description'];
    $language = $row['languages_name'];

} // show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>







<?php require 'footer.php';

?>

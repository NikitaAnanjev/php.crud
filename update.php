<?php require 'header.php'; ?>


<?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
//include database connection

include 'config/database.php';


try {
    $query = "UPDATE products_description
            JOIN products
            ON products_description.products_id = products.products_id
            SET products_description_name = :name,
                    products_description_short_description = :short_descr,
                    products_description_description = :long_descr,
                    products_reference=:refer,
                    products_price=:price
                    WHERE products_description_id = :id";
    $stmt = $con->prepare($query);

    $query2 = "SELECT * FROM products INNER JOIN products_description ON products.products_id = products_description.products_id WHERE products_description_id ='$id'";
    $stmt2 = $con->prepare($query2);
    $stmt2->execute();


    $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($row);

    //bind the parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':short_descr', $description);
    $stmt->bindParam(':long_descr', $descriptionLong);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':refer', $reference);
    $stmt->bindParam(':id', $id);

    // Execute the query
    $name = $products_description_name;
    $description = $products_description_short_description;
    $descriptionLong =$products_description_description;
    $price = $products_price;
    $reference = $products_reference;

    // Update product
    if (isset($_POST['update_btn']) && $stmt2->execute()) {

    $name = htmlspecialchars(strip_tags($_POST['name']));
    $description = htmlspecialchars(strip_tags($_POST['short_descr']));
    $descriptionLong = htmlspecialchars(strip_tags($_POST['long_descr']));
    $price = htmlspecialchars(strip_tags($_POST['price']));
    $reference = htmlspecialchars(strip_tags($_POST['refer']));

    $stmt->execute();

    // echo $stmt;
        if( $stmt->execute() ){
            echo "<div class='alert alert-success'>Record was updated.</div>";
        }
        else {
            echo "<div class='alert alert-danger'>Unable to update record. Please try dsad again.</div>";
        }
    }
} // show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>

<div class="container">
    <!-- container -->

    <div class="page-header text-center">
        <h1>Edit Product</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="POST">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>"
                                   class='form-control'/></td>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <label for="short_descr">Short Description</label>
                            <textarea type="text" name="short_descr" rows="2"
                                      class="form-control"><?php echo htmlspecialchars($description, ENT_QUOTES); ?></textarea></td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <label for="short_descr">Long Description</label>
                            <textarea type="text" name="long_descr" rows="4"
                                      class="form-control"><?php echo htmlspecialchars($descriptionLong, ENT_QUOTES); ?></textarea></td>
                            </textarea>
                        </div>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES); ?>"
                                   class='form-control'/></td>
                    </tr>
                    <tr>
                        <td>Reference</td>
                        <td><input type='text' name='refer'
                                   value="<?php echo htmlspecialchars($descriptionLong, ENT_QUOTES); ?>"
                                   class='form-control'/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save Changes' class='btn btn-primary' name="update_btn"/>
                            <a href='index.php' class='btn btn-danger'>Back to read products</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php require 'footer.php';?>

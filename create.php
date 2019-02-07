<?php require 'header.php'; ?>


<?php


if ($_POST) {

    // include database connection
    include 'config/database.php';

    try {
        // insert query
        $query = "INSERT INTO products (products_reference, products_price) VALUES (:prod_reference,:prod_price)";
        $query2 = "INSERT INTO products_description (
  products_id,
  languages_id,
 products_description_name,
 products_description_short_description,
  products_description_description) VALUES (
  :prod_id,
  :lang_id,
  :prod_name,
  :prod_short_descr,
  :prod_descr_descr)";
        // prepare query for execution
        $stmt = $con->prepare($query);
        $stmt2 = $con->prepare($query2);
        // posted values
        $reference = htmlspecialchars(strip_tags($_POST['refer']));
        $price = htmlspecialchars(strip_tags($_POST['price']));

        // Second posted values
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $s_descr = htmlspecialchars(strip_tags($_POST['short_descr']));
        $l_descr = htmlspecialchars(strip_tags($_POST['long_descr']));

        // bind the parameters
        $stmt->bindParam(':prod_reference', $reference);
        $stmt->bindParam(':prod_price', $price);

        // Second bind the parameters
        $stmt2->bindParam(':prod_id', $last_product_id);
        $stmt2->bindParam(':lang_id', $language_id);
        $stmt2->bindParam(':prod_name', $name);
        $stmt2->bindParam(':prod_short_descr', $s_descr);
        $stmt2->bindParam(':prod_descr_descr', $l_descr);


        // Execute the query
        if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center'>Record was saved.</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Unable to save record.</div>";
        }
//        $last_product_id =  $this->db->lastInsertId('products_id');

//        CONDITIONAL VALUE
        $rows = $stmt->rowCount();

//        ADDED PRODUCT ID
        $last_product_id = $con->lastInsertId('products_id');
        if ($rows > 0) {

//            GET LANGUAGE ID
            $language_id = '1';
//            echo $rows;
//            echo $last_product_id;

            if ($stmt2->execute()) {
                echo "<div class='alert alert-success text-center'>Description was saved.</div>";
            } else {
                echo "<div class='alert alert-danger text-center'>Unable to save Description.</div>";
            }

        }

    } // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">


                <!--FIRST SECTION-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="refer">Product Number </label>
                        <input type="text" name="refer" class="form-control" value="Enter product number">
                    </div>
                    <div class="form-group">
                        <label for="price">Product Price</label>
                        <input type="text" name="price" class="form-control" value="Enter product price">
                    </div>
                    <!--RADIO BTN CHOOSE LANGUAGES-->
            </div>

            <!--DESCRIPTION SECTION-->
            <div class="col-lg-6">

                <div class="form-group">
                    <label for="pr_name">Product Name</label>
                    <input type="text" name="name" class="form-control" value="Enter product name" id="pr_name">
                </div>
                <div class="form-group">
                    <label for="short_descr">Short Description</label>
                    <textarea type="text" name="short_descr" rows="4"
                              class="form-control">Enter product description</textarea>
                </div>
                <div class="form-group">
                    <label for="long_descr">Long Description</label>
                    <textarea type="text" name="long_descr" rows="5"
                              class="form-control">Enter product Long description</textarea>
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="save"> Save</button>
                    <a href='index.php' class='btn btn-danger'>Back to read products</a>
                </div>
                </form>
            </div>
        </div>
    </div>


<?php require 'footer.php';



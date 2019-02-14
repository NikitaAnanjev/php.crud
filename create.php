<?php require 'templates/header.php'; ?>

    <div class="container">
    <div class="page-header text-center title-section">
        <h1>Opret ny produkt</h1>
    </div>
    <?php
    if ($_POST) {

        // include database connection
        include 'config/database.php';

        try {
            // insert query
            $query = "INSERT INTO products (products_reference, products_price) VALUES (:prod_reference,:prod_price)";
            $query2 = "INSERT INTO products_description ( products_id, languages_id,products_description_name,products_description_short_description, products_description_description)
        VALUES (:prod_id, :lang_id_dk, :prod_name, :prod_short_descr, :prod_descr_descr),
        (:prod_id, :lang_id_en,'','',''),
        (:prod_id, :lang_id_no,'','','')";

            // prepare query for execution
            $stmt = $con->prepare($query);
            $stmt2 = $con->prepare($query2);

            // posted values
            $reference = htmlspecialchars(strip_tags($_POST['refer']));
            $price = htmlspecialchars(strip_tags($_POST['price']));
            $name = htmlspecialchars(strip_tags($_POST['name']));
            
            // For textEditor
            $s_descr = $_POST['short_descr'];
            $l_descr = $_POST['long_descr'];

            // bind the parameters
            $stmt->bindParam(':prod_reference', $reference);
            $stmt->bindParam(':prod_price', $price);

            // Second bind the parameters
            $stmt2->bindParam(':prod_id', $last_product_id);
            $stmt2->bindParam(':lang_id_dk', $language_id1);
            $stmt2->bindParam(':lang_id_en', $language_id2);
            $stmt2->bindParam(':lang_id_no', $language_id3);
            $stmt2->bindParam(':prod_name', $name);
            $stmt2->bindParam(':prod_short_descr', $s_descr);
            $stmt2->bindParam(':prod_descr_descr', $l_descr);


//        Execute the query
            $stmt->execute();

//        CONDITIONAL VALUE
            $rows = $stmt->rowCount();

//        ADDED PRODUCT ID
            $last_product_id = $con->lastInsertId('products_id');
            if ($rows > 0) {

//        SPECIFY LANGUAGE ID
                $language_id1 = '1';
                $language_id2 = '2';
                $language_id3 = '3';

                if ($stmt->execute() && $stmt2->execute()) {
                    echo "<div class='alert alert-success text-center'>Tillykke! Produkt blev gemt.</div>";
                } else {
                    echo "<div class='alert alert-danger text-center'>Uff...Kan ikke gemme det produkt.</div>";
                }
            }
        } // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
    }
    ?>

    <div class="container">
        <div class="row data-block">
            <div class="col-lg-3">
                <!--FIRST SECTION-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="refer"><?php echo $lable_prod_reference;  ?></label>
                        <input type="text" name="refer" class="form-control" value="Enter product number">
                    </div>
                    <div class="form-group">
                        <label for="price"><?php echo $lable_prod_price;  ?></label>
                        <input type="text" name="price" class="form-control" value="Enter product price">
                    </div>
                    <!-- BTN CHOOSE LANGUAGES-->
            </div>

            <!--DESCRIPTION SECTION-->
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="pr_name"><?php echo $lable_prod_name; ?></label>
                    <input type="text" name="name" class="form-control" value="Enter product name" id="pr_name">
                </div>
                <div class="form-group">
                    <label for="short_descr"><?php echo $lable_prod_short_description; ?></label>
                    <textarea type="text" name="short_descr" id="short_descr" rows="4"
                              class="form-control">Enter product short Description</textarea>
                </div>
                <div class="form-group">
                    <label for="long_descr"><?php echo $lable_prod_long_description; ?></label>
                    <textarea type="text" name="long_descr" id="long_descr" rows="5"gi
                              class="form-control">Enter product Long description</textarea>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group text-right">
                    <a href='index.php' class='btn btn-danger'> <?php echo $lable_back; ?></a>
                    <button type="submit" class="btn btn-primary" name="save"><?php echo $lable_save; ?></button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/texteditor.js"></script>
<?php require 'templates/footer.php';

<?php require 'templates/header.php'; ?>
<?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

//include database connection
include 'config/database.php';

// READ DATA FROM DATABASE
try {
    $query = "SELECT * FROM products_description INNER JOIN products ON products.products_id = products_description.products_id WHERE products_description.products_id = '$id'";
    $stmt = $con->prepare($query);
    $stmt->execute();

    // this is the first question mark
    $stmt->bindParam(1, $id);

    // Execute SELECT query
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        //DK
        if ($languages_id == 1) {
            $name = $row['products_description_name'];
            $description = $row['products_description_short_description'];
            $descriptionLong = $row['products_description_description'];
            $description_id = $row['products_description_id'];
            $lang_name = 'Danish';
        }

        //NO
        if ($languages_id == 2) {
            $name_eng = $row['products_description_name'];
            $description_eng = $row['products_description_short_description'];
            $descriptionLong_eng = $row['products_description_description'];
            $lang_name_eng =  'English';
        }

        //EN
        if ($languages_id == 3) {
            $name_no = $row['products_description_name'];
            $description_no = $row['products_description_short_description'];
            $descriptionLong_no = $row['products_description_description'];
            $lang_name_no =  'Norwegian';
        }
    }
    $price = $products_price;
    $reference = $products_reference;
} // show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}


//UPDATE DATABASE
if ($_POST) {
    try {
        $query = "UPDATE
    products_description
JOIN products ON products_description.products_id = products.products_id
SET
    products_description_name = :name,
    products_description_short_description =:short_descr,
    products_description_description = :long_descr,
    products.products_reference = :refer,
    products.products_price =:price
WHERE
    products_description.languages_id = '1' AND products_description.products_id = :id;";
        $stmt = $con->prepare($query);

//      UPDATE ENGLISH DATA
        $query_eng = "UPDATE
    products_description
SET
    products_description_name=:name_en,
    products_description_short_description=:short_descr_en,
    products_description_description=:long_descr_en
WHERE
    products_description.languages_id = '2' AND products_id=:id";
        $stmt_en = $con->prepare($query_eng);

//      UPDATE NORWEGIAN
        $query_nor = "UPDATE
    products_description
SET
    products_description_name=:name_no,
    products_description_short_description=:short_descr_no,
    products_description_description=:long_descr_no
WHERE
    products_description.languages_id = '3' AND   products_description.products_id=:id";

        $stmt_no = $con->prepare($query_nor);
        $price = htmlspecialchars(strip_tags($_POST['price']));
        $reference = htmlspecialchars(strip_tags($_POST['refer']));
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $description = $_POST['short_descr'];
        $descriptionLong = $_POST['long_descr'];

        $name_eng = htmlspecialchars(strip_tags($_POST['name_english']));
        $description_eng = $_POST['short_descr_english'];
        $descriptionLong_eng = $_POST['long_descr_english'];

        $name_no = htmlspecialchars(strip_tags($_POST['name_norw']));
        $description_no = $_POST['short_descr_norw'];
        $descriptionLong_no = $_POST['long_descr_norw'];

        //Dansk
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':short_descr', $description);
        $stmt->bindParam(':long_descr', $descriptionLong);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':refer', $reference);
        $stmt->bindParam(':id', $id);

        //english
        $stmt_en->bindParam(':name_en', $name_eng);
        $stmt_en->bindParam(':short_descr_en', $description_eng);
        $stmt_en->bindParam(':long_descr_en', $descriptionLong_eng);
        $stmt_en->bindParam(':id', $id);

        //norge
        $stmt_no->bindParam(':name_no', $name_no);
        $stmt_no->bindParam(':short_descr_no', $description_no);
        $stmt_no->bindParam(':long_descr_no', $descriptionLong_no);
        $stmt_no->bindParam(':id', $id);

        $stmt->execute();
        $stmt_en->execute();
        $stmt_no->execute();

        if ($stmt->execute() && $stmt_en->execute() && $stmt_no->execute()) {

            echo "<div class='alert alert-success text-center'>Tillykke! Optagelsen blev opdateret.</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Uff...Kan ikke opdatere. Prøv igen.</div>";
        }
    } // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
<!--HTML-->
<div class="container">
    <!-- container -->
    <div class="page-header text-center title-section">
        <h1>Rediger produkt</h1>
    </div>
    <div class="row">
        <div class="col-12 data-block">
            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="POST">
                <div class="row">
                    <div class="col-4 main-data-section">
                        <table class="table table-hover table-bordered">
                            <h3>Oplysningen</h3>
                            <tr>
                                <td><?php echo $lable_prod_price; ?></td>
                                <td><input type="text" name="price"
                                           value="<?php echo htmlspecialchars($price, ENT_QUOTES); ?>"
                                           class="form-control"/></td>
                            </tr>
                            <tr>
                                <td><?php echo $lable_prod_reference; ?></td>
                                <td><input type='text' name='refer'
                                           value="<?php echo htmlspecialchars($reference, ENT_QUOTES); ?>"
                                           class='form-control'/></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-4 offset-4 text-right">
                        <a href="index.php" class="btn btn-danger"><?php echo $lable_back; ?></a>
                        <input type='submit' value='Opdater' class='btn btn-primary' name="update_btn"/>
                    </div>

                    <!--Dansk-->
                    <div class="col-4 dansk-data-section">
                            <h3> Dansk</h3>
                            <tr>
                                <label><?php echo $lable_prod_name; ?></label>
                                <div class="form-group">
                                    <input type="text" name="name"
                                           value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>"
                                           class="form-control"/>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <label for="short_descr"><?php echo $lable_prod_short_description; ?></label>
                                    <textarea type="text" name="short_descr" rows="2"
                                              class="form-control"><?php echo htmlspecialchars($description, ENT_QUOTES); ?></textarea></td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <label for="short_descr"><?php echo $lable_prod_long_description; ?></label>
                                    <textarea type="text" name="long_descr" rows="4"
                                              class="form-control"><?php echo htmlspecialchars($descriptionLong, ENT_QUOTES); ?></textarea></td>
                                    </textarea>
                                </div>
                            </tr>
                    </div>

                    <!--English-->
                    <div class="col-4 english-data-section">
                            <h3> <?php echo $lang_name_eng; ?></h3>
                            <tr>
                                <label><?php echo $lable_prod_name; ?></label>
                                <div class="form-group"><input type="text" name="name_english"
                                           value="<?php echo htmlspecialchars($name_eng, ENT_QUOTES); ?>"
                                           class='form-control'/></div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <label for="short_descr"><?php echo $lable_prod_short_description; ?></label>
                                    <textarea type="text" name="short_descr_english" rows="2"
                                              class="form-control"><?php echo htmlspecialchars($description_eng, ENT_QUOTES); ?></textarea></td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <label for="short_descr"><?php echo $lable_prod_long_description; ?></label>
                                    <textarea type="text" name="long_descr_english" rows="4"
                                              class="form-control"><?php echo htmlspecialchars($descriptionLong_eng, ENT_QUOTES); ?></textarea></td>
                                    </textarea>
                                </div>
                            </tr>
                      </div>

                    <!--Norge -->
                    <div class="col-4 norwegian-data-section">
                            <h3> <?php echo $lang_name_no; ?></h3>
                            <tr>
                                <label><?php echo $lable_prod_name; ?></label>
                                <div class="form-group"><input type='text' name='name_norw'
                                           value="<?php echo htmlspecialchars($name_no, ENT_QUOTES); ?>"
                                           class='form-control'/></div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <label for="short_descr"><?php echo $lable_prod_short_description; ?></label>
                                    <textarea type="text" name="short_descr_norw" rows="2"
                                              class="form-control"><?php echo htmlspecialchars($description_no, ENT_QUOTES); ?></textarea></td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <label for="short_descr"><?php echo $lable_prod_long_description; ?></label>
                                    <textarea type="text" name="long_descr_norw" rows="4"
                                              class="form-control"><?php echo htmlspecialchars($descriptionLong_no, ENT_QUOTES); ?></textarea></td>
                                    </textarea>
                                </div>
                            </tr>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/texteditor.js"></script>

    <?php require 'templates/footer.php'; ?>

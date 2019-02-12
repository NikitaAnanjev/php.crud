<?php require 'header.php'; ?>
<?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

//include database connection
include 'config/database.php';


// READ DATA FROM DATABASE
try{



    //    $query2 = "SELECT * FROM products INNER JOIN products_description ON products.products_id = products_description.products_id WHERE products_description.languages_id = 1  AND  products_description.products_id = '$id'";
    $query2 = "SELECT * FROM products_description INNER JOIN products ON products.products_id = products_description.products_id WHERE products_description.products_id = '$id'";
    $stmt2 = $con->prepare($query2);
    $stmt2->execute();



//    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

    // Execute the query

    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        //DK
        if ($languages_id == 1) {
            $name = $row['products_description_name'];
            $description = $row['products_description_short_description'];
            $descriptionLong = $row['products_description_description'];
        }

        //NO
        if ($languages_id == 2) {
            $name_eng = $row['products_description_name'];
            $description_eng = $row['products_description_short_description'];
            $descriptionLong_eng = $row['products_description_description'];
        }

        //EN
        if ($languages_id == 3) {
            $name_no = $row['products_description_name'];
            $description_no = $row['products_description_short_description'];
            $descriptionLong_no = $row['products_description_description'];
        }

    }
    $price = $products_price;
    $reference = $products_reference;




}
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}



try {

//    $query = "UPDATE products_description
//            JOIN products
//            ON products_description.products_id = products.products_id
//            SET products_description_name = :name,
//                    products_description_short_description = :short_descr,
//                    products_description_description = :long_descr,
//                    products_reference=:refer,
//                    products_price=:price
//                    WHERE products_description_id = :id";

//      UPDATE MAIN INFORMATION
    $query = "UPDATE products_description
            JOIN products
            ON products_description.products_id = products.products_id
            SET products_description_name = :name,
                    products_description_short_description = :short_descr,
                    products_description_description = :long_descr,
                    products_reference = :refer,
                    products_price = :price
                    WHERE languages_id = 1 AND products_id = :id";
    $stmt = $con->prepare($query);



//      UPDATE ENGLISH DATA

    $query_eng = "UPDATE products_description
            SET products_description_name = :name_en,
                    products_description_short_description = :short_descr_en,
                    products_description_description = :long_descr_en
                    WHERE products_description.languages_id = 2 AND products_id = :id";
    $stmt_en = $con->prepare($query_eng);



//      UPDATE NORWEGIAN

    $query_nor = "UPDATE products_description
            SET products_description_name = :name_no,
                    products_description_short_description = :short_descr_no,
                    products_description_description = :long_descr_no
            WHERE products_id = :id  AND products_description.languages_id = 3";
    $stmt_no = $con->prepare($query_nor);





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

//norge
    $stmt_no->bindParam(':name_no', $name_no);
    $stmt_no->bindParam(':short_descr_no', $description_no);
    $stmt_no->bindParam(':long_descr_no', $descriptionLong_no);





    // Update product
    if (isset($_POST['update_btn']) && $stmt2->execute()) {
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $description = htmlspecialchars(strip_tags($_POST['short_descr']));
        $descriptionLong = htmlspecialchars(strip_tags($_POST['long_descr']));

        $price = htmlspecialchars(strip_tags($_POST['price']));
        $reference = htmlspecialchars(strip_tags($_POST['refer']));

        $name_eng = htmlspecialchars(strip_tags($_POST['name_english']));
        $description_eng = htmlspecialchars(strip_tags($_POST['short_descr_english']));
        $descriptionLong_eng = htmlspecialchars(strip_tags($_POST['long_descr_english']));

        $name_no = htmlspecialchars(strip_tags($_POST['name_norw']));
        $description_no = htmlspecialchars(strip_tags($_POST['short_descr_norw']));
        $descriptionLong_no = htmlspecialchars(strip_tags($_POST['long_descr_norw']));


        $stmt->execute();
        $stmt_en->execute();
        $stmt_no->execute();

        // echo $stmt;
        if ($stmt->execute()  ) {
            echo "<div class='alert alert-success'>Record was updated.</div>";
        } else {
            echo "<div class='alert alert-danger'>Unable to update record. Please try  again.</div>";


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
                <div class="row">


                    <div class="col-3 main-data-section">
                        <table class="table table-hover table-responsive table-bordered">
                            <h3> Product Name</h3>
                            <tr>
                                <td>Price</td>
                                <td><input type="text" name="price"
                                           value="<?php echo htmlspecialchars($price, ENT_QUOTES); ?>"
                                           class="form-control"/></td>
                            </tr>
                            <tr>
                                <td>Reference</td>
                                <td><input type='text' name='refer'
                                           value="<?php echo htmlspecialchars($reference, ENT_QUOTES); ?>"
                                           class='form-control'/></td>
                            </tr>
                        </table>
                    </div>

                    <!--Dansk-->
                    <div class="col-6 offset-3 dansk-data-section">
                        <table class='table table-hover table-responsive table-bordered'>

                            <h3> Dansk Description</h3>
                            <tr>
                                <td>Name</td>
                                <td>
                                    <input type="text" name="name"
                                           value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>"
                                           class="form-control"/>
                                </td>
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
                        </table>
                    </div>

                    <!--English-->
                     <div class="col-6 english-data-section">
                    <table class='table table-hover table-responsive table-bordered'>
                        <h3> English</h3>
                        <tr>
                            <td>Name</td>
                            <td><input type="text" name="name_english"
                                       value="<?php echo htmlspecialchars($name_eng, ENT_QUOTES); ?>"
                                       class='form-control'/></td>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <label for="short_descr">Short Description</label>
                                <textarea type="text" name="short_descr_english" rows="2"
                                          class="form-control"><?php echo htmlspecialchars($description_eng, ENT_QUOTES); ?></textarea></td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <label for="short_descr">Long Description</label>
                                <textarea type="text" name="long_descr_english" rows="4"
                                          class="form-control"><?php echo htmlspecialchars($descriptionLong_eng, ENT_QUOTES); ?></textarea></td>
                                </textarea>
                            </div>
                        </tr>
                    </table>
                </div>

                    <!--Norge -->
                     <div class="col-6 norwegian-data-section">
                    <table class='table table-hover table-responsive table-bordered'>
                        <h3> Norwegian</h3>

                        <tr>
                            <td>Name</td>
                            <td><input type='text' name='name_norw'
                                       value="<?php echo htmlspecialchars($name_no, ENT_QUOTES); ?>"
                                       class='form-control'/></td>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <label for="short_descr">Short Description</label>
                                <textarea type="text" name="short_descr_norw" rows="2"
                                          class="form-control"><?php echo htmlspecialchars($description_no, ENT_QUOTES); ?></textarea></td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <label for="short_descr">Long Description</label>
                                <textarea type="text" name="long_descr_norw" rows="4"
                                          class="form-control"><?php echo htmlspecialchars($descriptionLong_no, ENT_QUOTES); ?></textarea></td>
                                </textarea>
                            </div>
                        </tr>
                    </table>
                </div>

                    <!--Button SUBMIT-->
                      <div class="col-lg-6 right">
                    <table class='table table-hover table-responsive table-bordered'>
                        <tr>
                            <td>
                                <input type='submit' value='Save Changes' class='btn btn-primary'
                                       name="update_btn"/>
                                <a href='index.php' class='btn btn-danger'>Back to read products</a>
                            </td>
                        </tr>
                    </table>
                </div>

                </div>
            </form>
    </div>
</div>
<?php require 'footer.php'; ?>

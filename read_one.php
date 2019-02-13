<?php require 'templates/header.php'; ?>
<!-- container -->
<div class="container">

    <div class="page-header text-center title-section">
        <h1>Enkelt Produkt</h1>
    </div>

    <?php
    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    //include database connection
    include 'config/database.php';

    // read current record's data
    try {

        $query = "SELECT * FROM products_description
                  LEFT JOIN products
                  ON  products.products_id =  products_description.products_id
                  JOIN languages
                  ON products_description.languages_id = languages.languages_id
                  WHERE products_description.products_id = ?";

        $stmt = $con->prepare($query);

        // this is the first question mark
        $stmt->bindParam(1, $id);

        // execute our query
        $stmt->execute();



while(  $row = $stmt->fetch(PDO::FETCH_ASSOC)){

if($row['languages_id'] ==1){
    $price = $row['products_price'];
    $reference = $row['products_reference'];
    $name = $row['products_description_name'];
    $description = $row['products_description_short_description'];
    $descriptionLong = $row['products_description_description'];
    $language = $row['languages_name'];
    $lang_id = $row['languages_id'];
}
    if($row['languages_id'] == 2){
        $eng_name = $row['products_description_name'];
        $eng_description = $row['products_description_short_description'];
        $eng_descriptionLong = $row['products_description_description'];
        $eng_language = $row['languages_name'];
        $eng_lang_id = $row['languages_id'];
    }
    if($row['languages_id'] == 3){
        $no_name = $row['products_description_name'];
        $no_description = $row['products_description_short_description'];
        $no_descriptionLong = $row['products_description_description'];
        $no_language = $row['languages_name'];
        $no_lang_id = $row['languages_id'];
    }
}

    } // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
    ?>

    <!--     LANGUAGES-->
    <div class="container">
        <div class="row">
            <div class="col-12 data-block">
                <div class="row">
                    <div class="col-4">
                        <!--we have our html table here where the record will be displayed-->
                        <table class='table table-hover table-bordered'>
                            <h3>Produkt Oplysninger</h3>
                            <tr>
                                <td><?php echo $lable_prod_reference;?></td>
                                <td><?php echo htmlspecialchars($reference, ENT_QUOTES); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $lable_prod_price;?></td>
                                <td><?php echo htmlspecialchars($price, ENT_QUOTES); ?></td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-4 offset-4 text-right">
                                <tr>
                                    <td>
                                        <a href='index.php' class='btn btn-danger'><?php echo $lable_back;?></a>
                                    </td>
                                    <td>
                                        <?php echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'><i class='far fa-edit'></i> Redigere</a>"; ?>
                                    </td>
                                </tr>
                        </div>
                    <div class="col-4">
                        <h3><?php echo htmlspecialchars($language, ENT_QUOTES); ?> oversættelse</h3>
                        <table class='table table-hover table-bordered'>
                            <!--DK-->
                            <tr>
                                <td><?php echo $lable_prod_name;?></td>
                                <td><?php echo $name; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $lable_prod_short_description;?></td>
                                <td><?php echo $description; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $lable_prod_long_description;?></td>
                                <td><?php echo $descriptionLong; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-4">
                        <h3><?php echo $eng_language; ?> oversættelse</h3>
                        <?php
                        if (empty($eng_name)):

                            echo 'GO to edit page to add description';

                        else:
                            ?>
                        <table class='table table-hover table-bordered'>
                            <!--ENG-->
                            <tr>
                                <td><?php echo $lable_prod_name;?></td>
                                <td><?php echo $eng_name; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $lable_prod_short_description;?></td>
                                <td><?php echo $eng_description; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $lable_prod_long_description;?></td>
                                <td><?php echo $eng_descriptionLong; ?></td>
                            </tr>
                        </table>
                        <?php endif;?>
                    </div>
                    <!--ENG END-->
                    <div class="col-4">
                        <h3><?php echo htmlspecialchars($no_language, ENT_QUOTES); ?> oversættelse</h3>
                        <?php
                        if (empty($no_name)):
                            echo 'GO to edit page to add description';
                        else:
                        ?>
                        <table class='table table-hover table-bordered'>
                            <!--Norge-->
                            <tr>
                                <td><?php echo $lable_prod_name;?></td>
                                <td><?php echo $no_name; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $lable_prod_short_description;?></td>
                                <td><?php echo $no_description; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $lable_prod_long_description;?></td>
                                <td><?php echo $no_descriptionLong; ?></td>
                            </tr>

                            <!--No Norwegian END-->
                        </table>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end .container -->

<?php require 'templates/footer.php'; ?>

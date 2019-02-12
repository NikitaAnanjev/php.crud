<?php require 'header.php'; ?>


<!-- container -->
<div class="container">

    <div class="page-header text-center">
        <h1>Single Product</h1>
    </div>

    <?php
    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    //include database connection
    include 'config/database.php';

    // read current record's data
    try {
        // prepare select query
//        $query = "SELECT * FROM products LEFT JOIN products_description ON products.products_id = products_description.products_id WHERE products.products_id = ? LIMIT 0,1 ";
//        $query = "SELECT * FROM products_description
//                  LEFT JOIN products
//                  ON  products.products_id =  products_description.products_id
//                  JOIN languages
//                  ON products_description.languages_id = languages.languages_id
//                  WHERE products_description.products_description_id = ? LIMIT 0,1";

////
//        $query = "SELECT * FROM products_description
//                  LEFT JOIN products
//                  ON  products.products_id =  products_description.products_id
//                  JOIN languages
//                  ON products_description.languages_id = languages.languages_id
//                  WHERE products_description.products_id = ? LIMIT 0,1";


        $language_key = '';
        $language_key_dk = '1';
        $language_key_en = '2';
        $language_key_no = '3';

        function languageSetup($language_key)
        {

            $query = "SELECT * FROM products_description
                  LEFT JOIN products
                  ON  products.products_id =  products_description.products_id
                  JOIN languages
                  ON products_description.languages_id = languages.languages_id
                  WHERE products_description.products_id = ?
                  AND products_description.languages_id = $language_key ";


            return $query;
        }


        $query = languageSetup($language_key_dk);
        $query2 = languageSetup($language_key_en);
        $query3 = languageSetup($language_key_no);

//        $query = "SELECT * FROM products_description
//                  LEFT JOIN products
//                  ON  products.products_id =  products_description.products_id
//                  JOIN languages
//                  ON products_description.languages_id = languages.languages_id
//                  WHERE products_description.products_id = ?
//                  AND products_description.languages_id = $language_key LIMIT 0,1";


        $stmt = $con->prepare($query);
        $stmt2 = $con->prepare($query2);
        $stmt3 = $con->prepare($query3);

        // this is the first question mark
        $stmt->bindParam(1, $id);
        $stmt2->bindParam(1, $id);
        $stmt3->bindParam(1, $id);

        // execute our query
        $stmt->execute();
        $stmt2->execute();
        $stmt3->execute();

        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);


//        $languages = $stmt2->fetch(PDO::FETCH_ASSOC);

//
//        extract($row);
//        extract($row2);
//        extract($row3);
        // values to fill up our form

        $price = $row['products_price'];
        $reference = $row['products_reference'];
        $name = $row['products_description_name'];


        $description = $row['products_description_short_description'];
        $descriptionLong = $row['products_description_description'];
        $language = $row['languages_name'];
        $lang_id = $row['languages_id'];

        $eng_name = $row2['products_description_name'];
        $eng_description = $row2['products_description_short_description'];
        $eng_descriptionLong = $row2['products_description_description'];
        $eng_language = $row2['languages_name'];
        $eng_lang_id = $row2['languages_id'];

        $no_name = $row3['products_description_name'];
        $no_description = $row3['products_description_short_description'];
        $no_descriptionLong = $row3['products_description_description'];
        $no_language = $row3['languages_name'];
        $no_lang_id = $row3['languages_id'];

//
//        echo '<pre>';
//        print_r($row);
//
//        echo '</pre>';


    } // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
    ?>
    <!-- HTML read one record table will be here -->


    <!--     LANGUAGES-->

    <div class="container">
        <div class="row">

            <div class="col-12">
                <div class="row">
                    <div class="col-12">

                        <!--we have our html table here where the record will be displayed-->
                        <table class='table table-hover table-responsive table-bordered'>
                            <thead>

                            <th>/</th>
                            <th><?php echo htmlspecialchars($language, ENT_QUOTES); ?> translation</th>



                            <th>
                                <a href="#">
                                    <span> + </span>
                                </a>
                            </th>
                            </thead>

                            <tr>
                                <td>Reference #</td>
                                <td><?php echo htmlspecialchars($reference, ENT_QUOTES); ?></td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td><?php echo htmlspecialchars($price, ENT_QUOTES); ?></td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-4">
                        <h3><?php echo htmlspecialchars($language, ENT_QUOTES); ?> translation</h3>
                        <table class='table table-hover table-responsive table-bordered'>
                            <!--DK-->
                            <tr>
                                <td>Name</td>
                                <td><?php echo htmlspecialchars($name, ENT_QUOTES); ?></td>
                            </tr>
                            <tr>
                                <td>Product Description</td>
                                <td><?php echo htmlspecialchars($description, ENT_QUOTES); ?></td>
                            </tr>
                            <tr>
                                <td>Long Description</td>
                                <td><?php echo htmlspecialchars($descriptionLong, ENT_QUOTES); ?></td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-4">
                        <h3><?php echo htmlspecialchars($eng_language, ENT_QUOTES); ?> translation</h3>
                        <table class='table table-hover table-responsive table-bordered'>
                            <!--ENG-->

                            <tr>
                                <td>Name</td>
                                <td><?php echo htmlspecialchars($eng_name, ENT_QUOTES); ?></td>
                            </tr>
                            <tr>
                                <td>Product Description</td>
                                <td><?php echo htmlspecialchars($eng_description, ENT_QUOTES); ?></td>
                            </tr>
                            <tr>
                                <td>Long Description</td>
                                <td><?php echo htmlspecialchars($eng_descriptionLong, ENT_QUOTES); ?></td>
                            </tr>

                            <!--ENG END-->
                        </table>
                    </div>
                    <div class="col-4">
                        <h3><?php echo htmlspecialchars($no_language, ENT_QUOTES); ?> translation</h3>
                        <table class='table table-hover table-responsive table-bordered'>

                            <!--Norge-->

                            <tr>
                                <td>Name</td>
                                <td><?php echo htmlspecialchars($no_name, ENT_QUOTES); ?></td>
                            </tr>
                            <tr>
                                <td>Product Description</td>
                                <td><?php echo htmlspecialchars($no_description, ENT_QUOTES); ?></td>
                            </tr>
                            <tr>
                                <td>Long Description</td>
                                <td><?php echo htmlspecialchars($no_descriptionLong, ENT_QUOTES); ?></td>
                            </tr>

                            <!--No Norwegian END-->
                        </table>
                    </div>
                    <div class="col-12">
                        <table class='table table-hover table-responsive table-bordered'>
                            <tr>
                                <td>
                                    <?php echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>"; ?></td>
                                <td>
                                    <a href='index.php' class='btn btn-danger'>Back to read products</a>
                                </td>
                            </tr>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end .container -->


<?php require 'footer.php'; ?>

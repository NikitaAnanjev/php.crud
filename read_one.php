
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
        $query = "SELECT * FROM products_description 
                  LEFT JOIN products 
                  ON  products.products_id =  products_description.products_id 
                  JOIN languages 
                  ON products_description.languages_id = languages.languages_id
                  WHERE products_description.products_description_id = ? LIMIT 0,1";


        $stmt = $con->prepare($query);

        // this is the first question mark
        $stmt->bindParam(1, $id);

        // execute our query
        $stmt->execute();

        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
//        $languages = $stmt2->fetch(PDO::FETCH_ASSOC);

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
    <!-- HTML read one record table will be here -->

    <div class="container">
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

                        <td>Name</td>
                        <td><?php echo htmlspecialchars($name, ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <td>Reference #</td>
                        <td><?php echo htmlspecialchars($reference, ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><?php echo htmlspecialchars($price, ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <td>Product Description</td>
                        <td><?php echo htmlspecialchars($description, ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <td>Long Description</td>
                        <td><?php echo htmlspecialchars($descriptionLong, ENT_QUOTES); ?></td>
                    </tr>
                    <tr>
                        <td>
                        <?php    echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";?></td>
                        <td>
                            <a href='index.php' class='btn btn-danger'>Back to read products</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div> <!-- end .container -->


<?php require 'footer.php'; ?>

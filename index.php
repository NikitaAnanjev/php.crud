<?php require 'header.php'; ?>


<?php
// include database connection
include 'config/database.php';

// delete message prompt will be here

// select all data from two tables

$query = "SELECT * FROM products INNER JOIN products_description ON products.products_id = products_description.products_id  ORDER BY products.products_id DESC";
$stmt = $con->prepare($query );
$stmt->execute();

// this is how to get number of rows returned
$num = $stmt->rowCount();
?>

<!--    check if more than 0 record found-->
<?php  if ($num > 0):?>
    <table class="table ">
        <thead>
        <tr>
            <th>Product reference</th>
            <th>Price</th>
            <th>ID</th>
            <th>Name</th>
            <th>Short Description</th>
            <th>Long Description</th>
            <th>ID Description</th>
            <th>ID Language</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <?php
        //                GET DATA INTO THE TABLE
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):

//        making $row['products_reference']; to just $products_reference;
        extract($row);
        ?>
            <tbody>
            <tr>
                <td><?php echo $products_reference; ?></td>
                <td><?php echo $products_price; ?></td>
                <td><?php echo $products_id; ?></td>
                <td><?php echo $products_description_name; ?></td>
                <td><?php echo $products_description_short_description; ?></td>
                <td><?php echo $products_description_description; ?></td>
                <td><?php echo $products_description_id; ?></td>
                <td><?php echo $languages_id; ?></td>
                <td>
<!--                    read one record-->
                    <?php
                    $id = $products_description_id;
                    echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";

                    // we will use this links on next part of this post
                    echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";?>

                    <?php echo "<a onclick='javascript:confirmationDelete($(this));return false;' class='btn btn-danger' href='index.php?delete=" . $table_row['products_id'] . "'>DELETE</a>"; ?>

                </td>
            </tr>
            </tbody>

            <!-- SCRIPT TO CONFIRM DELETE ELEMENT-->

            <script>
                function confirmationDelete(anchor) {
                    var conf = confirm('Are you sure want to delete this record?');
                    if (conf)
                        window.location = anchor.attr("href");
                }
            </script>


        <?php endwhile;

        else:
            echo "<div class='alert alert-danger'>No records found.</div>";

        endif;?>



    </table>
<?php // link to create record form
echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>"; ?>



<?php require 'footer.php'; ?>
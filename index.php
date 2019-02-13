<?php require 'header.php'; ?>
<?php
// include database connection
include 'config/database.php';

// delete message prompt will be here
$action = isset($_GET['action']) ? $_GET['action'] : "";

// if it was redirected from delete.php
if ($action == 'deleted') {
    echo "<div class='alert alert-success text-center'>Record was deleted.</div>";
}
$language_id_shift = $_POST['select_language'];
if ($language_id_shift == null ) {
    $language_id_shift = '1';
}
// select all data from two tables

$query2 = "SELECT * FROM languages";
$stmt2 = $con->prepare($query2);
$stmt2->execute();

if(isset($_POST['submit']) && $_POST['language'] != 0){
    $language_id_shift = $_POST['language'];  // Storing Selected Value In Variable


}
$select ='<form    method="POST" >';
$select .= '<select name="select_language"  id="select_language">';

while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)):
    extract($row2);
    $select .= '<option value="' . $languages_id . '">' . $languages_name . '</option>';
endwhile;

$select .= '</select>';
$select .= '<input type="submit" name="submit" value="Choose Language" />';
$select .= '</form>';

if(isset($_POST['submit']) && $_POST['select_language'] != 0){
    unset($language_id_shift);
    $language_id_shift = $_POST['select_language'];  // Storing Selected Value In Variable

}

$query = "SELECT * FROM products INNER JOIN products_description ON products.products_id = products_description.products_id WHERE languages_id = '$language_id_shift' ORDER BY products.products_id ASC";
$stmt = $con->prepare($query);
$stmt->execute();
// this is how to get number of rows returned
$num = $stmt->rowCount();
?>



    <!--    check if more than 0 record found-->
<?php if ($num > 0): ?>

    <div class="container text-center">
        <h1> Show all products</h1>
        <?php echo $select;
        ?>
    </div>

    <div class="container-fluid">
    <div class="row">
    <div class="col-8 offset-2 data-block">
    <table class="table table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Product reference</th>
        <th>Price</th>
        <th>Name</th>
        <th>Short Description</th>
        <th>Long Description</th>
        <!--            <th>ID Description</th>-->
<!--        <th>ID Language</th>-->
        <th colspan="2">Action</th>
    </tr>
    </thead>

    <tbody>
    <?php
    //    GET DATA INTO THE TABLE
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
    extract($row);
    $id = $products_description_id;
    ?>

   
    <tr>
        <td><?php echo $products_id; ?></td>
        <td><?php echo $products_reference; ?></td>
        <td><?php echo $products_price; ?></td>
        <td><?php echo $products_description_name; ?></td>
        <td><?php echo $products_description_short_description; ?></td>
        <td><?php echo $products_description_description; ?></td>
<!--        <td>--><?php //echo $languages_id; ?><!--</td>-->
        <td>

            <!-- read one record-->
            <?php

            echo "<a href='read_one.php?id={$products_id}' class='btn btn-info m-r-1em'><i class='fas fa-search'></i></a>";

            // we will use this links on next part of this post
            echo "<a href='update.php?id={$products_id}' class='btn btn-primary m-r-1em'><i class='far fa-edit'></i></a>";

            echo "<a href='#' onclick='delete_product({$products_id});'  class='btn btn-danger'><i class='far fa-trash-alt'></i></a>"; ?>
        </td>
    </tr>
    <!--      --><?php //endif;

    ?>
    </tbody>


    <!-- SCRIPT TO CONFIRM DELETE ELEMENT-->

    <script type='text/javascript'>


        // confirm record deletion
        function delete_product(id) {
            var answer = confirm('Are you sure?');
            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'delete.php?id=' + id;
            }
        }
    </script>
<?php endwhile;



else:
    echo "<div class='alert alert-danger'>No records found.</div>";
endif; ?>
    </table>
<?php // link to create record form

echo "<a href='create.php' class='btn btn-primary m-b-1em float-right'><i class='fas fa-plus-square'></i> New Product</a>"; ?>
    </div>

    </div>

    </div>


<?php require 'footer.php'; ?>
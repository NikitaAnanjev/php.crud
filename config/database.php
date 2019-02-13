<?php

//DB ACCESS
$host = '127.0.0.1:3306';
$username = 'u912870331_rit';
$password = '*** *** ***';
$db_name = 'u912870331_rito';


//$mysqli = new mysqli($db_host,$db_userName,$db_userPass,$db_name );

try {
    $con = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
}

// show error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>

<!--/COMMON VARIABLES-->
<?php





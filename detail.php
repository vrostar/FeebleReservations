<?php
//Require database in this file
/** @var $db */
require_once "reservations/database.php";

//If the ID isn't given, redirect to the homepage
if (!isset($_GET['id']) || $_GET['id'] === '') {
    header('Location: index.php');
    exit;
}

//Retrieve the GET parameter from the 'Super global'
$userId = $_GET['id'];

//Get the record from the database result
$query = "SELECT * FROM users WHERE id = " . $userId;
$result = mysqli_query($db, $query);

//If the album doesn't exist, redirect back to the homepage
if (mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit;
}

//Transform the row in the DB table to a PHP array
$user = mysqli_fetch_assoc($result);

//Close connection
mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details - <?= $user['name'] ?></title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<header>
    <img src="images/feeble1.png">
    <h1>Request Details</h1>
</header>
<section>
<h1><?= $user['name'] . ' - ' . $user['request'] ?></h1>


<ul>
    <li>EMAIL: <?= $user['email'] ?></li>
    <p></p>
    <li>VERZOEK: <?= $user['request'] ?></li>
    <p></p>
    <li>INFO: <?= $user['info'] ?></li>
</ul>

    <h1><a href="delete.php?id=<?= $user['id'] ?>">Delete</a></h1>
<div>
    <a href="index.php">Go back to the list</a>
</div>
</section>>
</body>
</html>
<footer>
    <p>&copy; FEEBLE</p>
</footer>

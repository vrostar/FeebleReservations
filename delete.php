<?php
// create database variable
/** @var mysqli $db */

// require database
require_once "reservations/database.php";

// if the submit button is activated
if (isset($_POST['submit'])) {

    // mysqli escape string to protect against XSS/SQL-injections
    // creates variable with the user's ID using post
    $userId = mysqli_escape_string($db, $_POST['id']);

    // page ID is set to the accompanying user's ID on the read page
    // select users from db whose ID matches the current page's ID
    $query = "SELECT * FROM users WHERE id = '$userId'";
    // put result from query in a variable or die if db error
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    $user = mysqli_fetch_assoc($result);


    // remove all data from the database that has the current page's ID (userId)
    $query = "DELETE FROM users WHERE id = '$userId'";
    mysqli_query($db, $query) or die ('Error: ' . mysqli_error($db));

    // close connection
    mysqli_close($db);

    // redirect to index after successful deletion
    header("Location: index.php");
    exit;

    // else if the URL id is not empty
} else if (isset($_GET['id']) || $_GET['id'] != '') {

    // mysqli escape string to protect against XSS/SQL-injections
    // creates variable with the user's ID using get
    $userId = mysqli_escape_string($db, $_GET['id']);

    // select users from db whose ID matches the current page's ID
    // page ID is set to the accompanying user's ID on the read page
    $query = "SELECT * FROM users WHERE id = '$userId'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
    } else {
        // redirect to index when db returns no result
        header('Location: index.php');
        exit;
    }
} else {
    // dd was not present in the url OR the form was not submitted

    // redirect to index.php
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete - <?= $user['name'] ?></title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>
<header>
    <img src="images/feeble1.png">
    <h1>Request Details</h1>
</header>
<section>
<body>
<h2>Delete - <?= $user['name'] ?></h2>
<form action="" method="post">
    <p>
        Weet u zeker dat u het album "<?= $user['name'] ?>" wilt verwijderen?
    </p>
    <input type="hidden" name="id" value="<?= $user['id'] ?>"/>
    <input type="submit" name="submit" value="Verwijderen"/>
</form>
</body>
</section>
</html>

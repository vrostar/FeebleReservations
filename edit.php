<?php
// create a variable for the database
/** @var mysqli $db */

session_start();

// if user is not logged in send to login page
// admin will be able to log in
if (!isset($_SESSION['LoginUser'])) {
    header("Location: login.php");

    // else if user is not the admin (id = 10) send them to the homepage
} elseif ($_SESSION['LoginUser']['id'] != 10 ) {
    header("Location: homepage.php");
}


// use the GET to retrieve ID of the user/reservation
$userId = $_GET['id'];

// if the submit button is activated
if (isset($_POST['submit'])) {

    // require the database
    require_once "reservations/database.php";

    // mysqli escape string to protect against XSS/SQL-injections
    // set variables to the information from the form using post
    $name   = mysqli_escape_string($db, $_POST['name']);
    $request = mysqli_escape_string($db, $_POST['request']);
    $email  = mysqli_escape_string($db, $_POST['email']);
    $info  = mysqli_escape_string($db, $_POST['info']);

    // require validation that checks if form has been filled in
    require_once "reservations/form-validation.php";

// if the form has been filled in correctly
    if (empty($errors)) {
        // update the information in the users table to the new information sent by the form
        // update is only applied to current reservation using the GET and user ID
        $query = "UPDATE users SET name='$name',request='$request',email='$email',info='$info' WHERE id='$userId'";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        // if edit/update is succesful send back to index page
        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        // close connection
        mysqli_close($db);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Music Collection Edit</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<header>
    <img src="images/feeble1.png">
<h1>Edit</h1>
</header>
<section>

<!--    send information from form to query-->
<!--    show error message next to form if field is empty-->
    <!--enctype="multipart/form-data" no characters will be converted-->
    <form action="" method="post" enctype="multipart/form-data">
        <div class="data-field">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="<?= isset($name) ? htmlentities($name) : '' ?>"/>
            <span class="errors"><?= isset($errors['name']) ? $errors['name'] : '' ?></span>
        </div>
        <div class="data-field">
            <label for="request">Request</label>
            <input id="request" type="text" name="request" value="<?= isset($request) ? htmlentities($request) : '' ?>"/>
            <span class="errors"><?= isset($errors['request']) ? $errors['request'] : '' ?></span>
        </div>
        <div class="data-field">
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="<?= isset($email) ? htmlentities($email) : '' ?>"/>
            <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
        </div>
        <div class="data-field">
            <label for="info">Info</label>
            <input id="info" type="text" name="info" value="<?= isset($info) ? htmlentities($info) : '' ?>"/>
            <span class="errors"><?= isset($errors['info']) ? $errors['info'] : '' ?></span>
        </div>
        <div class="data-submit">
            <input type="submit" name="submit" value="Save"/>
        </div>
    </form>
</section>
<div>
    <a href="index.php">Go back to the list</a>
</div>
</body>
</html>
<footer>
    <p>&copy; FEEBLE</p>
</footer>

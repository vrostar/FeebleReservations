<?php
/** @var mysqli $db */

// if the form is submitted
if (isset($_POST['submit'])) {
    // require the database
    require_once "reservations/database.php";

    // mysqli escape string to protect against XSS/SQL-injections
    // create variables with the information from the form using post
    $name   = mysqli_escape_string($db, $_POST['name']);
    $request = mysqli_escape_string($db, $_POST['request']);
    $email  = mysqli_escape_string($db, $_POST['email']);
    $info  = mysqli_escape_string($db, $_POST['info']);

    // require validation that checks if form has been filled in
    require_once "reservations/form-validation.php";

    // if the form has been filled in correctly
    if (empty($errors)) {

        // save the information from the form to database
        $query = "INSERT INTO users (name, request, email, info)
                  VALUES ('$name', '$request', '$email', '$info')";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        // if the information has been sent to the database go to success page
        // success page shows data has been sent successfully
        if ($result) {
            header('Location: success.php');
            exit;
            // if something went wrong display the database error
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        // close connection with database
        mysqli_close($db);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="https://freight.cargo.site/w/1000/i/342d3ecd769707cc69f3765beaeaddd06e772fe37d9d934f849e071e1889e817/feeble-basic-logo.png" />
    <title>Reservations</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<header>
    <img src="images/feeble1.png">
     <h1>Make a Request!</h1>
</header>

<!-- if there are database errors show them on page-->
<?php if (isset($errors['db'])) { ?>
    <div><span class="errors"><?= $errors['db']; ?></span></div>
<?php } ?>
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
    <a href="login/login.php">login</a>
</div>
</body>
</html>
<footer>
    <p>&copy; FEEBLE</p>
</footer>

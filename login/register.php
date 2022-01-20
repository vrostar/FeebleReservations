<?php

if(isset($_POST['submit'])) {
    require_once "../reservations/database.php";

    /** @var mysqli $db */

    $email = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $errors = [];
    if($email == '') {
        $errors['email'] = 'Voer een gebruikersnaam in';
    }
    if($password == '') {
        $errors['password'] = 'Voer een wachtwoord in';
    }

    // if all fields are filled in
    if(empty($errors)) {
        // hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // save the information from the form to database
        $query = "INSERT INTO logins (email, password) VALUES ('$email', '$password')";

        $result = mysqli_query($db, $query)
        or die('Db Error: '.mysqli_error($db).' with query: '.$query);

        if ($result) {
            header('Location: regsuccess.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="https://freight.cargo.site/w/1000/i/342d3ecd769707cc69f3765beaeaddd06e772fe37d9d934f849e071e1889e817/feeble-basic-logo.png" />
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<header>
    <img src="../images/feeble1.png">
    <h1>Make a Request!</h1>
    <nav>

        <div><a href="../homepage.php">Home</a></div>
        <div><a href="login/login.php">Videos</a></div>
        <div><a href="login/login.php">Covers</a></div>
        <div><a href="login/login.php">Werk met ons!</a></div>
        <div><a href="login/login.php">About</a></div>

    </nav>
</header>
<section>
<h1>Register</h1>
<form action="" method="post">
    <div class="data-field">
        <label for="email">Email</label>
        <input id="email" type="text" name="email" value="<?= isset($email) ? htmlentities($email) : '' ?>"/>
        <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" value="<?= isset($password) ? htmlentities($password) : '' ?>"/>
        <span class="errors"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
    </div>
    <div class="data-submit">
        <input type="submit" name="submit" value="Registreren"/>
    </div>
</form>
</section>
</body>
</html>
<footer>
    <p>&copy; FEEBLE</p>
</footer>

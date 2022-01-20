<?php
session_start();

// if user is logged in set login to true
if(isset($_SESSION['LoginUser'])) {
    $login = true;
} else {
    $login = false;
}

/** @var mysqli $db */
require_once "../reservations/database.php";

// post email and password
if (isset($_POST['submit'])) {
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $errors = [];
    if($email == '') {
        $errors['email'] = 'Voer een gebruikersnaam in';
    }
    if($password == '') {
        $errors['password'] = 'Voer een wachtwoord in';
    }

    if(empty($errors))
    {
        // get the email from the user in database
        $query = "SELECT * FROM logins WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            // get the data from logins table from database
            $logins = mysqli_fetch_assoc($result);
            // verify password
            if (password_verify($password, $logins['password'])) {
                $login = true;

                $_SESSION['LoginUser'] = [
                    'email' => $logins['email'],
                    'id' => $logins['id']
                ];

            } else {
                //error if wrong combination email and pass
                $errors['loginFailed'] = 'The combination Email Password is incorrect';
            }
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
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<header>
    <img src="../images/feeble1.png">
    <h1>Login</h1>
    <nav>

        <div><a href="../homepage.php">Home</a></div>
        <div><a href="login/login.php">Videos</a></div>
        <div><a href="login/login.php">Covers</a></div>
        <div><a href="login/login.php">Werk met ons!</a></div>
        <div><a href="login/login.php">About</a></div>

    </nav>
</header>
<section>
<h1>Login</h1>
<!--    if logged in user has the admin id (id = 10) give them a link to reservations and logout-->
    <?php if ($login == true && $_SESSION['LoginUser']['id'] == 10 ) { ?>
        <p>You're logged in !</p>
        <p><a href="logout.php">Log Out</a> / <a href="../index.php">Reservations</a></p>
<!--        if logged in user is generic user give them a link to request create page and logout-->
    <?php } elseif ($login == true) { ?>
    <p>You're logged in !</p>
    <p><a href="logout.php">Log Out</a> / <a href="../create.php">Make A Request</a></p>
<!--        else if not logged in show login form-->
<?php } else { ?>
    <form action="" method="post">
        <div>
            <label for="email">Email</label>
            <input id="email" type="text" name="email" value="<?= isset($email) ? htmlentities($email) : '' ?>"/>
            <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" value="<?= isset($password) ? htmlentities($password) : '' ?>"/>
            <span class="errors"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
        </div>
        <div>
            <p class="errors"><?= isset($errors['loginFailed']) ? $errors['loginFailed'] : '' ?></p>
            <input type="submit" name="submit" value="Login"/>
        </div>
    </form>
<?php } ?>
    <div>
        <a href="register.php">Register here</a>
    </div>
</section>
</body>
</html>
<footer>
    <p>&copy; FEEBLE</p>
</footer>

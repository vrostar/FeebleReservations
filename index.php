<?php
//create database variable
/** @var $db */

session_start();


// if user is not logged in send to login page
// admin will be able to log in
 if (!isset($_SESSION['LoginUser'])) {
     header("Location: login.php");

     // else if user is not the admin (id = 10) send them to the homepage
 } elseif ($_SESSION['LoginUser']['id'] != 10 ) {
     header("Location: homepage.php");
 }

 // if user id = 10 they can access the page

// require database
require_once "reservations/database.php";

// get information from the users table from the database
$query = "SELECT * FROM users";
$result = mysqli_query($db, $query);

// insert the user the information in an empty array
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

// close connection
mysqli_close($db);

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
    <h1>Reservations</h1>
</header>

    <section>
        <a href="homepage.php">Return to site</a>
        <table>
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Request</th>
                <th>Info</th>
                <th>More</th>
            </tr>
            </thead>
            <tbody>
            <!--    using a foreach loop, display all information from users in the users table-->
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['request'] ?></td>
                    <td><?= $user['info'] ?></td>
                    <td><a href="detail.php?id=<?= $user['id'] ?>">Details</a></td>
                    <td><a href="delete.php?id=<?= $user['id'] ?>">Delete</a></td>
                    <td><a href="edit.php?id=<?= $user['id'] ?>">Edit</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>
<footer>
    <p>&copy; FEEBLE</p>
</footer>
    </body>
    </html>


<?php
// make an empty errors array
$errors = [];

// if any of the following data fields is empty
if ($name == "") {
    // show error message next to accompanying field
    $errors['name'] = 'Name cannot be empty';
}
if ($request == "") {
    $errors['request'] = 'Request cannot be empty';
}
if ($email == "") {
    $errors['email'] = 'Email cannot be empty';
}

if ($info == "") {
    $errors['info'] = 'Info cannot be empty';
}


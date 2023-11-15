<?php
require 'db.php';

if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
    $errorTest = addUser($_POST["username"]);

    if ($errorTest == true) {
        header("Location: /quiz/");
        exit();
    }
    else {
        header("Location: /quiz/register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- CSS um es schöner zu machen -->
    <title>Registrierung</title>
</head>

<body>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <button type="submit">Submit</button>
    </form>
</body>

</html>
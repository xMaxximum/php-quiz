<?php

// benutzt die funktionen von db.php
require 'db.php';

// Falls kein Benutzer schon in diesem Browser registriert ist,
// dann schicke ihn zu register.php
if (!isset($_SESSION["username"])) {
    header("Location: register.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- CSS um es schöner zu machen -->
    <title>Quiz</title>
</head>

<body>
    <h1>Willkommen <?php echo $_SESSION["username"] ?>, wähle ein Quiz aus:</h1>
    <ul>
        <?php
        $alleQuizzes = getQuizze();

        $onclick = "window.location.href";

        // zeige alle Quizzes an
        foreach ($alleQuizzes as $item) {
            echo "<li> <a href='/quiz/quiz.php?quiz=$item->id'> $item->name ($item->beschreibung) </a> <button onclick='$onclick=\"/quiz/leaderboard.php?id=$item->id\"'>🏆</button> </li>";
        }
        ?>
    </ul>
</body>

</html>
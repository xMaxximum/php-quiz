<?php

require 'db.php';

// wenn kein parameter mit "id" existiert, gehe zurück zu /quiz
if (empty($_GET["id"])) {
    header("Location: /quiz");
    exit();
}

// bekomme die rankings und das quiz
$rankings = getRankings($_GET["id"]);
$quiz = getQuiz($_GET["id"]);

// wenn kein quiz gefunden wurde, gehe zurück zu /quiz
if ($quiz == false) {
    header("Location: /quiz");
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
    <title>Leaderboard</title>
</head>

<body>

    <h2>Rangliste für Quiz "<?php echo "$quiz->name"; ?>"</h2>

    <table>
        <thead>
            <th>Platz</th>
            <th>Punktzahl</th>
            <th>Name</th>
        </thead>
        <tbody>

            <?php
            $counter = 1;
            foreach ($rankings as $ranking) {
                echo "<tr> <td>$counter.</td> <td>$ranking->punktzahl</td> <td>$ranking->name</td></tr>";
                $counter = $counter + 1;
            }
            ?>
        </tbody>
    </table>
    <br><br>
    <button onclick="window.location.href='/quiz'">Hauptmenü</button>
</body>

</html>
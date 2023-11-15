<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- CSS um es schöner zu machen -->
    <title>Ergebnis</title>
</head>

<?php
require 'db.php';

// ob die HTTP POST Methode benutzt wurde
if ($_POST) {
    $antworten = getAntworten($_SESSION["quizId"]);
    $quiz = getQuiz($_SESSION["quizId"]);
    $fragen = getFragen($_SESSION["quizId"]);
}
?>

<body>
    <h1>Quiz Ergebnis</h1>
    <a>Titel: <?php echo $quiz->name ?></a> <br>
    <a>Beschreibung: <?php echo $quiz->beschreibung ?> </a> <br> <br>
    <br>
    <a>Fragen:</a> <br>

    <?php
    if ($_POST) {
        $counter = 0;
        $richtigeAntworten = 0;
        foreach ($_POST as $antwort) {
            // richtige Antwort
            if ($antwort == $antworten[$counter]->antwort) {
                echo "$counter: {$fragen[$counter]->frage} ✅";
                $richtigeAntworten = $richtigeAntworten + 1;
            }

            // falsche Antwort
            else {
                echo "$counter: {$fragen[$counter]->frage} ❌";
                echo "<br> Deine Antwort: {$antwort}";
                echo "<br> Richtige Antwort: {$antworten[$counter]->antwort}";
            }
            echo "<br>";
            $counter = $counter + 1;
        }

        echo "<br><br>Du hast $richtigeAntworten Frage(n) richtig beantwortet!";
    }
    ?>

    <br><br><br>
    <button onclick="window.location.href='/quiz'">Hauptmenü</button>
    <form method="POST" action="submitRanking.php">
        <input type="hidden" name="score" value="<?php echo "$richtigeAntworten" ?>">
        <button type="submit">Auf Rangliste hochladen</button>
    </form>

</body>

</html>
<?php
require 'db.php';

// wenn kein quiz parameter existiert, gehe zurück zu quiz
if (empty($_GET["quiz"])) {
    header("Location: /quiz");
}

$quiz = getQuiz($_GET["quiz"]);
if ($quiz == false) {
    header("Location: /quiz/");
} else {
    $fragen = getFragen($quiz->id);
    $_SESSION["quizId"] = $quiz->id;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- CSS um es schöner zu machen -->
    <title>Q: <?php echo $quiz->name ?> </title>
</head>

<body>
    <?php if (isset($fragen)) : ?>
        <div>
            <?php
            echo "Titel: $quiz->name<br>";
            echo "Beschreibung: $quiz->beschreibung<br><br>"; ?>
            <form method="POST" action="result.php">
                <?php
                foreach ($fragen as $frage) {
                    echo "<br>$frage->frage<br>";


                    // exakte antwort
                    if ($frage->type == 0) {
                        echo "<input type='text' required name='$frage->id'><br>";
                    }


                    // multiple choice
                    else if ($frage->type == 1) {
                        $antworten = getMultipleChoiceAntworten($frage->id);
                        echo "<br>";
                        shuffle($antworten);
                        foreach ($antworten as $antwort) {
                            echo "<input type='radio' required name='$frage->id' value='$antwort->antwort'>$antwort->antwort<br>";
                        }
                        echo "<br>";
                    }
                }
                ?>
                <br><br>
                <input type="submit">
                <button class="cancel" onclick="window.location.href='/quiz'">Abbrechen</button>
            </form>
        </div>

    <?php endif; ?>
</body>

</html>
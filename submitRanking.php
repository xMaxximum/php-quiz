<?php

if (isset($_POST)) {
    require 'db.php';

    uploadScore($_POST["score"], $_SESSION["username"], $_SESSION["quizId"]);
    
    header("Location: /quiz/");
    exit();
}

?>
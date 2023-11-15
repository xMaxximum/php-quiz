<?php

// startet eine Session mit Cookies
session_start();

// Initialisiert eine Verbindung mit der Datenbank
$db = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8', "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Strukturen die in der Datenbank sind in PHP abgebildet. 

class Quiz
{
    public $id; // int
    public $name; // text
    public $beschreibung; // text
}

class Frage
{
    public $id; // int
    public $quiz_id; // int
    public $frage; // text
    public $type; // int
}

class Antwort
{
    public $frage_id; // int
    public $antwort; // text
    public $korrekt; // bool
}

class Ranking {
    public $id; // int
    public $benutzer; // int
    public $quiz_id; // int
    public $punktzahl; // int
}


// funktion die eine SQL query vorbereitet
function prepare_execute($query)
{
    global $db;

    $prepared = $db->prepare($query);
    $prepared->execute();
    return $prepared;
}

function getQuizze()
{
    $query = "SELECT * FROM quizze";

    $ergebnis = prepare_execute($query);

    return $ergebnis->fetchAll(PDO::FETCH_CLASS, "Quiz");
}

function getQuiz($quizId)
{
    $query = "SELECT * FROM quizze WHERE id = '$quizId'";

    $ergebnis = prepare_execute($query);
    if ($ergebnis == false) {
        return false;
    }
    return $ergebnis->fetchObject("Quiz");
}

function getFragen($quizId)
{
    $query = "SELECT * FROM fragen WHERE quiz_id = '$quizId'";

    $ergebnis = prepare_execute($query);

    return $ergebnis->fetchAll(PDO::FETCH_CLASS, "Frage");
}

function getMultipleChoiceAntworten($frageId)
{
    $query = "SELECT antwort FROM antworten WHERE frage_id = '$frageId'";

    $ergebnis = prepare_execute($query);

    return $ergebnis->fetchAll(PDO::FETCH_CLASS, "Antwort");
}

function getAntworten($quizId)
{
    $query = "SELECT antwort FROM antworten 
    INNER JOIN fragen ON fragen.id = antworten.frage_id 
    INNER JOIN quizze ON quizze.id = fragen.quiz_id
    WHERE antworten.korrekt = true AND quizze.id = $quizId";

    $ergebnis = prepare_execute($query);
    return $ergebnis->fetchAll(PDO::FETCH_CLASS, "Antwort");
}

// registriert einen neuen Nutzer.
// Falls ein Name schon existiert, wird false zurückgegeben
function addUser($name)
{
    try {
        $query = "INSERT INTO users (`name`) VALUES ('$name')";

        $ergebnis = prepare_execute($query);
        return $ergebnis;
    } catch (PDOException $e) {
        return false;
    }
}

function uploadScore($punktzahl, $user, $quizId)
{
    $query = 
    "INSERT INTO rangliste (benutzer, quiz_id, punktzahl)
    VALUES ((SELECT id FROM users WHERE name = '$user'), $quizId, $punktzahl)
    ON DUPLICATE KEY UPDATE punktzahl = GREATEST(punktzahl, $punktzahl)";

    prepare_execute($query);
}

function getRankings($quizId) {
    $query = "SELECT users.name, rangliste.quiz_id, rangliste.punktzahl FROM rangliste
    INNER JOIN users ON rangliste.benutzer = users.id
    WHERE rangliste.quiz_id = '$quizId' ORDER BY rangliste.punktzahl DESC";

    $ergebnis = prepare_execute($query);

    return $ergebnis->fetchAll(PDO::FETCH_CLASS, "Ranking");
}

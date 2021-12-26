<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="height: 100vh; margin: 0; display: flex; align-items: center; justify-content: center;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">

    <?php
    createDatabase();

    createTable();

    ?>

    <div style="position: relative; font-size: 50px;">Database Initialized.</div>


</body>
</html>

<?php

// create the database
function createDatabase() {
    $sql = "CREATE DATABASE IF NOT EXISTS quizdb";

    $pdo = new pdo('mysql:localhost', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $pdo->query($sql);
}

// create tables
function createTable() {
    $sql = "CREATE TABLE User (
        user_id	VARCHAR(50) NOT NULL,
        user_name VARCHAR(50) NOT NULL,
        password	 VARCHAR(50) NOT NULL,
        isStaff BOOLEAN NOT NULL,
    
        CONSTRAINT User_pk
            PRIMARY KEY (user_id)
    );
    
    
    
    -- -----------------------------
    -- TABLE 'QuizInfo'
    -- -----------------------------
    CREATE TABLE Quiz (
        quiz_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        quiz_name VARCHAR(200) NOT NULL,
        quiz_author VARCHAR(50) NOT NULL,
        author_id VARCHAR(50) NOT NULL,
        quiz_available BOOLEAN NOT NULL,
        quiz_duration INT UNSIGNED NOT NULL,
    
        CONSTRAINT QuizInfo_pk
            PRIMARY KEY (quiz_id),
        CONSTRAINT  author_id_User_user_id
            FOREIGN KEY (author_id) REFERENCES User (user_id)
    );
    
    
    
    -- -----------------------------
    -- TABLE 'DeletedQuiz'
    -- -----------------------------
    CREATE TABLE DeletedQuiz (
        quiz_id	INT UNSIGNED NOT NULL,
        user_id	VARCHAR(50) NOT NULL,
        deleted_date DATETIME NOT NULL,
    
        CONSTRAINT DeletedQuiz_pk
            PRIMARY KEY (quiz_id),
        CONSTRAINT user_id_DeletedQuiz_User_user_id
            FOREIGN KEY (user_id) REFERENCES User (user_id)
    );
    
    
    
    -- -----------------------------
    -- TABLE 'Questions'
    -- -----------------------------
    CREATE TABLE Questions (
        quiz_id INT UNSIGNED NOT NULL,
        question_id INT UNSIGNED NOT NULL ,
    
        question_context VARCHAR(200) NOT NULL,
    
        # solution == some options in this question
        solution INT UNSIGNED NOT NULL,
    
        CONSTRAINT Questions_pk
            PRIMARY KEY (quiz_id, question_id),
        CONSTRAINT quiz_id_Questions_Quiz_quiz_id
            FOREIGN KEY (quiz_id) REFERENCES Quiz (quiz_id) ON DELETE CASCADE
    );
    
    
    
    -- -----------------------------
    -- TABLE 'Options'
    -- -----------------------------
    CREATE TABLE Options (
        quiz_id INT UNSIGNED NOT NULL,
        question_id INT UNSIGNED NOT NULL,
        option_id INT UNSIGNED NOT NULL,
        option_context VARCHAR(200) NOT NULL,
        option_mark int NOT NULL,
    
        CONSTRAINT Options_pk
            PRIMARY KEY (quiz_id, question_id, option_id),
        CONSTRAINT quiz_id_Options_Question_quiz_id
            FOREIGN KEY (quiz_id, question_id) REFERENCES Questions (quiz_id, question_id) ON DELETE CASCADE
    );
    

    
    -- -----------------------------
    -- TABLE 'TestInfo'
    -- -----------------------------
    CREATE TABLE Test (
        quiz_id INT UNSIGNED NOT NULL,
        user_id VARCHAR(50) NOT NULL ,
        attempt_date DATE NOT NULL,
        score INT UNSIGNED NOT NULL,
        score_percent INT UNSIGNED NOT NULL,
    
        CONSTRAINT TestInfo_pk
            PRIMARY KEY (quiz_id, user_id),
        CONSTRAINT user_id_Test_User_user_id
            FOREIGN KEY (user_id) REFERENCES User (user_id)
    );";

    $pdo = new pdo('mysql:host=localhost;dbname=quizdb', 'root', 'root');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $pdo->query($sql);    
}


?>






<?php
//fazendo conexao no banco de dados
    $host = "localhost:";
    $dbname = "prova";
    $username = "root";
    $password = "sucesso";

    try {
        $conn = new PDO("mysql: host=$host; dbname=$dbname", $username, $password);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $error) {
        echo "erro na conexão". $error->getMessage();
    }
?>
<?php
$pdo = new PDO('mysql:host=localhost;dbname=carsss-bd', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
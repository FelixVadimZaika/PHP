<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new PDO("mysql:host=localhost;dbname=local.pu911.com", "root", "");
    $sql = "DELETE FROM `news` WHERE id = ?";

    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/news/' . $_POST["image"];
    unlink($filePath);

    $conn->prepare($sql)->execute([$_POST["id"]]);
}
?>

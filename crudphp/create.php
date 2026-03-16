<?php
require 'db.php';
require 'functions.php';
 
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title         = $_POST['title'];
    $resource_type = $_POST['resource_type'];
    $stock         = $_POST['stock'];
    $available     = checkAvailability($stock);
 
 
    if (!validateNumber($stock)) {
        die("Error: Stock must not be negative.");
    }
 
 
    $sql = "INSERT INTO eresources (title, resource_type, stock, available)
            VALUES (:title, :resource_type, :stock, :available)";
 
 
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title'         => $title,
        ':resource_type' => $resource_type,
        ':stock'         => $stock,
        ':available'     => $available
    ]);
 
 
    header("Location: read.php");
}
?>
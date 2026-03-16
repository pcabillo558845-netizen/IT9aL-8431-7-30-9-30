<?php
require 'db.php';
require 'functions.php';
 
 
$id = $_GET['id'];
 
 
$stmt = $pdo->prepare("DELETE FROM eresources WHERE id = :id");
$stmt->execute([':id' => $id]);
 
 
header("Location: read.php");
?>
 
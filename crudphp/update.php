<?php
require 'db.php';
require 'functions.php';
 
 
$id = $_GET['id'];
 
 
$stmt = $pdo->prepare("SELECT * FROM eresources WHERE id = :id");
$stmt->execute([':id' => $id]);
$data = $stmt->fetch();
 
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title         = $_POST['title'];
    $resource_type = $_POST['resource_type'];
    $stock         = $_POST['stock'];
    $available     = checkAvailability($stock);
 
 
    if (!validateNumber($stock)) {
        die("Error: Stock must not be negative.");
    }
 
 
    $sql = "UPDATE eresources
            SET title=:title, resource_type=:resource_type,
                stock=:stock, available=:available
            WHERE id=:id";
 
 
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title'         => $title,
        ':resource_type' => $resource_type,
        ':stock'         => $stock,
        ':available'     => $available,
        ':id'            => $id
    ]);
 
 
    header("Location: read.php");
}
?>
 
 
<form method="post">
    Title: <input type="text" name="title" value="<?= $data['title'] ?>"><br>
    Resource Type:
    <select name="resource_type">
        <?php foreach (['eJournal','eBook','Database','Multimedia','Research Tool'] as $t): ?>
            <option value="<?= $t ?>" <?= $data['resource_type'] === $t ? 'selected' : '' ?>>
                <?= $t ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    Stock: <input type="number" name="stock" min="0" value="<?= $data['stock'] ?>"><br>
    <button type="submit">Update</button>
</form>
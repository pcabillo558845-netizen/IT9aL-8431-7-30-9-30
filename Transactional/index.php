<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Transaction Form</title>
  
</head>
<body>

<h2>Transaction Form</h2>

<form method="POST" action="process.php">

    <label>Item Name:</label><br>
    <input type="text" name="item_name" required><br><br>

    <label>Price (per unit):</label><br>
    <input type="number" name="price" step="0.01" min="0" required><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" min="1" required><br><br>

    <button type="submit">Process Transaction</button>

</form>

</body>
</html>

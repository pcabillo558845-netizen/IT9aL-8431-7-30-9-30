<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

$item_name = $_POST['item_name'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

function computeSubtotal($price, $quantity) {
    return $price * $quantity;
}

function computediscount($subtotal) {
    if ($subtotal > 500) {
        return $subtotal * 0.10; // 10% discount
    } else {
        return $subtotal * 0.05; // 5% discount
    }
}


function computeTax($subtotal, $discount) {
    $discounted = $subtotal - $discount;
    return $discounted * 0.12; // 12% tax
}

function computerFinalAmount($subtotal, $discount, $tax) {
    return $subtotal - $discount + $tax;
}

function formatCurrency($amount) {
    return "PHP " . number_format($amount, 2);
}

$item_display = strtoupper($item_name);
$name_length = strlen($item_name);

$subtotal = computeSubtotal($price, $quantity);
$discount = computediscount($subtotal);
$tax = round(computeTax($subtotal, $discount), 2);
$final = computerFinalAmount($subtotal, $discount, $tax);
$discount_rate = ($subtotal > 500) ? "10%" : "5%";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Summary</title>
    <link rel="stylesheet" href="style3.css"/>
</head>
<body>
    <h2>Transaction Summary</h2>
    <p><strong>Item Name:</strong> <?php echo $item_display; ?></p>
    <p><strong>Character Count:</strong> <?php echo $name_length; ?> characters</p>
    <p><strong>Price:</strong> <?php echo formatCurrency($price); ?></p>
    <p><strong>Quantity:</strong> <?php echo $quantity; ?></p>

<hr>

    <p><strong>Subtotal:</strong> <?php echo formatCurrency($subtotal); ?></p>
    <p><strong>Discount (<?php echo $discount_rate; ?>):</strong> - <?php echo formatCurrency($discount); ?></p>
    <p><strong>VAT (12%):</strong> + <?php echo formatCurrency($tax); ?></p>

<hr>

    <p><strong>Final Amount to Pay:</strong> <?php echo formatCurrency($final); ?></p>

<br>
<a href="index1.php">Back to Form</a>

</body>
</html>

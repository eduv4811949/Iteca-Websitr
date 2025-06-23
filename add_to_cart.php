<?php
session_start();

$cart = $_SESSION['cart'] ?? [];

if (!$cart) {
    echo "Your cart is empty. <a href='index.php'>Go shopping</a>";
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
</head>
<body>
<h1>Your Cart</h1>
<table border="1" cellpadding="10">
    <tr>
        <th>Image</th><th>Name</th><th>Price</th><th>Action</th>
    </tr>
    <?php foreach ($cart as $id => $item):
        $total += $item['price'];
    ?>
    <tr>
        <td><img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="max-width:80px;"></td>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td>$<?= number_format($item['price'], 2) ?></td>
        <td><a href="remove_from_cart.php?id=<?= $id ?>" onclick="return confirm('Remove this item?')">Remove</a></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2" style="text-align:right;"><strong>Total:</strong></td>
        <td colspan="2"><strong>$<?= number_format($total, 2) ?></strong></td>
    </tr>
</table>
<p><a href="index.php">Continue Shopping</a></p>
</body>
</html>

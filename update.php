<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid ID."; exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $img = $_POST['image_url'];

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image_url=? WHERE id=?");
    $stmt->bind_param("ssdsi", $name, $desc, $price, $img, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
} else {
    $res = $conn->query("SELECT * FROM products WHERE id=$id");
    $product = $res->fetch_assoc();
}
?>
<h2>Edit Product</h2>
<form method="POST">
    Name: <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"><br>
    Description:<br><textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea><br>
    Price: <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>"><br>
    Image URL: <input type="text" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>"><br>
    <input type="submit" value="Update">
</form>
<a href="index.php">⬅ Back</a>

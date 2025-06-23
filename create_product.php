<?php
require 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $image_url = $_POST['image_url'] ?? '';

    if (!$name || !$price || !$image_url) {
        $error = "Name, price and image URL are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $image_url);
        $stmt->execute();
        header("Location: admin_products.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0f0f1a;
            --gold: #d4af37;
            --white: #ffffff;
            --card: #1a1a2e;
            --text: #e4e4e4;
            --danger: #ff4c4c;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--navy);
            color: var(--text);
            margin: 0;
        }

        header {
            background: var(--navy);
            padding: 40px 0;
            text-align: center;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.7);
        }

        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8em;
            color: var(--gold);
            text-shadow: 0 0 10px var(--gold);
        }

        .container {
            background: var(--card);
            padding: 40px;
            margin: 60px auto;
            border-radius: 20px;
            max-width: 600px;
            box-shadow: 0 8px 30px rgba(255, 215, 0, 0.15);
        }

        h2 {
            font-family: 'Playfair Display', serif;
            text-align: center;
            color: var(--gold);
            font-size: 2em;
            margin-bottom: 30px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-top: 20px;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="number"],
        input[type="url"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #555;
            border-radius: 8px;
            font-size: 14px;
            background: #2a2a3b;
            color: var(--text);
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            width: 100%;
            margin-top: 30px;
            padding: 14px;
            font-size: 16px;
            background: var(--gold);
            border: none;
            color: var(--navy);
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #b89128;
        }

        .error {
            background: #ffdddd;
            color: var(--danger);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        a.back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: var(--gold);
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a.back-link:hover {
            color: #fff;
            text-decoration: underline;
        }

        footer {
            background: var(--navy);
            color: var(--gold);
            text-align: center;
            padding: 20px;
            margin-top: 60px;
        }

        ::placeholder {
            color: #aaa;
        }
    </style>
</head>
<body>

<header>
    <h1>🛒 Admin Dashboard – Add Product</h1>
</header>

<div class="container">
    <h2>➕ Add New Product</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="create_product.php">
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" required placeholder="e.g. Premium Watch">

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4" placeholder="Enter product details..."></textarea>

        <label for="price">Price ($)</label>
        <input type="number" step="0.01" name="price" id="price" required placeholder="e.g. 199.99">

        <label for="image_url">Image URL</label>
        <input type="url" name="image_url" id="image_url" required placeholder="https://example.com/image.jpg">

        <input type="submit" value="✅ Add Product">
    </form>

    <a href="admin_products.php" class="back-link">⬅ Back to Product List</a>
</div>

<footer>
    &copy; <?= date("Y") ?> Infinity Store Admin Panel
</footer>

</body>
</html>

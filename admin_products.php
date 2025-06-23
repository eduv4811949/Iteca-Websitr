<?php
require 'db.php';

// Fetch all products
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0f0f1a;
            --gold: #d4af37;
            --white: #ffffff;
            --gray: #f1f1f1;
            --text: #e4e4e4;
            --card: #1a1a2e;
            --danger: #e63946;
            --hover-gold: #b89128;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--navy);
            color: var(--text);
        }

        header {
            background: var(--navy);
            padding: 50px 20px;
            text-align: center;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.8);
        }

        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3em;
            color: var(--gold);
            text-shadow: 0 0 10px var(--gold);
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 40px;
        }

        .top-actions a {
            background: var(--gold);
            color: var(--navy);
            padding: 12px 24px;
            font-weight: bold;
            font-size: 1em;
            border-radius: 30px;
            text-decoration: none;
            transition: background 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.4);
        }

        .top-actions a:hover {
            background: var(--hover-gold);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: var(--card);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.15);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(255, 215, 0, 0.2);
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 15px;
            border: 2px solid var(--gold);
        }

        .product-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4em;
            color: var(--gold);
            margin: 0;
        }

        .price {
            margin: 10px 0;
            font-size: 1.1em;
            color: var(--gold);
            font-weight: bold;
        }

        .product-actions {
            margin-top: auto;
            display: flex;
            gap: 10px;
        }

        .product-actions a {
            flex: 1;
            text-align: center;
            padding: 10px;
            font-weight: 600;
            font-size: 0.95em;
            border-radius: 10px;
            color: var(--white);
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .edit-btn {
            background: #3b82f6;
        }

        .edit-btn:hover {
            background: #2563eb;
        }

        .delete-btn {
            background: var(--danger);
        }

        .delete-btn:hover {
            background: #a4161a;
        }

        footer {
            background: var(--navy);
            color: var(--gold);
            padding: 24px;
            text-align: center;
            margin-top: 80px;
            font-size: 0.9em;
        }

        @media (max-width: 600px) {
            .top-actions {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>💎 Admin Product Dashboard</h1>
</header>

<div class="container">

    <div class="top-actions">
        <a href="index.php">← Back to Store</a>
        <a href="create_product.php">➕ Add Product</a>
        <a href="admin_orders.php">📦 Manage Orders</a>
    </div>

    <div class="product-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p class="price">$<?= number_format($row['price'], 2) ?></p>
                <div class="product-actions">
                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="edit-btn">✏️ Edit</a>
                    <a href="delete_product.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?')">🗑️ Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

</div>

<footer>
    © <?= date("Y") ?> Admin Panel · All rights reserved.
</footer>

</body>
</html>

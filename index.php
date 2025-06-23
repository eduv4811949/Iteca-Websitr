<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][$product['id']] = $product;
    }
    header("Location: index.php");
    exit;
}

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Moekazi - Luxury Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        /* Reset */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0; padding: 0;
            background: linear-gradient(135deg, #2a1a0a, #5a3e1b);
            font-family: 'Poppins', sans-serif;
            color: #f5f1e9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: #3e2f15;
            padding: 50px 20px;
            text-align: center;
            font-family: 'Playfair Display', serif;
            color: #f5d47a;
            text-shadow: 0 0 8px #b3925e;
            font-size: 3.2em;
            letter-spacing: 2px;
            font-weight: 700;
            border-bottom: 2px solid #b3925e;
        }

        .top-bar {
            background: #5a3e1b;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            font-size: 1.05em;
        }

        .top-bar a {
            color: #f5d47a;
            background: transparent;
            border: 2px solid #f5d47a;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 0 15px rgba(245, 212, 122, 0.7);
            transition: background 0.3s ease, color 0.3s ease;
        }

        .top-bar a:hover {
            background: #f5d47a;
            color: #5a3e1b;
            box-shadow: 0 0 30px #f5d47a;
        }

        .landing {
            text-align: center;
            padding: 70px 20px 40px;
            font-family: 'Playfair Display', serif;
        }

        .landing h2 {
            font-size: 3em;
            margin-bottom: 15px;
            color: #f5d47a;
            text-shadow: 1px 1px 4px #3e2f15;
        }

        .landing p {
            max-width: 650px;
            margin: 0 auto;
            font-size: 1.3em;
            line-height: 1.5;
            color: #e3d9b5;
        }

        .landing .cta {
            margin-top: 25px;
            font-weight: 700;
            font-size: 1.3em;
            color: #f5d47a;
            text-shadow: 0 0 8px #b3925e;
        }

        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            padding: 40px 60px 80px;
            flex-grow: 1;
            background: rgba(255 255 255 / 0.05);
            box-shadow: inset 0 0 60px #3e2f15;
        }

        .product {
            background: linear-gradient(145deg, #5a3e1b, #3e2f15);
            border-radius: 16px;
            padding: 25px;
            box-shadow:
                0 0 10px #f5d47a,
                inset 0 0 20px #b3925e;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #f5d47a;
            position: relative;
        }

        .product:hover {
            transform: translateY(-8px);
            box-shadow:
                0 0 25px #f5d47a,
                inset 0 0 30px #b3925e;
            cursor: pointer;
        }

        .product img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 18px;
            box-shadow: 0 0 10px #b3925e;
            border: 1px solid #f5d47a;
        }

        .product h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.5em;
            margin: 10px 0 6px;
            color: #f5d47a;
            text-shadow: 1px 1px 3px #3e2f15;
        }

        .product .desc {
            flex-grow: 1;
            font-size: 1em;
            line-height: 1.4;
            color: #e3d9b5;
            margin-bottom: 15px;
            min-height: 70px;
        }

        .product .price {
            font-weight: 700;
            font-size: 1.3em;
            margin-bottom: 20px;
            color: #f5d47a;
            text-shadow: 0 0 8px #b3925e;
        }

        .product form input[type="submit"] {
            background: #f5d47a;
            border: none;
            color: #3e2f15;
            font-weight: 700;
            font-size: 1em;
            padding: 12px 0;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 0 15px #f5d47a;
            transition: background 0.3s ease, color 0.3s ease;
            letter-spacing: 0.05em;
            user-select: none;
        }

        .product form input[type="submit"]:hover {
            background: #b3925e;
            color: #f5f1e9;
            box-shadow: 0 0 30px #b3925e;
        }

        footer {
            background: #3e2f15;
            color: #b3925e;
            text-align: center;
            padding: 30px 20px;
            font-size: 1em;
            font-family: 'Playfair Display', serif;
            box-shadow: inset 0 2px 10px #5a3e1b;
        }
    </style>
</head>
<body>

<header>
    🛒 Moekazi
</header>

<div class="top-bar">
    <a href="cart.php">🛍 View Cart (<?= count($_SESSION['cart'] ?? []) ?>)</a>
    <a href="admin_products.php">⚙️ Admin Dashboard</a>
</div>

<div class="landing">
    <h2>Welcome to Elegant Shopping</h2>
    <p>Discover premium products handpicked for style, value, and quality. Enjoy a modern shopping experience that blends simplicity with sophistication.</p>
    <p class="cta">Start browsing our exclusive collection below!</p>
</div>

<div class="products-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="product">
            <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" />
            <h2><?= htmlspecialchars($row['name']) ?></h2>
            <p class="desc"><?= htmlspecialchars($row['description']) ?></p>
            <p class="price">$<?= number_format($row['price'], 2) ?></p>
            <form method="post" action="index.php">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>" />
                <input type="submit" value="Add to Cart" />
            </form>
        </div>
    <?php endwhile; ?>
</div>

<footer>
    &copy; <?= date("Y") ?> Style meets simplicity.
</footer>

<script>
    document.querySelectorAll('.product img').forEach(img => {
        img.onerror = () => {
            img.src = 'https://via.placeholder.com/300x200?text=Image+Unavailable';
        };
    });
</script>

</body>
</html>

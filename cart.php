<?php
session_start();

$cart = $_SESSION['cart'] ?? [];

$total = 0;
foreach ($cart as $item) {
    $total += $item['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Your Cart - Moekazi</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        /* Reset */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0; padding: 0;
            background: linear-gradient(135deg, #2a1a0a, #5a3e1b);
            color: #f5f1e9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: #3e2f15;
            padding: 40px 20px;
            text-align: center;
            font-family: 'Playfair Display', serif;
            color: #f5d47a;
            text-shadow: 0 0 8px #b3925e;
            font-size: 3em;
            letter-spacing: 2px;
            font-weight: 700;
            border-bottom: 2px solid #b3925e;
            user-select: none;
        }

        .container {
            background: rgba(255 255 255 / 0.07);
            max-width: 1000px;
            margin: 50px auto 70px;
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow:
                0 10px 30px rgba(0,0,0,0.5),
                inset 0 0 50px #3e2f15;
            color: #e3d9b5;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 14px;
            margin-bottom: 40px;
        }

        thead tr {
            background-color: #5a3e1b;
            color: #f5d47a;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.15em;
            border-radius: 16px;
            box-shadow: 0 0 12px #b3925e;
        }

        thead th {
            padding: 18px 20px;
            text-align: left;
            user-select: none;
        }

        tbody tr {
            background: linear-gradient(145deg, #5a3e1b, #3e2f15);
            box-shadow:
                0 0 15px #b3925e;
            border-radius: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        tbody tr:hover {
            transform: translateY(-6px);
            box-shadow: 0 0 25px #f5d47a;
            cursor: default;
        }

        tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            color: #f5d47a;
            font-weight: 600;
        }

        tbody td img {
            max-width: 80px;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.5);
            border: 1px solid #f5d47a;
        }

        .total-row td {
            background-color: #b3925e;
            color: #3e2f15;
            font-weight: 700;
            font-size: 1.2em;
            border-radius: 16px;
            text-align: right;
            padding-right: 30px;
        }

        .total-row td:last-child {
            text-align: left;
            padding-left: 30px;
        }

        a.button, input[type="submit"] {
            background: #f5d47a;
            color: #3e2f15;
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            border: none;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s ease, color 0.3s ease;
            box-shadow: 0 0 20px #b3925e;
            user-select: none;
            display: inline-block;
            font-size: 1em;
        }

        a.button:hover, input[type="submit"]:hover {
            background: #b3925e;
            color: #f5f1e9;
            box-shadow: 0 0 40px #f5d47a;
        }

        a.button.delete {
            background: #d44a38;
            box-shadow: 0 0 20px #a63828;
        }
        a.button.delete:hover {
            background: #a63828;
            box-shadow: 0 0 40px #d44a38;
        }

        .empty-message {
            font-size: 1.3em;
            text-align: center;
            color: #f5d47a;
            margin: 50px 0;
        }

        .empty-message a.back-link {
            color: #b3925e;
            font-weight: 700;
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: border-color 0.25s ease;
        }
        .empty-message a.back-link:hover {
            border-color: #f5d47a;
        }

        p.back-link-container {
            text-align: center;
            margin-top: 40px;
        }

        a.back-link {
            color: #f5d47a;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            font-size: 1.1em;
            text-decoration: none;
            border-bottom: 1.5px solid transparent;
            transition: border-color 0.3s ease;
            user-select: none;
        }

        a.back-link:hover {
            border-color: #b3925e;
        }

        form {
            margin-bottom: 30px;
        }

        /* Responsive */
        @media (max-width: 700px) {
            .container {
                margin: 30px 20px 50px;
                padding: 30px 25px;
            }

            table, thead tr, tbody tr, th, td {
                display: block;
                width: 100%;
            }

            thead tr {
                display: none;
            }

            tbody tr {
                margin-bottom: 25px;
                border-radius: 20px;
                padding: 20px;
            }

            tbody td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                font-size: 1em;
            }

            tbody td::before {
                position: absolute;
                top: 18px;
                left: 20px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: 700;
                color: #b3925e;
                content: attr(data-label);
                text-align: left;
            }

            tbody td img {
                max-width: 60px;
                position: static;
                margin: 0 auto 12px;
                display: block;
            }

            .total-row td {
                text-align: right !important;
                padding-right: 20px !important;
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>

<header>
    🛒 Your Shopping Cart
</header>

<div class="container">

<?php if (!$cart): ?>
    <p class="empty-message">
        Your cart is empty. <a href="index.php" class="back-link">🛍️ Go Shopping</a>
    </p>
<?php else: ?>

    <form action="clear_cart.php" method="post" onsubmit="return confirm('Clear your entire cart?');" style="text-align:center;">
        <input type="submit" value="🗑️ Clear Cart">
    </form>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $id => $item): ?>
            <tr>
                <td data-label="Image">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" />
                </td>
                <td data-label="Product"><?= htmlspecialchars($item['name']) ?></td>
                <td data-label="Price">$<?= number_format($item['price'], 2) ?></td>
                <td data-label="Action">
                    <a href="remove_from_cart.php?id=<?= $id ?>" class="button delete" onclick="return confirm('Remove this item?')">Remove</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="2" style="text-align:right;">Total:</td>
                <td colspan="2">$<?= number_format($total, 2) ?></td>
            </tr>
        </tbody>
    </table>

    <form action="checkout.php" method="post" style="text-align:center;">
        <input type="submit" value="✅ Proceed to Checkout">
    </form>

<?php endif; ?>

<p class="back-link-container">
    <a href="index.php" class="back-link">⬅ Continue Shopping</a>
</p>

</div>

</body>
</html>

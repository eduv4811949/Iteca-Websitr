<?php
require 'db.php';

$result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - View Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #1e1e2f, #2c3e50);
            color: #f5f5f5;
        }

        header {
            background-color: #141414;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.5);
        }

        header h1 {
            margin: 0;
            font-size: 2.4em;
            color: #f0c674;
            letter-spacing: 1px;
        }

        .container {
            padding: 40px 5%;
        }

        a.button {
            background-color: #f0c674;
            color: #111;
            padding: 12px 22px;
            text-decoration: none;
            font-weight: 600;
            border-radius: 30px;
            display: inline-block;
            margin-bottom: 30px;
            transition: background 0.3s;
        }

        a.button:hover {
            background-color: #e6b844;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            color: #2c3e50;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: #f0c674;
            font-weight: 600;
        }

        tr:hover td {
            background-color: #f9f9f9;
        }

        img {
            max-width: 60px;
            border-radius: 8px;
        }

        td[colspan="12"] {
            background-color: #fff8e1;
            color: #7b5e00;
            text-align: center;
            font-weight: bold;
        }

        footer {
            background-color: #141414;
            text-align: center;
            padding: 20px;
            margin-top: 60px;
            color: #888;
            font-size: 0.95em;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            td {
                position: relative;
                padding-left: 50%;
                border: none;
                border-bottom: 1px solid #ddd;
            }

            td::before {
                position: absolute;
                top: 14px;
                left: 18px;
                width: 45%;
                white-space: nowrap;
                font-weight: bold;
                color: #555;
            }

            td:nth-of-type(1)::before { content: "Order ID"; }
            td:nth-of-type(2)::before { content: "Product"; }
            td:nth-of-type(3)::before { content: "Price"; }
            td:nth-of-type(4)::before { content: "Image"; }
            td:nth-of-type(5)::before { content: "Customer Name"; }
            td:nth-of-type(6)::before { content: "Shipping Address"; }
            td:nth-of-type(7)::before { content: "City"; }
            td:nth-of-type(8)::before { content: "Postal Code"; }
            td:nth-of-type(9)::before { content: "Country"; }
            td:nth-of-type(10)::before { content: "Bank Name"; }
            td:nth-of-type(11)::before { content: "Account Number"; }
            td:nth-of-type(12)::before { content: "Order Date"; }
        }
    </style>
</head>
<body>

<header>
    <h1>📦 Admin Orders Panel</h1>
</header>

<div class="container">
    <a href="admin_products.php" class="button">← Back to Products</a>

    <table>
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Product</th>
            <th>Price</th>
            <th>Image</th>
            <th>Customer</th>
            <th>Address</th>
            <th>City</th>
            <th>Postal</th>
            <th>Country</th>
            <th>Bank</th>
            <th>Account</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td>$<?= number_format($row['price'], 2) ?></td>
                    <td><img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['product_name']) ?>"></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td><?= htmlspecialchars($row['shipping_address']) ?></td>
                    <td><?= htmlspecialchars($row['city']) ?></td>
                    <td><?= htmlspecialchars($row['postal_code']) ?></td>
                    <td><?= htmlspecialchars($row['country']) ?></td>
                    <td><?= htmlspecialchars($row['bank_name']) ?></td>
                    <td><?= htmlspecialchars($row['account_number']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="12">No orders found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<footer>
    &copy; <?= date("Y") ?> Infinity Store Admin. Designed with class.
</footer>

</body>
</html>

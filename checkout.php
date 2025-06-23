<?php
session_start();
require 'db.php';

$cartItems = $_SESSION['cart'] ?? [];
if (empty($cartItems)) {
    header("Location: cart.php");
    exit;
}

$errors = [];
$orderPlaced = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'name' => trim($_POST['name'] ?? ''),
        'address' => trim($_POST['address'] ?? ''),
        'city' => trim($_POST['city'] ?? ''),
        'postal_code' => trim($_POST['postal_code'] ?? ''),
        'country' => trim($_POST['country'] ?? ''),
        'bank_name' => trim($_POST['bank_name'] ?? ''),
        'account_number' => trim($_POST['account_number'] ?? ''),
    ];

    foreach ($formData as $field => $value) {
        if ($value === '') {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . " is required.";
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO orders 
            (product_name, price, image_url, customer_name, shipping_address, city, postal_code, country, bank_name, account_number, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        foreach ($cartItems as $item) {
            $stmt->bind_param(
                "sdssssssss",
                $item['name'],
                $item['price'],
                $item['image_url'],
                $formData['name'],
                $formData['address'],
                $formData['city'],
                $formData['postal_code'],
                $formData['country'],
                $formData['bank_name'],
                $formData['account_number']
            );
            $stmt->execute();
        }

        $_SESSION['cart'] = [];
        $orderPlaced = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f0fff4, #c8e6c9);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .checkout-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 90%;
            animation: slideIn 0.4s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        h1 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 30px;
            margin-bottom: 10px;
            color: #1b5e20;
            border-bottom: 2px solid #a5d6a7;
            padding-bottom: 5px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border 0.3s;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #66bb6a;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            margin-top: 30px;
            padding: 15px;
            font-size: 17px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            background-color: #43a047;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #388e3c;
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: fadeIn 0.4s ease-in;
        }

        .alert-error {
            background-color: #ffcdd2;
            color: #b71c1c;
        }

        .alert-success {
            background-color: #c8e6c9;
            color: #1b5e20;
            text-align: center;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        a.button-link {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            color: #1b5e20;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a.button-link:hover {
            color: #2e7d32;
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @media (max-width: 500px) {
            .checkout-container {
                padding: 25px;
            }

            input[type="submit"] {
                padding: 12px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <h1>🧾 Checkout</h1>

    <?php if ($orderPlaced): ?>
        <div class="alert alert-success">
            <h2>🎉 Order Confirmed!</h2>
            <p>Your order has been placed successfully. Thank you!</p>
            <a href="index.php" class="button-link">← Back to Store</a>
        </div>
    <?php else: ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="checkout.php">
            <h3>🚚 Shipping Information</h3>

            <?php function value($key) { return htmlspecialchars($_POST[$key] ?? ''); } ?>

            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" value="<?= value('name') ?>" required>

            <label for="address">Address</label>
            <input type="text" name="address" id="address" value="<?= value('address') ?>" required>

            <label for="city">City</label>
            <input type="text" name="city" id="city" value="<?= value('city') ?>" required>

            <label for="postal_code">Postal Code</label>
            <input type="text" name="postal_code" id="postal_code" value="<?= value('postal_code') ?>" required>

            <label for="country">Country</label>
            <input type="text" name="country" id="country" value="<?= value('country') ?>" required>

            <h3>🏦 Payment Details</h3>

            <label for="bank_name">Bank Name</label>
            <input type="text" name="bank_name" id="bank_name" value="<?= value('bank_name') ?>" required>

            <label for="account_number">Account Number</label>
            <input type="text" name="account_number" id="account_number" value="<?= value('account_number') ?>" required>

            <input type="submit" value="💳 Place Order">
        </form>

        <a href="cart.php" class="button-link">← Back to Cart</a>

    <?php endif; ?>
</div>

</body>
</html>

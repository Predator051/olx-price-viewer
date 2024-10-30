<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Change Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .price-info {
            font-size: 16px;
            line-height: 1.5;
            color: #555555;
        }

        .price-info strong {
            color: #333333;
        }

        .price-info a {
            color: #1a73e8;
            text-decoration: none;
        }

        .price-info a:hover {
            text-decoration: underline;
        }

        .price-change {
            font-size: 18px;
            color: #d9534f;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999999;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Price Change Notification</h2>
    <div class="price-info">
        <p>We noticed a price change for an item you're tracking:</p>
        <p><strong>Item Link:</strong> <a href="{{ $link }}">{{ $link }}</a></p>
        <p><strong>Old Price:</strong> <span class="price-change">{{ $oldPrice }}</span></p>
        <p><strong>New Price:</strong> <span class="price-change">{{ $newPrice }}</span></p>
    </div>
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</div>
</body>
</html>

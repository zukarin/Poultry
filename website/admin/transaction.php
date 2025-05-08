<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .transaction-container {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        .transaction-info {
            margin-top: 20px;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .info-label {
            color: #555;
        }

        .info-value {
            font-weight: bold;
            color: #333;
        }

        .back-btn {
            margin-top: 20px;
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    <title>Transaction Info</title>
</head>
<body>
    <div class="transaction-container">
        <h2>Transaction Details</h2>
        <div class="transaction-info">
            <div class="info-row">
                <span class="info-label">Transaction ID:</span>
                <span class="info-value">123456789</span>
            </div>
            <div class="info-row">
                <span class="info-label">Amount:</span>
                <span class="info-value">$100.00</span>
            </div>
            <div class="info-row">
                <span class="info-label">Date:</span>
                <span class="info-value">2023-01-01</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value" style="color: #4caf50;">Completed</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Method:</span>
                <span class="info-value">Cash on Delivery (COD)</span>
            </div>
        </div>
        <button class="back-btn" onclick="window.location.href='index.html'">Back to Home</button>
    </div>
</body>
</html>

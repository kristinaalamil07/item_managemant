<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f7f7f7;
            color: #333;
        }
        table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .status {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            color: #fff;
            display: inline-block;
        }
        .status.Pending {
            background-color: orange;
        }
        .status.Confirmed {
            background-color: blue;
        }
        .status.Shipped {
            background-color: purple;
        }
        .status.Delivered {
            background-color: green;
        }
        .status.Paid {
            background-color: darkblue;
        }
        form select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        form button {
            background-color: #5cb85c;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #4cae4c;
        }
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 150px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%; /* Place tooltip above the icon */
            left: 50%;
            margin-left: -75px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body>
    <h1>Order Management</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'db.php';

            $sql = "SELECT o.id, u.name, u.email, o.order_date, o.status, o.total_amount
                    FROM orders o
                    JOIN users u ON o.user_id = u.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($order = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td><span class="status <?php echo htmlspecialchars($order['status']); ?>"><?php echo htmlspecialchars($order['status']); ?></span></td>
                        <td><?php echo htmlspecialchars($order['total_amount']); ?></td>
                        <td>
                            <form method="POST" action="update_status.php">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                <select name="status">
                                    <option value="Pending" <?php if ($order['status'] === 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Confirmed" <?php if ($order['status'] === 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                                    <option value="Shipped" <?php if ($order['status'] === 'Shipped') echo 'selected'; ?>>Shipped</option>
                                    <option value="Delivered" <?php if ($order['status'] === 'Delivered') echo 'selected'; ?>>Delivered</option>
                                    <option value="Paid" <?php if ($order['status'] === 'Paid') echo 'selected'; ?>>Paid</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='7'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

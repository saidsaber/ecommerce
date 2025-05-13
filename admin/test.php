<?php
session_start();
include('../core/config.php');

$query = "SELECT 
            s.shipmentId, s.name, s.email, s.address, s.phone, s.notes, s.status,
            c.cartId, c.count, 
            o.colorName, o.colorHexCode,
            i.sizeName,
            p.productId, p.productName, p.price
          FROM shipment s
          LEFT JOIN cart c ON c.shipmentId = s.shipmentId
          LEFT JOIN products p ON p.productId = c.productId
          LEFT JOIN color o ON o.colorId = c.colorId AND o.productId = p.productId
          LEFT JOIN size i ON i.sizeId = c.sizeId AND i.productId = p.productId
          ORDER BY s.shipmentId ASC;";

$res = mysqli_query($conn, $query);

$shipments = [];
while ($row = mysqli_fetch_assoc($res)) {
    $shipmentId = $row['shipmentId'];

    if (!isset($shipments[$shipmentId])) {
        $shipments[$shipmentId] = [
            'info' => [
                'name' => $row['name'],
                'email' => $row['email'],
                'address' => $row['address'],
                'phone' => $row['phone'],
                'notes' => $row['notes'],
                'status' => $row['status']
            ],
            'items' => []
        ];
    }

    if ($row['cartId']) {
        $shipments[$shipmentId]['items'][] = [
            'productId' => $row['productId'],
            'productName' => $row['productName'],
            'price' => $row['price'],
            'count' => $row['count'],
            'total' => $row['price'] * $row['count'],
            'color' => [
                'name' => $row['colorName'],
                'hexCode' => $row['colorHexCode']
            ],
            'size' => $row['sizeName']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipment Details</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .con {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .ship {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .ship:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .ship h4 {
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .ship p {
            margin-bottom: 8px;
            display: flex;
        }
        .ship p strong {
            min-width: 80px;
            color: #7f8c8d;
        }
        .table-responsive {
            margin-top: 20px;
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table thead th {
            background-color: #3498db;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .table tbody td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table-info td {
            font-weight: bold;
            background-color: #e3f2fd !important;
        }
        .text-right {
            text-align: right;
        }
        .price {
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }
        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-shipped {
            background-color: #d4edda;
            color: #155724;
        }
        .status-delivered {
            background-color: #cce5ff;
            color: #004085;
        }
        .color-box {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
            border: 1px solid #ddd;
        }
        .product-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .product-variants {
            font-size: 0.85em;
            color: #666;
            display: flex;
            gap: 12px;
        }
        @media (max-width: 768px) {
            .ship {
                padding: 15px;
            }
            .table thead {
                display: none;
            }
            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }
            .table tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
            }
            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: calc(50% - 15px);
                padding-right: 15px;
                text-align: left;
                font-weight: bold;
                color: #7f8c8d;
            }
        }
    </style>
</head>
<body>
    <div class="con">
        <?php foreach ($shipments as $shipmentId => $shipment):
            $shipmentTotal = array_reduce($shipment['items'], function ($carry, $item) {
                return $carry + $item['total'];
            }, 0);
            ?>
            <div class="ship" id="ship-<?= $shipmentId ?>">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h4>Shipment #<?= $shipmentId ?></h4>
                    <button onclick="printShipment('ship-<?= $shipmentId ?>')"
                        style="padding: 8px 16px; background-color: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">
                        🖨️ Print
                    </button>
                </div>

                <p><strong>Name:</strong> <?= htmlspecialchars($shipment['info']['name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($shipment['info']['email']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($shipment['info']['address']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($shipment['info']['phone']) ?></p>
                <p><strong>Notes:</strong> <?= htmlspecialchars($shipment['info']['notes']) ?></p>
                <p><strong>Status:</strong> 
                    <span class="status status-<?= strtolower($shipment['info']['status']) ?>">
                        <?= htmlspecialchars($shipment['info']['status']) ?>
                    </span>
                </p>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Product Details</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($shipment['items'] as $index => $item): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <div class="product-details">
                                            <div><?= htmlspecialchars($item['productName']) ?></div>
                                            <div class="product-variants">
                                                <?php if (!empty($item['color']['name'])): ?>
                                                    <span>
                                                        <span class="color-box" style="background-color: <?= htmlspecialchars($item['color']['hexCode']) ?>"></span>
                                                        <?= htmlspecialchars($item['color']['name']) ?>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if (!empty($item['size'])): ?>
                                                    <span>Size: <?= htmlspecialchars($item['size']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= number_format($item['price'], 2) ?> EGP</td>
                                    <td><?= $item['count'] ?></td>
                                    <td><?= number_format($item['total'], 2) ?> EGP</td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="table-info">
                                <td colspan="4" class="text-right"><strong>Shipment Total:</strong></td>
                                <td><strong><?= number_format($shipmentTotal, 2) ?> EGP</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function printShipment(id) {
            const printWindow = window.open('', '_blank');
            const shipment = document.getElementById(id).cloneNode(true);
            
            // Remove the print button from the cloned element
            const printButton = shipment.querySelector('button');
            if (printButton) printButton.remove();
            
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Shipment #${id}</title>
                        <style>
                            body { font-family: Arial, sans-serif; padding: 20px; }
                            h2 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; }
                            p { margin: 8px 0; }
                            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                            th { background-color: #3498db; color: white; padding: 10px; text-align: left; }
                            td { padding: 10px; border-bottom: 1px solid #eee; }
                            .total-row { font-weight: bold; background-color: #f1f1f1; }
                            .color-box { 
                                display: inline-block; 
                                width: 12px; 
                                height: 12px; 
                                border-radius: 50%; 
                                margin-right: 5px; 
                                border: 1px solid #ddd; 
                            }
                            .product-details { margin-bottom: 5px; }
                            .product-variants { font-size: 0.9em; color: #666; }
                        </style>
                    </head>
                    <body>
                        ${shipment.innerHTML}
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        }
    </script>
</body>
</html>
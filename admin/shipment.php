<?php
session_start();
include('../core/config.php');

// استعلام واحد يحصل على كل البيانات المطلوبة
$query = "SELECT 
            s.shipmentId, s.name, s.email, s.address, s.phone, s.notes, s.status,
            c.cartId, c.count,
            p.productId, p.productName, p.price
          FROM shipment s
          LEFT JOIN cart c ON c.shipmentId = s.shipmentId
          LEFT JOIN products p ON p.productId = c.productId
          ORDER BY s.shipmentId ASC";

$res = mysqli_query($conn, $query);

// تجميع البيانات في مصفوفة مرتبة
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

  if ($row['cartId']) { // إذا كان هناك عناصر في السلة
    $shipments[$shipmentId]['items'][] = [
      'productName' => $row['productName'],
      'price' => $row['price'],
      'count' => $row['count'],
      'total' => $row['price'] * $row['count']
    ];
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shipment</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />

  </head>
<style>
  /* Reset وتنسيقات عامة */
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

  /* تنسيق الحاوية الرئيسية */
  .con {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
  }

  /* تنسيق كرت الشحنة */
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

  /* تنسيق معلومات الشحنة */
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

  /* تنسيق الجدول */
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

  /* تنسيق المجموع الكلي */
  .table-info td {
    font-weight: bold;
    background-color: #e3f2fd !important;
  }

  .text-right {
    text-align: right;
  }

  /* تنسيق الأرقام */
  .price {
    font-family: 'Courier New', monospace;
    font-weight: bold;
  }

  /* تنسيق حالة الشحنة */
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

  /* تنسيق للهواتف */
  @media (max-width: 768px) {
    .ship {
      padding: 15px;
    }

    .table thead {
      display: none;
    }

    .table,
    .table tbody,
    .table tr,
    .table td {
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

<body>
  <div class="con">
    <?php foreach ($shipments as $shipmentId => $shipment):
      $shipmentTotal = array_reduce($shipment['items'], function ($carry, $item) {
        return $carry + $item['total'];
      }, 0);
      ?>
      <div class="ship">
        <h4>Shipment #<?= $shipmentId ?></h4>
        <p><strong>Name:</strong> <?= htmlspecialchars($shipment['info']['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($shipment['info']['email']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($shipment['info']['address']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($shipment['info']['phone']) ?></p>
        <p><strong>Notes:</strong> <?= htmlspecialchars($shipment['info']['notes']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($shipment['info']['status']) ?></p>

        <div class="table-responsive mt-3">
          <table class="table table-bordered">
            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($shipment['items'] as $index => $item): ?>
                <tr>
                  <td><?= $index + 1 ?></td>
                  <td><?= htmlspecialchars($item['productName']) ?></td>
                  <td><?= number_format($item['price'], 2) ?> EGP</td>
                  <td><?= $item['count'] ?></td>
                  <td><?= number_format($item['total'], 2) ?> EGP</td>
                </tr>
              <?php endforeach; ?>

              <tr class="table-info">
                <td colspan="4" class="text-right"><strong>Shipment Total:</strong></td>
                <td><strong><?= number_format($shipmentTotal,) ?> EGP</strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- باقي السكربتات كما هي -->
</body>

</html>
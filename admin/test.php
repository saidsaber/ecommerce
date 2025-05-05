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
echo '<pre>';
print_r($shipments);
// exit;
?>
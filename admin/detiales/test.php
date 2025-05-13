<?php 
include("../../core/config.php");

// استعلام منفصل لكل جدول
$queryColors = "SELECT * FROM `color` WHERE productId = 19";
$querySizes = "SELECT * FROM `size` WHERE productId = 19";

$resultColors = mysqli_query($conn, $queryColors);
$resultSizes = mysqli_query($conn, $querySizes);

$data = [
    'color' => [],
    'size' => []
];

// معالجة الألوان
while ($row = mysqli_fetch_assoc($resultColors)) {
    $data['color'][$row['colorId']] = $row;
}

// معالجة المقاسات
while ($row = mysqli_fetch_assoc($resultSizes)) {
    $data['size'][$row['sizeId']] = $row;
}

// echo '<pre>';
// print_r($data);
// <?php
function getBackgroundForText($textColor) {
    list($r, $g, $b) = sscanf($textColor, "#%02x%02x%02x");
    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
    return ($luminance > 0.5) ? '#000000' : '#ffffff';
}

$textColor = '#b6b6ba';
$backgroundColor = getBackgroundForText($textColor);
?>

<div style="color: <?= $textColor ?>; background-color: <?= $backgroundColor ?>; padding: 20px;">
    هذا نص بلون أحمر مع خلفية محسوبة تلقائيًا لضمان أفضل قابلية للقراءة
</div>
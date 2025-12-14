<?php
header('Content-Type: application/json');

// Giả lập kết nối Database thành công
// Sau này sẽ thay đoạn này bằng code mysqli_connect()
$response = [
    "status" => "success",
    "message" => "Xin chào! Đây là dữ liệu từ PHP Backend (Đã Deploy thành công!) 🚀",
    "time" => date("Y-m-d H:i:s")
];

echo json_encode($response);
?>
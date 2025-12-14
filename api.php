<?php
header('Content-Type: application/json');

// Thông tin kết nối (Lấy từ docker-compose.yml)
$host = 'db_mysql'; // Tên service trong docker-compose
$user = 'root';
$pass = 'mysecretpassword';
$db   = 'php_demo_db';

// 1. Kết nối MySQL
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Lỗi kết nối DB: " . $conn->connect_error]));
}

// 2. Tạo bảng mẫu (Nếu chưa có) - Chỉ để test
$sql_create = "CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_create);

// 3. Thêm một dòng dữ liệu mới mỗi khi F5
$conn->query("INSERT INTO visitors () VALUES ()");

// 4. Đếm số lượt truy cập
$result = $conn->query("SELECT COUNT(*) as total FROM visitors");
$row = $result->fetch_assoc();

$response = [
    "status" => "success",
    "message" => "Kết nối Docker MySQL thành công! Tổng số lượt truy cập: " . $row['total'],
    "server_ip" => $_SERVER['SERVER_ADDR']
];

echo json_encode($response);
$conn->close();
?>
<?php
header('Content-Type: application/json');

// Kiểm tra xem đang chạy ở đâu?
// Nếu tên miền chứa chữ 'localhost' -> Đang ở Docker
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    // CẤU HÌNH CHO DOCKER
    $host = 'db_mysql';
    $user = 'root';
    $pass = 'mysecretpassword';
    $db   = 'php_demo_db';
} else {
    // CẤU HÌNH CHO INFINITYFREE (HOSTING)
    // 👉 BẮP ĐIỀN THÔNG TIN LẤY Ở BƯỚC 1 VÀO ĐÂY NHÉ:
    $host = 'sqlXXX.infinityfree.com';  // Thay bằng MySQL Hostname thật
    $user = 'if0_40677408';             // Thay bằng MySQL Username thật
    $pass = 'Sang06092004a';            // Password của bạn
    $db   = 'if0_40677408_demo';        // Thay bằng MySQL Database Name thật
}

// Kết nối MySQL
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    // In ra lỗi cụ thể để debug xem sai ở đâu
    die(json_encode(["status" => "error", "message" => "Lỗi kết nối: " . $conn->connect_error]));
}

// Tạo bảng nếu chưa có (Để Hosting tự tạo bảng luôn)
$sql_create = "CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_create);

// Thêm lượt truy cập
$conn->query("INSERT INTO visitors () VALUES ()");

// Đếm số lượt
$result = $conn->query("SELECT COUNT(*) as total FROM visitors");
if ($result) {
    $row = $result->fetch_assoc();
    $msg = "Thành công! Tổng lượt truy cập: " . $row['total'];
} else {
    $msg = "Kết nối được nhưng chưa lấy được dữ liệu.";
}

$response = [
    "status" => "success",
    "message" => $msg . " (Server: " . $host . ")",
];

echo json_encode($response);
$conn->close();
?>
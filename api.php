    <?php
    header('Content-Type: application/json');

    // --- PHẦN 1: KẾT NỐI DATABASE (GIỮ NGUYÊN LOGIC CŨ) ---
    if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
        // Docker
        $host = 'db_mysql';
        $user = 'root';
        $pass = 'mysecretpassword';
       $db   = 'php_demo_db';
    } else {
        // InfinityFree Hosting (Bắp nhớ thay thông tin thật vào đây nhé)
        $host = 'sql103.infinityfree.com';
        $user = 'if0_40677408';
        $pass = 'Sang06092004a';
        $db   = 'if0_40677408_demo';
    }

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die(json_encode(["status" => "error", "message" => "Lỗi kết nối: " . $conn->connect_error]));
    }

    // --- PHẦN 2: TẠO BẢNG SINH VIÊN (NẾU CHƯA CÓ) ---
    $sql_create = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        dob DATE NOT NULL,
        age INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_create);

    // --- PHẦN 3: XỬ LÝ YÊU CẦU ---

    $method = $_SERVER['REQUEST_METHOD'];

    // Nếu là gửi dữ liệu lên (POST)
    if ($method === 'POST') {
        // Lấy dữ liệu từ form
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $conn->real_escape_string($data['name']);
        $dob  = $data['dob']; // Định dạng YYYY-MM-DD

        // TÍNH TUỔI CHÍNH XÁC
        $bday = new DateTime($dob);
        $today = new DateTime('today');
        $age = $bday->diff($today)->y;

        // Lưu vào DB
        $sql = "INSERT INTO students (name, dob, age) VALUES ('$name', '$dob', $age)";
        
        if ($conn->query($sql)) {
            echo json_encode([
                "status" => "success", 
                "message" => "Đã thêm sinh viên: $name", 
                "age" => $age
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Lỗi SQL: " . $conn->error]);
        }
    } 
    // Nếu là lấy danh sách (GET)
    else {
        $result = $conn->query("SELECT * FROM students ORDER BY id DESC LIMIT 10");
        $students = [];
        while($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        echo json_encode(["status" => "success", "data" => $students]);
    }

    $conn->close();
    ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sinh Viên</title>
    <style>
        body { font-family: sans-serif; background-color: #f0f2f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #0056b3; }
        .result { margin-top: 20px; padding: 15px; background: #e8f5e9; color: #2e7d32; border-radius: 5px; display: none; text-align: center;}
        
        table { width: 100%; margin-top: 30px; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; }
    </style>
</head>
<body>

<div class="container">
    <h1>Thứ 2_Ca 3</h1>
    <h1>Tính Tuổi Sinh Viên</h1>
    
    <div class="form-group">
        <label>Họ và Tên:</label>
        <input type="text" id="name" placeholder="Ví dụ: Nguyễn Văn A">
    </div>
    <div class="form-group">
        <label>Ngày sinh:</label>
        <input type="date" id="dob">
    </div>
    <button onclick="addStudent()">Tính Tuổi & Lưu</button>

    <div id="msgBox" class="result"></div>

    <h3>Danh sách vừa nhập:</h3>
    <table>
        <thead>
            <tr>
                <th>Tên</th>
                <th>Ngày sinh</th>
                <th>Tuổi</th>
            </tr>
        </thead>
        <tbody id="studentList">
            </tbody>
    </table>
</div>

<script>
    // Hàm gửi dữ liệu lên Server
    function addStudent() {
        const name = document.getElementById('name').value;
        const dob = document.getElementById('dob').value;

        if(!name || !dob) {
            alert("Vui lòng nhập đủ thông tin!");
            return;
        }

        fetch('api.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ name: name, dob: dob })
        })
        .then(res => res.json())
        .then(data => {
            const msgBox = document.getElementById('msgBox');
            msgBox.style.display = 'block';
            msgBox.innerText = `${data.message} - Tuổi: ${data.age}`;
            loadStudents(); // Tải lại danh sách
        })
        .catch(err => alert("Lỗi kết nối!"));
    }

    // Hàm lấy danh sách sinh viên
    function loadStudents() {
        fetch('api.php')
        .then(res => res.json())
        .then(res => {
            const tbody = document.getElementById('studentList');
            tbody.innerHTML = '';
            res.data.forEach(st => {
                tbody.innerHTML += `
                    <tr>
                        <td>${st.name}</td>
                        <td>${st.dob}</td>
                        <td><b>${st.age}</b></td>
                    </tr>
                `;
            });
        });
    }

    // Tải danh sách khi mới vào trang
    loadStudents();
</script>

</body>
</html>
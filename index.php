<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP FTP Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Dự án PHP + MySQL</h1>
        <p>Deploy tự động qua FTP với GitHub Actions</p>
        <div id="result" class="box">Đang tải dữ liệu từ API...</div>
    </div>

    <script>
        fetch('api.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').innerText = data.message;
            })
            .catch(error => {
                document.getElementById('result').innerText = "Lỗi kết nối!";
            });
    </script>
</body>
</html>
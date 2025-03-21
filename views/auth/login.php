<?php
require_once '../../config/database.php';
include '../../views/header.php'; // Thêm header
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST['maSV'];




    // Kiểm tra xem sinh viên có tồn tại không
    $query = "SELECT * FROM SinhVien WHERE MaSV = :maSV";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":maSV", $maSV);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $_SESSION['maSV'] = $maSV;
        header("Location: registered_courses.php");
        exit();
    } else {
        $error = "Mã sinh viên không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="../../assets/style.css">
    <style>
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Nút đăng nhập */
        button {
            width: 150px; /* Nhỏ hơn */
            padding: 7px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>ĐĂNG NHẬP</h2>
    <form method="POST">
        <label for="maSV">Mã SV:</label>
        <input type="text" name="maSV" required>
        <button type="submit">Đăng Nhập</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <a href="list.php">Back to List</a>
</body>
</html>

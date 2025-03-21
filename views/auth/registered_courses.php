<?php
require_once '../../config/database.php';
include '../../views/header.php';
session_start();

if (!isset($_SESSION['maSV'])) {
    header("Location: login.php");
    exit();
}

$maSV = $_SESSION['maSV'];

// Truy vấn danh sách môn học sinh viên đã đăng ký
$sql = "
    SELECT hp.MaHP, hp.TenHP, hp.SoTinChi 
    FROM ChiTietDangKy ctdk
    JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP
    JOIN DangKy dk ON ctdk.MaDK = dk.MaDK
    WHERE dk.MaSV = :maSV
    
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':maSV', $maSV, PDO::PARAM_STR);
$stmt->execute();
$registered_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Học Phần</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <h2>Đăng Ký Học Phần</h2>
    <table border="1">
        <tr>
            <th>Mã Học Phần</th>
            <th>Tên Học Phần</th>
            <th>Số Tín Chỉ</th>
            <th>Hành động</th>
        </tr>
        <?php 
        $total_credits = 0;
        $total_courses = count($registered_courses);
        foreach ($registered_courses as $course): 
            $total_credits += $course['SoTinChi'];
        ?>
        <tr>
            <td><?= htmlspecialchars($course['MaHP']) ?></td>
            <td><?= htmlspecialchars($course['TenHP']) ?></td>
            <td><?= htmlspecialchars($course['SoTinChi']) ?></td>
            <td><a href="unregister_course.php?MaHP=<?= $course['MaHP'] ?>">Xóa</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <p><strong>Số học phần:</strong> <?= $total_courses ?></p>
    <p><strong>Tổng số tín chỉ:</strong> <?= $total_credits ?></p>

    <a href="unregister_all.php">Xóa Đăng Ký</a> | 
    <a href="save_registration.php">Lưu đăng ký</a>
</body>
</html>

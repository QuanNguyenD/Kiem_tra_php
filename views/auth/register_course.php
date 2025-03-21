<?php
require_once '../../config/database.php';
include '../../views/header.php'; // Thêm header
session_start();

if (!isset($_SESSION['maSV'])) {
    header("Location: login.php");
    exit();
}

$maSV = $_SESSION['maSV'];

if (isset($_GET['MaHP'])) {
    $MaHP = $_GET['MaHP'];

    try {
        // Kiểm tra xem sinh viên đã có bản ghi trong bảng DangKy chưa
        $sql = "SELECT MaDK FROM DangKy WHERE MaSV = :MaSV";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':MaSV', $MaSV, PDO::PARAM_STR);
        $stmt->execute();
        $MaDK = $stmt->fetchColumn();

        // Nếu chưa có, tạo mới một bản ghi đăng ký
        if (!$MaDK) {
            $sql = "INSERT INTO DangKy (MaSV, NgayDK) VALUES (:MaSV, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':MaSV', $MaSV, PDO::PARAM_STR);
            $stmt->execute();
            $MaDK = $conn->lastInsertId();
        }

        // Kiểm tra xem môn học đã được đăng ký chưa
        $sql = "SELECT COUNT(*) FROM ChiTietDangKy WHERE MaDK = :MaDK AND MaHP = :MaHP";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':MaDK', $MaDK, PDO::PARAM_INT);
        $stmt->bindParam(':MaHP', $MaHP, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            // Nếu chưa đăng ký, thêm vào bảng ChiTietDangKy
            $sql = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (:MaDK, :MaHP)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':MaDK', $MaDK, PDO::PARAM_INT);
            $stmt->bindParam(':MaHP', $MaHP, PDO::PARAM_STR);
            $stmt->execute();
        }

        // Chuyển hướng đến trang registered_courses.php
        header("Location: registered_courses.php");
        exit();

    } catch (PDOException $e) {
        die("Lỗi truy vấn: " . $e->getMessage());
    }
} else {
    echo "Mã học phần không hợp lệ.";
}


?>
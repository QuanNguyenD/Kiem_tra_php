<?php
require_once '../../config/database.php';
session_start();

// Kiểm tra sinh viên đã đăng nhập chưa
if (!isset($_SESSION['maSV'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra xem có MaHP được truyền không
if (!isset($_GET['MaHP'])) {
    echo "Lỗi: Không có Mã Học Phần để xóa.";
    exit();
}

$maSV = $_SESSION['maSV'];
$maHP = $_GET['MaHP'];

try {
    // Kiểm tra kết nối
    if (!$conn) {
        throw new Exception("Lỗi kết nối CSDL.");
    }

    // Truy vấn lấy MaDK của sinh viên hiện tại
    $sql = "SELECT MaDK FROM DangKy WHERE MaSV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maSV]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "Lỗi: Không tìm thấy đăng ký của sinh viên.";
        exit();
    }

    $maDK = $row['MaDK'];

    // Xóa học phần trong bảng ChiTietDangKy
    $sql_delete = "DELETE FROM ChiTietDangKy WHERE MaDK = ? AND MaHP = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->execute([$maDK, $maHP]);

    // Quay lại trang danh sách học phần đã đăng ký
    header("Location: registered_courses.php");
    exit();
} catch (PDOException $e) {
    echo "Lỗi CSDL: " . $e->getMessage();
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>

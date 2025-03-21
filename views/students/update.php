<?php
require_once '../../config/database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Kiểm tra nếu có upload hình mới
    if (!empty($_FILES['Hinh']['name'])) {
        $Hinh = $_FILES['Hinh']['name'];
        $target_dir = "../../assets/images/";
        $target_file = $target_dir . basename($Hinh);
        move_uploaded_file($_FILES['Hinh']['tmp_name'], $target_file);
    } else {
        $Hinh = $_POST['current_image'] ?? ''; // Giữ nguyên hình cũ nếu không có hình mới
    }

    // Cập nhật thông tin sinh viên
    $query = "UPDATE SinhVien SET HoTen = :HoTen, GioiTinh = :GioiTinh, NgaySinh = :NgaySinh, Hinh = :Hinh, MaNganh = :MaNganh WHERE MaSV = :MaSV";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':HoTen', $HoTen);
    $stmt->bindParam(':GioiTinh', $GioiTinh);
    $stmt->bindParam(':NgaySinh', $NgaySinh);
    $stmt->bindParam(':Hinh', $Hinh);
    $stmt->bindParam(':MaNganh', $MaNganh);
    $stmt->bindParam(':MaSV', $MaSV);

    if ($stmt->execute()) {
        header("Location: list.php");
        exit();
    } else {
        echo "Có lỗi xảy ra khi cập nhật!";
    }
}
?>

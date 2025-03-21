<?php
require_once '../../config/database.php';


if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];

    // Kiểm tra sinh viên có tồn tại không
    $checkQuery = "SELECT * FROM SinhVien WHERE MaSV = :MaSV";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(':MaSV', $MaSV);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // Nếu tồn tại, tiến hành xóa
        $deleteQuery = "DELETE FROM SinhVien WHERE MaSV = :MaSV";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bindParam(':MaSV', $MaSV);

        if ($deleteStmt->execute()) {
            echo "<script>
                    alert('Xóa sinh viên thành công!');
                    window.location.href='list.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Lỗi khi xóa sinh viên!');
                    window.location.href='list.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Sinh viên không tồn tại!');
                window.location.href='list.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Thiếu thông tin MaSV!');
            window.location.href='list.php';
          </script>";
}
?>

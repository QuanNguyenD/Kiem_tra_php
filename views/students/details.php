<?php
require_once '../../config/database.php';
include '../../views/header.php'; // Thêm header



if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];

    // Truy vấn lấy thông tin sinh viên
    $query = "SELECT sv.MaSV, sv.HoTen, sv.GioiTinh, sv.NgaySinh, sv.Hinh, nh.TenNganh 
              FROM SinhVien sv 
              JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh
              WHERE sv.MaSV = :MaSV";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "<script>
                alert('Sinh viên không tồn tại!');
                window.location.href='list.php';
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Thiếu thông tin MaSV!');
            window.location.href='list.php';
          </script>";
    exit();
}
?>

<div class="container">
    <h2>Thông tin chi tiết</h2>
    <style>
        .container {
    width: 60%;
    margin: 0 auto;
}

h2 {
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.table th {
    background-color:rgb(39, 91, 143);
}

img {
    display: block;
    margin: 10px 0;
    border-radius: 8px;
}

.btn {
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 5px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color:rgb(9, 56, 97);
    color: white;
}

    </style>
    <table class="table table-bordered">
        <tr>
            <th>Họ Tên</th>
            <td><?= htmlspecialchars($student['HoTen']) ?></td>
        </tr>
        <tr>
            <th>Giới Tính</th>
            <td><?= htmlspecialchars($student['GioiTinh']) ?></td>
        </tr>
        <tr>
            <th>Ngày Sinh</th>
            <td><?= htmlspecialchars($student['NgaySinh']) ?></td>
        </tr>
        <tr>
            <th>Hình</th>
            <td>
                <img src="../../assets/<?= htmlspecialchars($student['Hinh']) ?>" width="150" alt="Student Image">
            </td>
        </tr>
        <tr>
            <th>Ngành</th>
            <td><?= htmlspecialchars($student['TenNganh']) ?></td>
        </tr>
    </table>
    <a href="edit.php?MaSV=<?= $student['MaSV'] ?>" class="btn btn-primary">Edit</a>
    <a href="list.php" class="btn btn-secondary">Back to List</a>
</div>

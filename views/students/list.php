<?php
require_once '../../config/database.php';
include '../../views/header.php'; // Thêm header



$query = "SELECT sv.MaSV, sv.HoTen, sv.GioiTinh, sv.NgaySinh, sv.Hinh, nh.TenNganh 
          FROM SinhVien sv 
          JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh";
$stmt = $conn->prepare($query);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>TRANG SINH VIÊN</h2>
    <div class="d-flex justify-content-between mb-3">
        <div></div> <!-- Để căn giữa button -->
        <a href="add.php" class="btn btn-success">+ Add Student</a>
    </div>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>MaSV</th>
                <th>HoTen</th>
                <th>GioiTinh</th>
                <th>NgaySinh</th>
                <th>Hình</th>
                <th>MaNganh</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['MaSV']) ?></td>
                    <td><?= htmlspecialchars($student['HoTen']) ?></td>
                    <td><?= htmlspecialchars($student['GioiTinh']) ?></td>
                    <td><?= htmlspecialchars($student['NgaySinh']) ?></td>
                    <td>
                        <img src="../../assets/<?= htmlspecialchars($student['Hinh']) ?>" width="80" alt="Student Image">
                    </td>
                    <td><?= htmlspecialchars($student['TenNganh']) ?></td>
                    <td>
                        <a href="edit.php?MaSV=<?= $student['MaSV'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="details.php?MaSV=<?= $student['MaSV'] ?>" class="btn btn-info btn-sm">Details</a>
                        <a href="delete.php?MaSV=<?= $student['MaSV'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



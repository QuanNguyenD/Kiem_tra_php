<?php
require_once '../../config/database.php';
include '../../views/header.php'; // Thêm header



// Truy vấn lấy danh sách học phần
$query = "SELECT MaHP, TenHP, SoTinChi FROM HocPhan";
$stmt = $conn->prepare($query);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>DANH SÁCH HỌC PHẦN</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã Học Phần</th>
                <th>Tên Học Phần</th>
                <th>Số Tín Chỉ</th>
                <th>Đăng Kí</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= htmlspecialchars($course['MaHP']) ?></td>
                    <td><?= htmlspecialchars($course['TenHP']) ?></td>
                    <td><?= htmlspecialchars($course['SoTinChi']) ?></td>
                    <td>
                        <a href="../auth/register_course.php?MaHP=<?php echo urlencode($course['MaHP']); ?>" class="btn btn-success">Đăng ký</a>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<?php
require_once '../../config/database.php';
include '../../views/header.php'; // Thêm header


// Kiểm tra nếu có MaSV trên URL
if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];

    // Truy vấn thông tin sinh viên theo MaSV
    $query = "SELECT * FROM SinhVien WHERE MaSV = :MaSV";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "Không tìm thấy sinh viên!";
        exit;
    }
} else {
    echo "Mã sinh viên không hợp lệ!";
    exit;
}
?>

<h2>Hiệu chỉnh thông tin sinh viên</h2>
<style>
    form {
    width: 50%;
    margin: 20px auto;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

label {
    font-weight: bold;
    margin-top: 10px;
    display: block;
}

input, select {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    padding: 10px 15px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    border-radius: 5px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    display: inline-block;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

</style>

<form action="update.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MaSV" value="<?= htmlspecialchars($student['MaSV']) ?>">

    <label>Họ Tên:</label>
    <input type="text" name="HoTen" value="<?= htmlspecialchars($student['HoTen']) ?>" required><br>

    <label>Giới Tính:</label>
    <select name="GioiTinh" required>
        <option value="Nam" <?= $student['GioiTinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
        <option value="Nữ" <?= $student['GioiTinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
    </select><br>

    <label>Ngày Sinh:</label>
    <input type="date" name="NgaySinh" value="<?= htmlspecialchars($student['NgaySinh']) ?>" required><br>

    <label>Hình:</label>
    <input type="file" name="Hinh" accept="image/*"><br>
    <?php if ($student['Hinh']) : ?>
        <img src="../../assets/<?= htmlspecialchars($student['Hinh']) ?>" width="100" alt="Student Image"><br>
    <?php endif; ?>

    <label>Mã Ngành:</label>
    <select name="MaNganh" required>
        <?php
        // Lấy danh sách ngành học
        $query = "SELECT * FROM NganhHoc";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $majors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($majors as $major) {
            $selected = ($student['MaNganh'] == $major['MaNganh']) ? 'selected' : '';
            echo "<option value='{$major['MaNganh']}' $selected>{$major['TenNganh']}</option>";
        }
        ?>
    </select><br>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="list.php" class="btn btn-secondary">Back to List</a>
</form>



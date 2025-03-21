<?php
require_once '../../config/database.php';
include '../../views/header.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];
    $Hinh = '';

    // Xử lý upload ảnh
    if (!empty($_FILES["Hinh"]["name"])) {
        $target_dir = "../../assets/images/";
        $Hinh = basename($_FILES["Hinh"]["name"]);
        $target_file = $target_dir . $Hinh;
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file);
    }

    // Chèn dữ liệu vào database
    $query = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
              VALUES (:MaSV, :HoTen, :GioiTinh, :NgaySinh, :Hinh, :MaNganh)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->bindParam(':HoTen', $HoTen);
    $stmt->bindParam(':GioiTinh', $GioiTinh);
    $stmt->bindParam(':NgaySinh', $NgaySinh);
    $stmt->bindParam(':Hinh', $Hinh);
    $stmt->bindParam(':MaNganh', $MaNganh);

    if ($stmt->execute()) {
        echo "<script>alert('Thêm sinh viên thành công!'); window.location.href='list.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!');</script>";
    }
}
?>

<h2>THÊM SINH VIÊN</h2>
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

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-success:hover {
    background-color: #218838;
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
<form action="add.php" method="post" enctype="multipart/form-data">
    <label>MaSV:</label>
    <input type="text" name="MaSV" required><br>

    <label>Ho Ten:</label>
    <input type="text" name="HoTen" required><br>

    <label>Gioi Tinh:</label>
    <select name="GioiTinh">
        <option value="Nam">Nam</option>
        <option value="Nữ">Nữ</option>
    </select><br>

    <label>Ngay Sinh:</label>
    <input type="date" name="NgaySinh" required><br>

    <label>Hinh:</label>
    <input type="file" name="Hinh" accept="image/*"><br>

    <label>Ma Nganh:</label>
    <select name="MaNganh" required>
        <?php
        // Lấy danh sách ngành học từ database
        $query = "SELECT * FROM NganhHoc";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $majors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($majors as $major) {
            echo "<option value='" . $major['MaNganh'] . "'>" . $major['TenNganh'] . "</option>";
        }
        ?>
    </select><br>

    <button type="submit" class="btn btn-success">Create</button>
    <a href="list.php" class="btn btn-secondary">Back to List</a>
</form>




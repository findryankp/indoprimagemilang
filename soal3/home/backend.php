<?php
include '../configs/db.php';

$conn = connectToDatabase();
// Fetch data from the database with tenure calculation
$query = "SELECT Nama_Dept as Department, Nama, DATEDIFF(NOW(), Tanggal_Masuk) AS Masa_Kerja, Kota_Penempatan FROM KARYAWAN,DEPARTMENT where DEPARTMENT.IDDept = KARYAWAN.Department order by Masa_Kerja DESC";
$result = $conn->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the database connection
$conn->close();

// Return data as JSON
echo json_encode(['data' => $data]);
?>

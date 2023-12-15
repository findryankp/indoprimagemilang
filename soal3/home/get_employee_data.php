<?php
include '../configs/db.php';

$conn = connectToDatabase();

// Fetch employee birthday data
$query = "SELECT IDKaryawan as id,Nama, Tanggal_lahir, Department, Telp FROM KARYAWAN";
$result = $conn->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'id' =>$row['id'],
        'title' => $row['Nama'],
        'start' => $row['Tanggal_lahir'],
        'department' => $row['Department'],
        'phone' => $row['Telp']
    );
}

// Close the database connection
$conn->close();

// Return data as JSON
echo json_encode($data);
?>

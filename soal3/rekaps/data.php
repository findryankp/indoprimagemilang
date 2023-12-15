<?php

include '../configs/db.php';

function fetchDataFromDatabase() {
    $conn = connectToDatabase();

    $sql = "SELECT DEPARTMENT.Nama_Dept,KARYAWAN.Kota_Penempatan, COUNT(KARYAWAN.IDKaryawan) AS TotalEmployees
            FROM DEPARTMENT
            INNER JOIN KARYAWAN ON DEPARTMENT.IDDept = KARYAWAN.Department
            GROUP BY DEPARTMENT.IDDept,KARYAWAN.Kota_Penempatan";

    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();

    return $data;
}

echo json_encode(fetchDataFromDatabase());

?>

<?php
include '../configs/db.php';

$conn = connectToDatabase();

if (isset($_GET['id'])) {
    // Sanitize the input
    $employeeId = $conn->real_escape_string($_GET['id']);

    $query = "SELECT * FROM KARYAWAN WHERE IDKaryawan = '$employeeId'";
    error_log($query.$employeeId);
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<p><strong>Name:</strong> " . $row['Nama'] . "</p>";
            echo "<p><strong>ID Card:</strong> " . $row['NoKTP'] . "</p>";
            echo "<p><strong>Phone:</strong> " . $row['Telp'] . "</p>";
            echo "<p><strong>Birthdate:</strong> " . $row['Tanggal_lahir'] . "</p>";
            echo "<p><strong>Placement:</strong> " . $row['Kota_Penempatan'] . "</p>";
        } else {
            echo "Employee not found.";
        }
    } else {
        // Handle query error
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid input.";
}

$conn->close();
?>

<?php
include '../configs/db.php';

// Use the connectToDatabase function to establish a connection
$conn = connectToDatabase();

// Function to add or edit employee
function addEditEmployee($employeeID, $employeeName, $employeeKTP, $employeePhone, $employeeCity, $employeeDOB, $employeeJoinDate, $employeeDepartment, $employeePlacementCity) {
    global $conn;

    try {
        if (empty($employeeID)) {
            $stmt = $conn->prepare("INSERT INTO KARYAWAN (Nama, NoKTP, Telp, Kota_Tinggal, Tanggal_lahir, Tanggal_Masuk, Department, Kota_Penempatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssssss', $employeeName, $employeeKTP, $employeePhone, $employeeCity, $employeeDOB, $employeeJoinDate, $employeeDepartment, $employeePlacementCity);
        } else {
            $stmt = $conn->prepare("UPDATE KARYAWAN SET Nama = ?, NoKTP = ?, Telp = ?, Kota_Tinggal = ?, Tanggal_lahir = ?, Tanggal_Masuk = ?, Department = ?, Kota_Penempatan = ? WHERE IDKaryawan = ?");
            $stmt->bind_param('ssssssssi', $employeeName, $employeeKTP, $employeePhone, $employeeCity, $employeeDOB, $employeeJoinDate, $employeeDepartment, $employeePlacementCity, $employeeID);
        }

        $stmt->execute();

        return ['success' => true];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

// Function to check duplicate employee ID card number
function checkDuplicateEmployee($employeeID, $employeeKTP) {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM KARYAWAN WHERE NoKTP = ? AND IDKaryawan != ?");
        $stmt->bind_param('ss', $employeeKTP, $employeeID);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return ['isDuplicate' => $count > 0];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

// error_log($_GET["action"]);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Check if the key "employeeKTP" exists in the $_POST array
        $employeeKTP = isset($_POST["employeeKTP"]) ? htmlspecialchars($_POST["employeeKTP"]) : null;

        $employeeID = $_POST["employeeID"];
        $employeeName = htmlspecialchars($_POST["employeeName"]);
        $employeePhone = htmlspecialchars($_POST["employeePhone"]);
        $employeeCity = htmlspecialchars($_POST["employeeCity"]);
        $employeeDOB = htmlspecialchars($_POST["employeeDOB"]);
        $employeeJoinDate = htmlspecialchars($_POST["employeeJoinDate"]);
        $employeeDepartment = htmlspecialchars($_POST["employeeDepartment"]);
        $employeePlacementCity = htmlspecialchars($_POST["employeePlacementCity"]);

        // Implement validation for unique ID card number
        $duplicateResult = checkDuplicateEmployee($employeeID, $employeeKTP);
        if ($duplicateResult['isDuplicate']) {
            echo json_encode(['success' => false, 'message' => 'ID card number already exists. Please choose a different one.']);
            exit();
        }

        // Add or edit employee
        echo json_encode(addEditEmployee($employeeID, $employeeName, $employeeKTP, $employeePhone, $employeeCity, $employeeDOB, $employeeJoinDate, $employeeDepartment, $employeePlacementCity));
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Unexpected error: ' . $e->getMessage()]);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && $_GET["action"] == "checkDuplicate") {
    $employeeID = htmlspecialchars($_GET["employeeID"]);
    $employeeKTP = htmlspecialchars($_GET["employeeKTP"]);

    // Check duplicate employee ID card number
    echo json_encode(checkDuplicateEmployee($employeeID, $employeeKTP));
}elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && $_GET["action"] == "getEmployee") {
    $employeeID = htmlspecialchars($_GET["employeeID"]);

    try {
        $stmt = $conn->prepare("SELECT * FROM KARYAWAN WHERE IDKaryawan = ?");
        $stmt->bind_param('i', $employeeID); // Assuming IDKaryawan is an integer, adjust if necessary
        $stmt->execute();
        $result = $stmt->get_result();
        $employeeData = $result->fetch_assoc();
        $stmt->close();

        echo json_encode(['success' => true, 'employeeData' => $employeeData]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
}elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && $_GET["action"] == "deleteEmployee") {
    $employeeID = htmlspecialchars($_GET["employeeID"]);
    try {
        $stmt = $conn->prepare("DELETE FROM KARYAWAN WHERE IDKaryawan = ?");
        $stmt->bind_param('i', $employeeID);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
}else {
    try {
        // Use a different approach to fetch results using a while loop
        $result = $conn->query("SELECT * FROM KARYAWAN");

        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }

        echo json_encode($employees);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching employee data: ' . $e->getMessage()]);
    }
}
?>

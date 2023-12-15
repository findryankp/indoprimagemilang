<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

include '../configs/db.php';

// Use the connectToDatabase function to establish a connection
$conn = connectToDatabase();

// Function to add or edit department
function addEditDepartment($deptID, $deptName) {
    global $conn;

    try {
        if (empty($deptID)) {
            $stmt = $conn->prepare("INSERT INTO DEPARTMENT (Nama_Dept) VALUES (?)");
            $stmt->bind_param("s", $deptName);
        } else {
            $stmt = $conn->prepare("UPDATE DEPARTMENT SET Nama_Dept = ? WHERE IDDept = ?");
            $stmt->bind_param("si", $deptName, $deptID);
        }

        $stmt->execute();

        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

// Function to check for duplicate department names
function isDuplicateDeptName($deptName, $currentDeptID = null) {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM DEPARTMENT WHERE Nama_Dept = ? AND IDDept != ?");
        $stmt->bind_param("si", $deptName, $currentDeptID);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc()['COUNT(*)'] > 0;
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

// Function to check if there are employees in the department
function hasEmployees($deptID) {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM EMPLOYEE WHERE IDDept = ?");
        $stmt->bind_param("i", $deptID);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc()['COUNT(*)'] > 0;
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

// Function to delete department
function deleteDepartment($deptID) {
    global $conn;

    try {
        $stmt = $conn->prepare("DELETE FROM DEPARTMENT WHERE IDDept = ?");
        $stmt->bind_param("i", $deptID);
        $stmt->execute();

        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deptID = $_POST["deptID"];
    $deptName = $_POST["deptName"];

    // Add validation for duplicate department names
    if (isDuplicateDeptName($deptName, $deptID)) {
        echo json_encode(['success' => false, 'message' => 'Department name already exists..']);
        exit();
    }

    // Add or edit department
    echo json_encode(addEditDepartment($deptID, $deptName));
}

// Handle department deletion
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && $_GET["action"] == "delete") {
    $deptID = $_GET["deptID"];

    // Check if there are employees in the department before deleting
    if (!hasEmployees($deptID)) {
        // Delete department
        echo json_encode(deleteDepartment($deptID));
    } else {
        // Return a message indicating that the department has employees
        echo json_encode(['success' => false, 'message' => 'Unable to delete. Department has employees.']);
    }
} else {
    // Return department list for GET requests
    try {
        // Use a different approach to fetch results using a while loop
        $result = $conn->query("SELECT * FROM DEPARTMENT");

        $departments = [];
        while ($row = $result->fetch_assoc()) {
            $departments[] = $row;
        }

        echo json_encode($departments);
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

?>

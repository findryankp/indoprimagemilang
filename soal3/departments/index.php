<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Management</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS link -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Indo Prima Gemilang</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/soal3/home">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/soal3/departments">Department</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/soal3/karyawans">Employee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/soal3/rekaps">Rekaps</a>
            </li>
        </ul>
    </div>
</nav>

    <div class="container mt-4">
        <h2 class="mb-4">Department Management</h2>

        <!-- Form untuk menambah atau mengedit department -->
        <form id="deptForm">
            <div class="form-group">
                <label for="deptName">Department Name:</label>
                <input type="text" class="form-control" id="deptName" name="deptName" required>
            </div>

            <input type="hidden" id="deptID" name="deptID">

            <button type="button" class="btn btn-primary" onclick="addEditDepartment()">Save</button>
        </form>

        <!-- Daftar department -->
        <h3 class="mt-4">Department List</h3>
        <table class="table" id="deptList">
            <thead>
                <tr>
                    <th>Department Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Bootstrap JS and Popper.js script -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DataTables JS scripts -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="./departments/script.js"></script>
</body>
</html>

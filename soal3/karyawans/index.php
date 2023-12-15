<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- jQuery and DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
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
            <li class="nav-item">
                <a class="nav-link" href="/soal3/departments">Department</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/soal3/karyawans">Employee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/soal3/rekaps">Rekaps</a>
            </li>
        </ul>
    </div>
</nav>

    <div class="container mt-5">
        <h2>Employee Management</h2>

        <form id="employeeForm" class="mt-4">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="employeeName">Employee Name:</label>
                    <input type="text" class="form-control" id="employeeName" name="employeeName" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="employeeKTP">ID Card Number:</label>
                    <input type="text" class="form-control" id="employeeKTP" name="employeeKTP" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="employeePhone">Phone:</label>
                    <input type="text" class="form-control" id="employeePhone" name="employeePhone">
                </div>

                <div class="form-group col-md-6">
                    <label for="employeeCity">City of Residence:</label>
                    <input type="text" class="form-control" id="employeeCity" name="employeeCity">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="employeeDOB">Date of Birth:</label>
                    <input type="date" class="form-control" id="employeeDOB" name="employeeDOB" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="employeeJoinDate">Join Date:</label>
                    <input type="date" class="form-control" id="employeeJoinDate" name="employeeJoinDate" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="employeeDepartment">Department:</label>
                    <select class="form-control" id="employeeDepartment" name="employeeDepartment" required>
                        <!-- Department options will be populated dynamically -->
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="employeePlacementCity">Placement City:</label>
                    <input type="text" class="form-control" id="employeePlacementCity" name="employeePlacementCity">
                </div>
            </div>

            <input type="hidden" id="employeeID" name="employeeID">

            <button type="button" onclick="addEditEmployee()" class="btn btn-primary">Save</button>
        </form>


        <!-- Employee List -->
        <h3>Employee List</h3>
        <table id="employeeDataTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ID Card Number</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Date of Birth</th>
                    <th>Join Date</th>
                    <th>Department</th>
                    <th>Placement City</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="employeeListBody"></tbody>
        </table>
    </div>

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Your script.js file -->
    <script src="./karyawans/script.js"></script>
</body>
</html>

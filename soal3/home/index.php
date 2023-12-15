<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Work Tenure Report</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="/">Indo Prima Gemilang</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/soal3/home">Home</a>
            </li>
            <li class="nav-item">
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

<div class="container mt-5">
    <div class="row">
        <h1 class="col-12 text-center">Employee Table</h1>
    </div>
    <table id="employeeTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Department</th>
                <th>Kota Penempatan</th>
                <th>Masa Kerja</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="container mt-5">
    <div class="row">
        <h1 class="col-12 text-center">Calendar Employee</h1>
    </div>
    <div id="calendar"></div>
</div>

<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeModalLabel">Employee Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="employeeDetails">
                <!-- Employee details will be displayed here -->
            </div>
        </div>
    </div>
</div>

<!-- Add DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        // DataTable initialization
        var table = $('#employeeTable').DataTable({
            "ajax": "./home/backend.php", // PHP script to fetch data
            "columns": [
                { "data": null, render: function (data, type, row, meta) { return meta.row + 1; } },
                { "data": "Nama" },
                { "data": "Department" },
                { "data": "Kota_Penempatan" },
                { "data": "Masa_Kerja" }
            ],
            "dom": 'Bfrtip', // Show export button
            "buttons": ['excel'] // Show only Excel export button
        });
    });

    $(document).ready(function () {
        // Initialize FullCalendar
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: {
                // Populate the events array with data from the server
                url: './home/get_employee_data.php',
                method: 'GET',
                extraParams: {},
                failure: function () {
                    alert('There was an error while fetching events!');
                },
            },
            eventClick: function (info) {
                // Display employee details in a modal on event click
                $.ajax({
                    url: './home/calendar_backend.php',
                    type: 'GET',
                    data: { id: info.event.id },
                    success: function (response) {
                        $('#employeeDetails').html(response);
                        $('#employeeModal').modal('show');
                    }
                });
            }
        });

        // Render the calendar
        calendar.render();
    });


</script>

</body>
</html>

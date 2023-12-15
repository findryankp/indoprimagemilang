<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Employee Summary</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            <li class="nav-item">
                <a class="nav-link" href="/soal3/karyawans">Employee</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/soal3/rekaps">Rekaps</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <h2 class="text-center mb-4">Employee Summary</h2>
    <div id="employeeSummary" class="table-responsive">
        <!-- Add "table" class to make the table responsive -->
        <table class="table table-striped table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Department</th>
                    <th>Total Employees</th>
                    <th>Penempatan</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    $.ajax({
        url: 'rekaps/data.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            displayEmployeeSummary(data);
        },
        error: function () {
            console.error('Error fetching data from the server.');
        }
    });
});

function displayEmployeeSummary(data) {
    var table = '<table class="table">';
    var kota = [];
    
    // Extract unique city names
    for (var i = 0; i < data.length; i++) {
        if (!kota.includes(data[i].Kota_Penempatan)) {
            kota.push(data[i].Kota_Penempatan);
        }
    }

    table += '<thead><tr><th>#</th>';
    
    // Create header row with city names
    for (var i = 0; i < kota.length; i++) {
        table += `<th>${kota[i]}</th>`;
    }
    
    table += '</tr></thead>';
    
    table += '<tbody>';
    
    // Loop through departments
    for (var i = 0; i < data.length; i++) {
        table += '<tr>';
        table += `<td><b>${data[i].Nama_Dept}</b></td>`;
        
        // Loop through cities
        for (var j = 0; j < kota.length; j++) {
            // Find matching department and city combination
            var matchingEmployee = data.find(emp => emp.Nama_Dept === data[i].Nama_Dept && emp.Kota_Penempatan === kota[j]);
            
            if (matchingEmployee) {
                table += `<td>${matchingEmployee.TotalEmployees}</td>`;
            } else {
                table += '<td>0</td>';
            }
        }
        
        table += '</tr>';
    }

    table += '</tbody></table>';

    $('#employeeSummary').html(table);
}

</script>

</body>
</html>
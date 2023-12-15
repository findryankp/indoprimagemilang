let gDepart;

$(document).ready(function () {
    // Load existing employees and departments
    loadDepartments();
    loadEmployees();

    // Add event listener for form submission
    $('#employeeForm').submit(function (event) {
        event.preventDefault();
        addEditEmployee();
    });
});

// Function to add or edit employee
function addEditEmployee() {
    var employeeID = $('#employeeID').val();
    var employeeName = $('#employeeName').val();
    var employeeKTP = $('#employeeKTP').val();
    var employeePhone = $('#employeePhone').val();
    var employeeCity = $('#employeeCity').val();
    var employeeDOB = $('#employeeDOB').val();
    var employeeJoinDate = $('#employeeJoinDate').val();
    var employeeDepartment = $('#employeeDepartment').val();
    var employeePlacementCity = $('#employeePlacementCity').val();

    // Implement validation for unique ID card number
    checkDuplicateEmployee(employeeID, employeeKTP, function (result) {
        if (result.isDuplicate) {
            Swal.fire({
                icon: 'info',
                title: 'Data Already Exist',
                text: '-',
            });
            return;
        }

        // Implement logic to add or edit employee in the database
        var formData = new FormData($('#employeeForm')[0]);
        $.ajax({
            url: './karyawans/employee_backend.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data)
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Employee data has been added/edited successfully.',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Employee data has been added/edited successfully.',
                    });
                }
                loadEmployees();
                clearEmployeeForm();
            },
            error: function (error) {
                console.error('Error in AJAX call:', error);
            }
        });
    });
}

function loadEmployees() {
    // Fetch employee data from the PHP backend
    $.getJSON('./karyawans/employee_backend.php', function (data) {
        // Clear existing DataTable and recreate it with the updated data
        $('#employeeDataTable').DataTable().clear().destroy();

        // Populate the DataTable with employee data
        $('#employeeDataTable').DataTable({
            data: data,
            columns: [
                { data: 'Nama', title: 'Name' },
                { data: 'NoKTP', title: 'ID Card Number' },
                { data: 'Telp', title: 'Phone' },
                { data: 'Kota_Tinggal', title: 'City' },
                { data: 'Tanggal_lahir', title: 'Date of Birth' },
                { data: 'Tanggal_Masuk', title: 'Join Date' },
                {
                    data: 'Department',
                    title: 'Department',
                    render: function (data, type, row) {
                        return fetchDepartmentName(data);
                    }
                },
                { data: 'Kota_Penempatan', title: 'Placement City' },
                {
                    // Action column (modify as needed)
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button class="btn btn-warning btn-sm" onclick="editEmployee(' + row.IDKaryawan + ')">Edit</button>';
                        var deleteButton = '<button class="btn btn-danger btn-sm" onclick="deleteEmployee(' + row.IDKaryawan + ')">Delete</button>';
                        return editButton + ' ' + deleteButton;
                    },
                    title: 'Action'
                }
            ]
        });
    })
    .fail(function (error) {
        console.error('Error fetching employee data:', error);
    });
}

function fetchDepartmentName(departmentID) {
    return gDepart[0].Nama_Dept;
}

// Function to load existing departments
function loadDepartments() {
    // Clear existing department options
    $('#employeeDepartment').empty();

    // Fetch department data from the PHP backend
    $.getJSON('./departments/department_backend.php', function (data) {
        gDepart = data;
        // Create option elements and append to the department select
        $.each(data, function (index, department) {
            var option = $('<option>').val(department.IDDept).text(department.Nama_Dept);
            $('#employeeDepartment').append(option);
        });
    })
    .fail(function (error) {
        console.error('Error fetching department data:', error);
    });
}

// Function to check duplicate employee ID card number
function checkDuplicateEmployee(employeeID, employeeKTP, callback) {
    var params = {
        action: 'checkDuplicate',
        employeeID: employeeID,
        employeeKTP: employeeKTP
    };

    $.getJSON('./karyawans/employee_backend.php', params, function (data) {
        callback(data);
    });
}

// Function to clear the employee form
function clearEmployeeForm() {
    $('#employeeForm')[0].reset();
}

// Function to edit employee
function editEmployee(employeeID) {
    // AJAX call to fetch employee details
    $.getJSON('./karyawans/employee_backend.php', { action: 'getEmployee', employeeID: employeeID }, function (data) {
        if (data.success) {
            // Populate the form fields with the fetched data
            var employeeData = data.employeeData;
            $('#employeeID').val(employeeData.IDKaryawan);
            $('#employeeName').val(employeeData.Nama);
            $('#employeeKTP').val(employeeData.NoKTP);
            $('#employeePhone').val(employeeData.Telp);
            $('#employeeCity').val(employeeData.Kota_Tinggal);
            $('#employeeDOB').val(employeeData.Tanggal_lahir);
            $('#employeeJoinDate').val(employeeData.Tanggal_Masuk);
            $('#employeeDepartment').val(employeeData.Department);
            $('#employeePlacementCity').val(employeeData.Kota_Penempatan);

            // Scroll to the form for better visibility (optional)
            $('html, body').animate({
                scrollTop: $('#employeeForm').offset().top
            }, 500);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message ? data.message : 'Unknown error occurred.',
            });
        }
    })
    .fail(function (error) {
        console.error('Error fetching employee details:', error);
    });
}

// Function to delete employee
function deleteEmployee(employeeID) {
    // Confirm before deleting
    if (confirm('Are you sure you want to delete this employee?')) {
        // AJAX call to delete employee
        $.ajax({
            url: './karyawans/employee_backend.php',
            type: 'GET',
            data: { action: 'deleteEmployee', employeeID: employeeID },
            success: function (data) {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Delete Success',
                    });
                    loadEmployees(); // Reload the DataTable after deletion
                } else {
                    var errorMessage = data.message ? data.message : 'Unknown error';
                    alert('Error deleting employee: ' + errorMessage);
                }
            },
            error: function (error) {
                console.error('Error deleting employee:', error.statusText);
            }
        });
    }
}




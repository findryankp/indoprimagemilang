$(document).ready(function() {
    $('#deptList').DataTable();
    loadDepartments();
});

// Function to add or edit department using jQuery
function addEditDepartment() {
    var deptID = $('#deptID').val();
    var deptName = $('#deptName').val();

    // Add validation for duplicate department names using jQuery
    checkDuplicateDepartment(deptID, deptName, function(isDuplicate) {
        if (isDuplicate) {
            Swal.fire({
                icon: 'info',
                title: 'Exist!',
                text: 'Department name already exists. Please choose a different name..',
            });
            return;
        }

        // Add validation for deleting department with associated employees using jQuery
        checkEmployeesInDepartment(deptID, function(hasEmployees) {
            if (hasEmployees) {
                Swal.fire({
                    icon: 'info',
                    title: 'Exist!',
                    text: 'Unable to delete. Department has employees.',
                });
                return;
            }

            var formData = new FormData();
            formData.append('deptID', deptID);
            formData.append('deptName', deptName);

            $.ajax({
                url: './departments/department_backend.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Success Add Data',
                        });
                    } else {
                        alert(data.message);
                    }
                }
            });
        });
    });

    loadDepartments()
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'add edit data success.',
    });
}

// Function to check duplicate department names using jQuery
function checkDuplicateDepartment(deptID, deptName, callback) {
    var params = {
        action: 'checkDuplicate',
        deptID: deptID,
        deptName: deptName
    };

    $.getJSON('./departments/department_backend.php', params, function(data) {
        callback(data.isDuplicate);
    });
}

// Function to check if there are employees in the department using jQuery
function checkEmployeesInDepartment(deptID, callback) {
    var params = {
        action: 'checkEmployees',
        deptID: deptID
    };

    $.getJSON('./departments/department_backend.php', params, function(data) {
        callback(data.hasEmployees);
    });
}

// Function to load existing departments using jQuery
function loadDepartments() {
    $('#deptList').DataTable().clear().destroy();
    $.ajax({
        url: './departments/department_backend.php',
        dataType: 'json',  // Specify the expected data type
        success: function(data) {
            var deptList = $('#deptList').DataTable();
            deptList.clear();
    
            data.forEach(function (dept) {
                var editButton = '<button class="btn btn-warning" onclick="editDepartment(' + dept.IDDept + ', \'' + dept.Nama_Dept + '\')">Edit</button>';
                var deleteButton = '<button class="btn btn-danger" onclick="deleteDepartment(' + dept.IDDept + ')">Delete</button>';
    
                deptList.row.add([dept.Nama_Dept, editButton, deleteButton]).draw();
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error: ' + textStatus, errorThrown);
        }
    });
}

// Function to edit department using jQuery
function editDepartment(deptID, deptName) {
    $('#deptID').val(deptID);
    $('#deptName').val(deptName);
}

// Function to delete department using jQuery
function deleteDepartment(deptID) {
    if (confirm('Are you sure you want to delete this department?')) {
        $.getJSON('./departments/department_backend.php', { action: 'delete', deptID: deptID }, function(data) {
            if (data.success) {
                loadDepartments();
            } else {
                alert(data.message);
            }
        });
    }
}

// Function to clear the form using jQuery
function clearForm() {
    $('#deptID').val('');
    $('#deptName').val('');
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        .error {
            color: red;
        }
        .error-message {
            display: block;
            color: red;
            margin-top: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-md-6 offset-md-1">
            <div class="row">
                <h2>AJAX CRUD</h2>
                <form id="employeeForm">
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label for="Firstname" class="name">Firstname<font color="red">*</font></label>
                        <input type="text" name="firstname" class="form-control" id="firstname">
                        <span class="error-message" id="firstnameError"></span>
                    </div>
                    <div class="form-group">
                        <label for="Lastname" class="name">Lastname<font color="red">*</font></label>
                        <input type="text" name="lastname" class="form-control" id="lastname">
                        <span class="error-message" id="lastnameError"></span>
                    </div>
                    <div class="form-group">
                        <label for="Email" class="name">Email<font color="red">*</font></label>
                        <input type="email" name="email" class="form-control" id="email">
                        <span class="error-message" id="emailError"></span>
                    </div>
                    <div class="form-group">
                        <label for="EmpID" class="name">Employee ID<font color="red">*</font></label>
                        <input type="text" name="emp_id" class="form-control" id="emp_id">
                        <span class="error-message" id="emp_idError"></span>
                    </div>

                    <div class="form-group">
                        <label>Gender<font color="red">*</font></label>
                        <div>
                            <input type="radio" name="gender" id="male" value="Male"> Male
                            <input type="radio" name="gender" id="female" value="Female"> Female
                        </div>
                        <span class="error-message" id="genderError"></span>
                    </div>

                    <div class="form-group">
                        <label for="country" class="name">Country<font color="red">*</font></label>
                        <select name="country" class="form-control" id="country">
                            <option value="">Select Country</option>
                            <option value="USA">USA</option>
                            <option value="Canada">Canada</option>
                            <option value="UK">UK</option>
                            <option value="Australia">Australia</option>
                            <option value="India">India</option>
                            <!-- Add more countries as needed -->
                        </select>
                        <span class="error-message" id="countryError"></span>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="terms" id="terms" value="yes">
                        <label for="terms" class="name">I agree to the terms and conditions<font color="red">*</font></label>
                        <span class="error-message" id="termsError"></span>
                    </div>

                    
                    <button type="submit" id="submitButton" class="btn btn-primary float-end">Save</button>
                    <div class="error" id="formError"></div>
                </form>
            </div>
        </div>
    </div>

    <table id="employeeTable" class="display nowrap">
        <thead>
            <tr>
                <!-- <th>Full Name</th> -->
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Employee ID</th>
                <th>gender</th>
                <th>country</th>
                <th>terms</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be fetched by AJAX -->
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            let table = $('#employeeTable').DataTable({
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                }
            });

            function fetchEmployees() {
                $.ajax({
                    url: 'operation.php',
                    type: 'POST',
                    data: { action: 'read' },
                    dataType: 'json',
                    success: function(response) {
                        table.clear().draw();
                        response.forEach(function(employee) {
                            if (employee.status === 'active') {
                                // let fullname = employee.firstname + ' ' + employee.lastname;
                                table.row.add([
                                    // fullname,
                                    employee.firstname,
                                    employee.lastname,
                                    employee.email,
                                    employee.emp_id,
                                    employee.gender,
                                    employee.country,
                                    employee.terms,
                                    employee.status,
                        `<button onclick="editEmployee(${employee.id}, '${employee.firstname}', '${employee.lastname}', '${employee.email}', '${employee.emp_id}', '${employee.gender}', '${employee.country}', '${employee.terms}')">Edit</button>
                        <button onclick="deleteEmployee(${employee.id})">Delete</button>`
                                ]).draw(false);
                            }
                        });
                    }
                });
            }

            function validateForm() {
                    let firstname = $('#firstname').val().trim();
                    let lastname = $('#lastname').val().trim();
                    let email = $('#email').val().trim();
                    let emp_id = $('#emp_id').val().trim();
                    let gender = $('input[name="gender"]:checked').val();
                    let country = $('#country').val();
                    let terms = $('#terms').prop('checked');
                    let isValid = true;

                    $('#firstnameError').text('');
                    $('#lastnameError').text('');
                    $('#emailError').text('');
                    $('#emp_idError').text('');
                    $('#genderError').text('');
                    $('#countryError').text('');
                    $('#termsError').text('');
                    $('#formError').text('');

                    if (!firstname) {
                        $('#firstnameError').text('This value is required.');
                        isValid = false;
                    }
                    if (!lastname) {
                        $('#lastnameError').text('This value is required.');
                        isValid = false;
                    }
                    if (!email) {
                        $('#emailError').text('This value is required.');
                        isValid = false;
                    } else if (!validateEmail(email)) {
                        $('#emailError').text('Invalid email format.');
                        isValid = false;
                    }
                    if (!emp_id) {
                        $('#emp_idError').text('This value is required.');
                        isValid = false;
                    } else if (!validateEmpId(emp_id)) {
                        $('#emp_idError').text('Employee ID must be an integer.');
                        isValid = false;
                    }
                    if (!gender) {
                        $('#genderError').text('This value is required.');
                        isValid = false;
                    }
                    if (!country) {
                        $('#countryError').text('This value is required.');
                        isValid = false;
                    }
                    if (!terms) {
                        $('#termsError').text('You must agree to the terms and conditions.');
                        isValid = false;
                    }

                    return isValid;
                }

                
                function validateEmail(email) {
                const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                return re.test(String(email).toLowerCase());
            }

            function validateEmpId(emp_id) {
                return /^\d+$/.test(emp_id);
            }


            $('#employeeForm').on('submit', function(e) {
                e.preventDefault();
                if (validateForm()) {
                    let formData = $(this).serialize();
                    $.ajax({
                        url: 'operation.php',
                        type: 'POST',
                        data: formData + '&action=' + ($('#id').val() ? 'update' : 'create'),
                        success: function(response) {
                            if (response === 'duplicate') {
                                $('#emp_idError').text('Duplicate Employee ID is not allowed.');
                            } else {
                                alert(response);
                                fetchEmployees();
                                $('#employeeForm')[0].reset();
                                $('#id').val('');
                                $('#submitButton').text('Save');
                            }
                        }
                    });
                }
            });

            // window.editEmployee = function(id, firstname, lastname, email, emp_id) {
            //     $('#id').val(id);
            //     $('#firstname').val(firstname);
            //     $('#lastname').val(lastname);
            //     $('#email').val(email);
            //     $('#emp_id').val(emp_id);
            //     $('#submitButton').text('Update');
            // };
            window.editEmployee = function(id, firstname, lastname, email, emp_id, gender, country, terms) {
            $('#id').val(id);
            $('#firstname').val(firstname);
            $('#lastname').val(lastname);
            $('#email').val(email);
            $('#emp_id').val(emp_id);

            // Set the gender radio button
            $('input[name="gender"]').prop('checked', false);
            if (gender === 'Male') {
                $('#male').prop('checked', true);
            } else if (gender === 'Female') {
                $('#female').prop('checked', true);
            }

            // Set the country select
            $('#country').val(country);

            // Set the terms checkbox
            $('#terms').prop('checked', terms === 'yes');

            $('#submitButton').text('Update');
        };


            window.deleteEmployee = function(id) {
                if (confirm('Are you sure to delete this record?')) {
                    $.ajax({
                        url: 'operation.php',
                        type: 'POST',
                        data: { id: id, action: 'delete' },
                        success: function(response) {
                            alert(response);
                            fetchEmployees();
                        }
                    });
                }
            };

            fetchEmployees();
        });
    </script>
</body>
</html>

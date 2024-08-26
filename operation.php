<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    switch ($action) {


        // case 'create':
        //     $firstname = $_POST['firstname'];
        //     $lastname = $_POST['lastname'];
        //     $email = $_POST['email'];
        //     $emp_id = $_POST['emp_id'];
        //     $status = 'active';
        
        //     $checkSql = "SELECT * FROM employees WHERE emp_id = '$emp_id'";
        //     $checkResult = $conn->query($checkSql);
        //     if ($checkResult->num_rows > 0) {
        //         echo "duplicate";
        //     } else {
        //         $sql = "INSERT INTO employees (firstname, lastname, email, emp_id, status) VALUES ('$firstname', '$lastname', '$email', '$emp_id', '$status')";
        //         if ($conn->query($sql) === TRUE) {
        //             echo "New record created successfully";
        //         } else {
        //             echo "Error: " . $sql . "<br>" . $conn->error;
        //         }
        //     }
        //     break;

        case 'create':
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $emp_id = $_POST['emp_id'];
            $gender = $_POST['gender'];
            $country = $_POST['country'];
            $terms = $_POST['terms'];
            $status = 'active';
            
            $checkSql = "SELECT * FROM employees WHERE emp_id = '$emp_id'";
            $checkResult = $conn->query($checkSql);
            if ($checkResult->num_rows > 0) {
                echo "duplicate";
            } else {
                $sql = "INSERT INTO employees (firstname, lastname, email, emp_id, gender, country, terms, status) VALUES ('$firstname', '$lastname', '$email', '$emp_id', '$gender', '$country', '$terms', '$status')";
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            break;


        case 'read':
            $sql = "SELECT * FROM employees WHERE status='active'";
            $result = $conn->query($sql);
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
            break;
        

        // case 'update':
        //     $id = $_POST['id'];
        //     $firstname = $_POST['firstname'];
        //     $lastname = $_POST['lastname'];
        //     $email = $_POST['email'];
        //     $emp_id = $_POST['emp_id'];

        //     $checkSql = "SELECT * FROM employees WHERE emp_id = '$emp_id' AND id != '$id'";
        //     $checkResult = $conn->query($checkSql);
        //     if ($checkResult->num_rows > 0) {
        //         echo "duplicate";
        //     } else {
        //         $sql = "UPDATE employees SET firstname='$firstname', lastname='$lastname', email='$email', emp_id='$emp_id' WHERE id=$id";
        //         if ($conn->query($sql) === TRUE) {
        //             echo "Record updated successfully";
        //         } else {
        //             echo "Error updating record: " . $conn->error;
        //         }
        //     }
        //     break;

        case 'update':
            $id = $_POST['id'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $emp_id = $_POST['emp_id'];
            $gender = $_POST['gender'];
            $country = $_POST['country'];
            $terms = $_POST['terms'];
        
            $checkSql = "SELECT * FROM employees WHERE emp_id = '$emp_id' AND id != '$id'";
            $checkResult = $conn->query($checkSql);
            if ($checkResult->num_rows > 0) {
                echo "duplicate";
            } else {
                $sql = "UPDATE employees SET firstname='$firstname', lastname='$lastname', email='$email', emp_id='$emp_id', gender='$gender', country='$country', terms='$terms' WHERE id=$id";
                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }
            break;

        // case 'delete':
        //     $id = $_POST['id'];
        //     $sql = "DELETE FROM employees WHERE id=$id";
        //     if ($conn->query($sql) === TRUE) {
        //         echo "Record deleted successfully";
        //     } else {
        //         echo "Error deleting record: " . $conn->error;
        //     }
        //     break;

        case 'delete':
            $id = $_POST['id'];
            $sql = "UPDATE employees SET status='inactive' WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                echo "Record marked as inactive successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
            break;
        
    }
}
$conn->close();
?>

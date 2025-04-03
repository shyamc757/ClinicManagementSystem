<?php
function select_appointment($username, $Password, $appointment_id, $patient_id, $doctor_id, $appointment_date, $appointment_time, $arrived, $patient_fname, $doctor_fname, $dep_code) {
    $servername = "localhost";
    //$username = "admin"; // fill in with your username
    //$Password = "admin1234"; // fill in with your password
    $dbname = "clinic_db"; // fill in with your dbname

    // Initialize variables (set to null if not provided)
    // $appointment_id =  $_GET['appointment_id'] ?? null;
    // $patient_id = $_GET['patient_id'] ?? null;
    // $doctor_id = $_GET['doctor_id'] ?? null;
    // $appointment_date = $_GET['appointment_date'] ?? null;
    // $appointment_time = $_GET['appointment_time'] ?? null;
    // $arrived = $_GET['arrived'] ?? null;

    // Create connection
    $conn = new mysqli($servername, $username, $Password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // // echo "Connected successfully";

    // Build query dynamically
    $conditions = [];
    $params = [];
    $types = '';

    if (!empty($appointment_id)) {
        $conditions[] = 'appointment_id = ?';
        $params[] = &$appointment_id;
        $types .= 's';
    }
    if (!empty($patient_id)) {
        $conditions[] = 'patient_id = ?';
        $params[] = &$patient_id;
        $types .= 's';
    }
    if (!empty($doctor_id)) {
        $conditions[] = 'doctor_id = ?';
        $params[] = &$doctor_id;
        $types .= 's';
    }
    if (!empty($appointment_date)) {
        $conditions[] = 'appointment_date = ?';
        $params[] = &$appointment_date;
        $types .= 's';
    }
    if (!empty($appointment_time)) {
        $conditions[] = 'appointment_time = ?';
        $params[] = &$appointment_time;
        $types .= 's';
    }
    if (!empty($arrived)) {
        $conditions[] = 'arrived = ?';
        $params[] = &$arrived;
        $types .= 's';
    }
    if (!empty($patient_fname)) {
        $conditions[] = 'patient_fname = ?';
        $params[] = &$patient_fname;
        $types .= 's';
    }
    if (!empty($doctor_fname)) {
        $conditions[] = 'employee_fname = ?';
        $params[] = &$doctor_fname;
        $types .= 's';
    }
    if (!empty($doctor_fname)) {
        $conditions[] = 'employee_fname = ?';
        $params[] = &$doctor_fname;
        $types .= 's';
    }
    if (!empty($dep_code)) {
        $conditions[] = ' department_code = ?';
        $params[] = &$dep_code;
        $types .= 's';
    }

    $query = "SELECT * FROM clinic_db.appointment 
            NATURAL JOIN clinic_db.patient 
            JOIN clinic_db.employee ON clinic_db.appointment.doctor_id = clinic_db.employee.employee_id";
    // if(!empty($patient_fname)){
    //     $query .= " NATURAL JOIN clinic_db.patient";
    // }
    // if (!empty($doctor_fname)){
    //     $query .= " JOIN clinic_db.employee ON clinic_db.appointment.doctor_id = clinic_db.employee.employee_id";
    // }
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(' AND ', $conditions);

    $stmt = $conn->prepare($query);

    // Bind parameters dynamically
    array_unshift($params, $types);
    call_user_func_array([$stmt, 'bind_param'], $params);
    }
    else{
        $stmt = $conn->prepare($query);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            // echo "Appointment ID: " . $row["appointment_id"]. " - Patient ID: " . $row["patient_id"]. " -  Doctor ID: " . $row["doctor_id"]. " - Appointment Date: " . $row["appointment_date"]. " - Appointment Time: " . $row["appointment_time"]. " - Status: " . $row["arrived"] . "<br>";
            echo "<tr>
  <td>" . $row["appointment_id"] . "</td>
  <td>" . $row["patient_id"] . "</td>
  <td>" . $row["patient_fname"] . " " . $row["patient_lname"] . "</td>
  <td>" . $row["employee_id"] . "</td>
  <td>" . $row["employee_fname"] . " " .$row["employee_lname"] . "</td>
  <td>" . $row["department_code"] . "</td>
  <td>" . $row["appointment_date"] . "</td>
  <td>" . $row["appointment_time"] . "</td>
  <td>" . $row["arrived"] . "</td>
  <td>
    <button class=\"edit_tableitem_button\" title=\"Edit\" onclick=\"openEditForm(event)\">&#x270E</button>
    <button class=\"delete_tableitem_button\" title=\"Delete\" onclick=\"my_delete(event)\">&#x1F5D1</button>
  </td>
  </tr>";
        }
    } else {
        echo "<tr><td>0 results</td><tr>";
    }
    $stmt->close();
    $conn->close();
}

function insert_appointment($username, $Password, $patient_id, $doctor_id, $appointment_date, $appointment_time) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($patient_id) || empty($doctor_id) || empty($appointment_date)  ||
        empty($appointment_time)) {
            die("Missing values:");
    }

    $arrived = 0;
    $appointment_id = "a" . floor(microtime(true));

    $sql =  "INSERT INTO clinic_db.appointment VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $appointment_id, $patient_id, $doctor_id, $appointment_date, $appointment_time, $arrived);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record inserted successfully!";

}

function edit_appointment($username, $Password, $patient_id, $doctor_id, $appointment_date, $appointment_time, $edit_appointment_id, $input_arrived) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($patient_id) || empty($doctor_id) || empty($appointment_date)  ||
        empty($appointment_time) || empty($edit_appointment_id)) {
            echo("Sending app id: ". $edit_appointment_id);
            die("Missing values:");
    }
    if(empty($input_arrived)){
        $input_arrived = "0";
    }

    $sql =  "UPDATE clinic_db.appointment SET patient_id = ?, doctor_id = ?, appointment_date = ?, appointment_time = ?, arrived = ? WHERE appointment.appointment_id = ?" ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $patient_id, $doctor_id, $appointment_date, $appointment_time, $input_arrived, $edit_appointment_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record updated successfully!";

}

function delete_appointment($username, $Password, $edit_appointment_id) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($edit_appointment_id)) {
            echo("Sending app id: ". $edit_appointment_id);
            die("Missing values:");
    }

    $arrived = 0;

    $sql =  "DELETE FROM appointment WHERE appointment.appointment_id = ? " ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $edit_appointment_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record deleted successfully!";

}
?>

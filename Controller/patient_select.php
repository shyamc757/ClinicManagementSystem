<?php
function patient_select($username, $Password, $patient_id, $patient_name, $patient_email, $patient_phone) {
    $servername = "localhost";
    $dbname = "clinic_db"; // fill in with your dbname

    // Create connection
    $conn = new mysqli($servername, $username, $Password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // echo "Connected successfully";

    // Build query dynamically
    $conditions = [];
    $params = [];
    $types = '';

    if (!empty($patient_id)) {
        $conditions[] = 'patient_id = ?';
        $params[] = &$patient_id;
        $types .= 's';
    }
    if (!empty($patient_name)) {
        $conditions[] = 'patient_fname = ?';
        $params[] = &$patient_name;
        $types .= 's';
    }
    // if (!empty($patient_lname)) {
    //     $conditions[] = 'patient_lname = ?';
    //     $params[] = &$patient_lname;
    //     $types .= 's';
    // }
    if (!empty($patient_email)) {
        $conditions[] = 'patient_email = ?';
        $params[] = &$patient_email;
        $types .= 's';
    }
    if (!empty($patient_phone)) {
        $conditions[] = 'patient_phone = ?';
        $params[] = &$patient_phone;
        $types .= 's';
    }
    // if (!empty($patient_address)) {
    //     $conditions[] = 'patient_address = ?';
    //     $params[] = &$patient_address;
    //     $types .= 's';
    // }
    // if (!empty($patient_dob)) {
    //     $conditions[] = 'patient_dob = ?';
    //     $params[] = &$patient_dob;
    //     $types .= 's';
    // }
    // if (!empty($medical_data)) {
    //     $conditions[] = 'medical_data = ?';
    //     $params[] = &$medical_data;
    //     $types .= 's';
    // }

    $query = "SELECT * FROM patient";
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(' AND ', $conditions);

        $stmt = $conn->prepare($query);

        // Bind parameters dynamically
        array_unshift($params, $types);
        call_user_func_array([$stmt, 'bind_param'], $params);
    }

    else {
        $stmt = $conn->prepare($query);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            // echo "Patient ID: " . $row["patient_id"]. " - First Name: " . $row["patient_fname"]. "-  Last Name: " . $row["patient_lname"]. " - Email: " . $row["patient_email"]. " - Phone: " . $row["patient_phone"]. " - Address: " . $row["patient_address"]. " - Date of Birth: " . $row["patient_dob"]. " - Medical Data: " . $row["medical_data"]."<br>";
            echo "<tr>
  <td>" . $row["patient_id"] . "</td>
  <td>" . $row["patient_fname"] . " " . $row["patient_lname"] . "</td>
  <td>" . $row["patient_email"] . "</td>
  <td>" . $row["medical_data"] . "</td>
  <td>" . $row["patient_phone"] . "</td>
  <td>" . $row["patient_address"] . "</td>
  <td>" . $row["patient_dob"] . "</td>
  <td>
    <button class=\"edit_tableitem_button\" onclick=\"openEditForm(event)\">&#x270E</button>
    <button class=\"delete_tableitem_button\" title=\"Delete\" onclick=\"my_delete(event)\">&#x1F5D1</button>
  </td>
  </tr>";      
        }
    } else {
        echo "<tr><td>0 results</td></tr>";
    }
    $stmt->close();
    $conn->close();
}

function patient_insert($username, $Password, $patient_name, $patient_email, $medical_conditoin, $patient_phone, $patient_address, $patient_DOB, $patient_id) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($patient_name) || empty($patient_email) || empty($patient_phone)){
            die("Missing values:");
    }

    $arrived = 0;
    // $patient_id = "p" . floor(microtime(true));
    $parts = explode(" ", $patient_name);
    $patient_fnmae = $parts[0];
    $pathent_lname = $parts[1]  ?? null;;

    $sql =  "INSERT INTO clinic_db.patient VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $patient_id, $patient_fnmae, $pathent_lname, $patient_email, $patient_phone, $patient_address, $patient_DOB, $medical_conditoin);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record inserted successfully!";

}

function patient_update($username, $Password, $patient_name, $patient_email, $medical_conditoin, $patient_phone, $patient_address, $patient_DOB, $patient_id) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($patient_name) || empty($patient_email) || empty($patient_phone) || empty($patient_id)) {
        die("Missing values:");
    }

    $parts = explode(" ", $patient_name);
    $patient_fnmae = $parts[0];
    $patient_lnmae = $parts[1]  ?? null;

    $sql =  "UPDATE clinic_db.patient SET patient_fname = ?, patient_lname = ?, patient_email = ?, patient_phone = ?, patient_address = ?, patient_dob = ?, medical_data = ? WHERE patient.patient_id = ?" ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $patient_fnmae, $patient_lnmae, $patient_email, $patient_phone, $patient_address, $patient_DOB, $medical_conditoin, $patient_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record updated successfully!";

}
?>

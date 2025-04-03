<?php
function patient_medicine_search($username, $Password, $patient_id, $patient_name, $medicine_id, $medicine_name) {
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
        $conditions[] = 'patient_medicine.patient_id = ?';
        $params[] = &$patient_id;
        $types .= 's';
    }
    if (!empty($medicine_id)) {
        $conditions[] = 'patient_medicine.medicine_id = ?';
        $params[] = &$medicine_id;
        $types .= 's';
    }
    if (!empty($patient_name)) {
        $conditions[] = 'patient.patient_fname = ?';
        $params[] = &$patient_name;
        $types .= 's';
    }
    if (!empty($medicine_name)) {
        $conditions[] = 'medical_inventory.medicine_name = ?';
        $params[] = &$medicine_name;
        $types .= 's';
    }

    $query = "SELECT patient_medicine.patient_id, patient_fname, patient_lname, patient_medicine.medicine_id, medicine_name, patient_medicine.count, date_of_acquiry
             FROM patient_medicine JOIN patient ON patient_medicine.patient_id = patient.patient_id JOIN medical_inventory ON medical_inventory.medicine_id = patient_medicine.medicine_id";
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
            // echo "Patient ID: " . $row["patient_id"]. " - Medicine ID: " . $row["medicine_id"]. "-  Count: " . $row["count"]. " - Date of Aquiry: " . $row["date_of_acquiry"]. "<br>";
            echo "<tr>
  <td>" . $row["patient_id"] . "</td>
  <td>" . $row["patient_fname"] . " " . $row["patient_lname"] . "</td>
  <td>" . $row["medicine_id"] . "</td>
  <td>" . $row["medicine_name"] . "</td>
  <td>" . $row["count"] . "</td>
  <td>" . $row["date_of_acquiry"] . "</td>
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

function patient_medicine_insert($username, $Password, $patient_id, $medicine_id, $count, $date_of_acquiry){
    echo "Count is 2nd" . $count;
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($patient_id) || empty($medicine_id) || empty($count)) {
            die("Missing values:");
    }
    if (empty($date_of_acquiry)) {
        $date_of_acquiry = null;
    }

    $sql =  "INSERT INTO clinic_db.patient_medicine VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    echo "Count is " . $count;
    mysqli_stmt_bind_param($stmt, "ssss", $patient_id, $medicine_id, $count, $date_of_acquiry);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record inserted successfully!";

}

function patient_medicine_delete($username, $Password, $patient_id, $medicine_id, $count, $date_of_acquiry) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($patient_id) || empty($medicine_id) || empty($count)) {
        die("Missing values:");
    }
    if (empty($date_of_acquiry)) {
         $date_of_acquiry = null;
    }

    $arrived = 0;

    $sql =  "DELETE FROM patient_medicine WHERE patient_id = ?  AND medicine_id = ? AND count = ?" ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $patient_id, $medicine_id, $count);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record deleted successfully!";
}
?>

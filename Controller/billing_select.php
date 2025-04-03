<?php
function billing_select($username, $Password, $billing_id, $patient_id, $patient_name, $appointment_id, $billing_gen_date, $billing_paid_date) {
    $servername = "localhost";
    $dbname = "clinic_db";

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

    if (!empty($billing_id)) {
        $conditions[] = 'billing_id = ?';
        $params[] = &$billing_id;
        $types .= 's';
    }
    // if (!empty($billing_amt)) {
    //     $conditions[] = 'billing_amt = ?';
    //     $params[] = &$billing_amt;
    //     $types .= 's';
    // }
    if (!empty($billing_gen_date)) {
        // TODO: WHERE [dateColumn] > '3/1/2009' AND [dateColumn] <= DATEADD(day,1,'3/31/2009') 
        $conditions[] = 'billing_gen_date = ?';
        $params[] = &$billing_gen_date;
        $types .= 's';
    }
    if (!empty($billing_paid_date)) {
        // TODO: WHERE [dateColumn] > '3/1/2009' AND [dateColumn] <= DATEADD(day,1,'3/31/2009') 
        $conditions[] = 'billing_paid_date = ?';
        $params[] = &$billing_paid_date;
        $types .= 's';
    }
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
    if (!empty($patient_name)) {
        $conditions[] = 'patient_fname = ?';
        $params[] = &$patient_name;
        $types .= 's';
    }

    $query = "SELECT * FROM billing NATURAL JOIN clinic_db.appointment 
               NATURAL JOIN clinic_db.patient";
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
            // echo "Billing ID: " . $row["billing_id"]. " - Billing Amount: " . $row["billing_amt"]. " - Billing Generate Date: " . $row["billing_gen_date"]. " - Billing Paid Date: " . $row["billing_paid_date"]. " - Appointment Id: " . $row["appointment_id"]. "<br>";
            echo "<tr>
  <td>" . $row["billing_id"] . "</td>
  <td>" . $row["patient_id"] . "</td>
  <td>" . $row["patient_fname"] . " ". $row["patient_lname"] . "</td>
  <td>" . $row["appointment_id"] . "</td>
  <td>" . $row["billing_gen_date"] . "</td>
  <td>" . $row["billing_paid_date"] . "</td>
  <td>" . $row["billing_amt"] . "</td>
  <td>
    <button class=\"edit_tableitem_button\" title=\"Edit\" onclick=\"openEditForm(event)\">&#x270E</button>
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

function billing_update($username, $Password, $input_billing_id, $input_bill_paid) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($input_billing_id) || empty($input_bill_paid)) {
            echo("No Update Done". $input_billing_id);
            die("Missing values:");
    }

    $billing_paid_date = date('Y-m-d H:i:s');

    $sql =  "UPDATE clinic_db.billing SET billing_paid_date = ? WHERE billing_id = ?" ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $billing_paid_date, $input_billing_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record updated successfully!";

}

function billing_delete($username, $Password, $billing_id) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($billing_id)) {
            echo("Sending empty id: ". $billing_id);
            die("Missing values:");
    }

    $arrived = 0;

    $sql =  "DELETE FROM billing WHERE billing.billing_id = ? " ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $billing_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record deleted successfully!";
    // billing_insert($username, $Password, "p6", "a10");

}

function billing_insert($username, $Password, $billing_amt,  $patient_id, $appointment_id) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($patient_id) || empty($appointment_id)) {
            echo("Sending empty id: ". $patient_id);
            die("Missing values:");
    }

    $billing_id = "b" . floor(microtime(true));
    $billing_gen_date = date('Y-m-d H:i:s');
    $null_val = null;
    $init_amt = 20;

    $sql =  "INSERT INTO clinic_db.billing VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $billing_id, $billing_amt, $billing_gen_date, $null_val, $appointment_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record Billing inserted successfully!";

}

function billing_update_cost($username, $Password, $appointment_id){
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($appointment_id)) {
            die("Missing values:");
    }

    $billing_paid_date = date('Y-m-d H:i:s');

    $sql =  "UPDATE clinic_db.billing SET billing_amt = billing_amt + 3.67 WHERE billing_amt = 33" ;
    $stmt = mysqli_prepare($conn, $sql);
    // mysqli_stmt_bind_param($stmt);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record updated successfully!";
}
?>

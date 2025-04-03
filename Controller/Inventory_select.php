<?php
function select_inventory($username, $Password, $medicine_id, $medicine_name, $count) {
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

    if (!empty($medicine_id)) {
        $conditions[] = 'medicine_id = ?';
        $params[] = &$medicine_id;
        $types .= 's';
    }
    if (!empty($medicine_name)) {
        $conditions[] = 'medicine_name = ?';
        $params[] = &$medicine_name;
        $types .= 's';
    }
    if (!empty($count)) {
        $conditions[] = 'count <= ?';
        $params[] = &$count;
        $types .= 's';
    }

    $query = "SELECT * FROM medical_inventory";

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
            // echo "ID: " . $row["medicine_id"]. " -  Medicine Name: " . $row["medicine_name"]. " -  Count: " . $row["count"]. " -  Cost per Dose: " . $row["cost_per_dose"]. " -  Expiry Date: " . $row["expiry_date"] . "<br>";
            echo "<tr>
  <td>" . $row["medicine_id"] . "</td>
  <td>" . $row["medicine_name"] . "</td>
  <td>" . $row["count"] . " </td>
  <td>" . $row["cost_per_dose"] . " </td>
  <td>" . $row["expiry_date"] . "</td>
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

function insert_inventory($username, $Password, $medicine_name, $inventory_count, $expiration_date, $cost_per_dose) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($cost_per_dose) || empty($medicine_name) || empty($inventory_count)  ||
        empty($expiration_date)) {
            die("Missing values:");
    }

    $medicine_id = "m" . floor(microtime(true));

    $sql =  "INSERT INTO clinic_db.medical_inventory VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $medicine_id, $medicine_name, $inventory_count, $cost_per_dose, $expiration_date);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record inserted successfully!";

}

function edit_inventory($username, $Password, $medicine_name, $medicine_count, $expiration_date, $cost_per_dose, $medicine_id) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($medicine_name) || empty($medicine_count) || empty($expiration_date)  ||
        empty($cost_per_dose) || empty($medicine_id)) {
            echo("Sending app id: ". $medicine_id);
            die("Missing values:");
    }

    $arrived = 0;

    $sql =  "UPDATE clinic_db.medical_inventory SET medicine_name = ?, count = ?, cost_per_dose = ?, expiry_date = ?  WHERE medicine_id = ?" ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $medicine_name, $medicine_count, $cost_per_dose, $expiration_date, $medicine_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record updated successfully!";

}

function delete_inventory($username, $Password, $medicine_id){
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($medicine_id)) {
            echo("Sending app id: ". $medicine_id);
            die("Missing values:");
    }

    $arrived = 0;

    $sql =  "DELETE FROM medical_inventory WHERE medical_inventory.medicine_id = ? " ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $medicine_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record deleted successfully!";
}

function edit_inventory_count($username, $Password, $medicine_id){
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($medicine_id)) {
            echo("Sending app id: ". $medicine_id);
            die("Missing values:");
    }

    $arrived = 0;

    $sql =  "UPDATE clinic_db.medical_inventory SET count = count - 1 WHERE medicine_id = ?" ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $medicine_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record Medicine updated successfully!";

}
?>

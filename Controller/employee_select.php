<?php
function employee_select($username, $Password, $employee_id, $department_code, $employee_name, $employee_email) {
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

    if (!empty($employee_id)) {
        $conditions[] = 'employee_id = ?';
        $params[] = &$employee_id;
        $types .= 's';
    }
    if (!empty($department_code)) {
        $conditions[] = 'department_code = ?';
        $params[] = &$department_code;
        $types .= 's';
    }
    if (!empty($employee_name)) {
        $conditions[] = 'employee_fname = ?';
        $params[] = &$employee_name;
        $types .= 's';
    }
    // if (!empty($employee_lname)) {
    //     $conditions[] = 'employee_lname = ?';
    //     $params[] = &$employee_lname;
    //     $types .= 's';
    // }
    // if (!empty($employee_address)) {
    //     $conditions[] = 'employee_address = ?';
    //     $params[] = &$employee_address;
    //     $types .= 's';
    // }
    if (!empty($employee_email)) {
        $conditions[] = 'employee_email = ?';
        $params[] = &$employee_email;
        $types .= 's';
    }
    // if (!empty($employee_phone)) {
    //     $conditions[] = 'employee_phone = ?';
    //     $params[] = &$employee_phone;
    //     $types .= 's';
    // }
    // if (!empty($employee_designation)) {
    //     $conditions[] = 'employee_designation = ?';
    //     $params[] = &$employee_designation;
    //     $types .= 's';
    // }

    $query = "SELECT * FROM employee";
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
            // echo "ID: " . $row["employee_id"]. " - Department Code: " . $row["department_code"]. " - First Name: " . $row["employee_fname"]. " - Last Name: " . $row["employee_lname"]. " - Address: " . $row["employee_address"]. " - Email: " . $row["employee_email"] . " - Phone: " . $row["employee_phone"] . " - Designation: " . $row["employee_designation"] . "<br>";
            echo "<tr>
  <td>" . $row["employee_id"] . "</td>
  <td>" . $row["employee_fname"] . " " .$row["employee_lname"] . "</td>
  <td>" . $row["department_code"] . "</td>
  <td>" . $row["employee_address"] . "</td>
  <td>" . $row["employee_email"] . "</td>
  <td>" . $row["employee_phone"] . "</td>
  <td>" . $row["employee_designation"] . "</td>
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

function employee_insert($username, $Password, $employee_id, $employee_name, $dep_code, $employee_address, $employee_email, $employee_phone, $employee_designation) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($employee_id) || empty($employee_name) || empty($dep_code) || empty($employee_email)|| 
        empty($employee_phone) || empty($employee_designation)){
            die("Missing values:");
    }

    $parts = explode(" ", $employee_name);
    $employee_fnmae = $parts[0];
    $employee_lname = $parts[1]  ?? null;;

    $sql =  "INSERT INTO clinic_db.employee VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $employee_id, $dep_code, $employee_fnmae, $employee_lname, $employee_address, $employee_email, $employee_phone, $employee_designation);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record inserted successfully!";
}

function employee_edit($username, $Password, $employee_id, $employee_name, $dep_code, $employee_address, $employee_email, $employee_phone, $employee_designation) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($employee_id) || empty($employee_name) || empty($dep_code) || empty($employee_email)|| 
        empty($employee_phone) || empty($employee_designation)){
            die("Missing values:");
    }

    $parts = explode(" ", $employee_name);
    $employee_fnmae = $parts[0];
    $employee_lnmae = $parts[1]  ?? null;

    $sql =  "UPDATE clinic_db.employee SET department_code = ?, employee_fname = ?, employee_lname = ?, employee_address = ?, employee_email = ?, employee_phone = ?, employee_designation = ? WHERE employee.employee_id = ?" ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $dep_code, $employee_fnmae, $employee_lname, $employee_address, $employee_email, $employee_phone, $employee_designation, $employee_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record updated successfully!";

}
?>

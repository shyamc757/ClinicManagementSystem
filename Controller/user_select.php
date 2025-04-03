<?php
function select_user($username, $Password, $user_id, $user_name, $user_role, $is_deleted) {
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

    if (!empty($user_id)) {
        $conditions[] = 'user_id = ?';
        $params[] = &$user_id;
        $types .= 's';
    }
    if (!empty($user_name)) {
        $conditions[] = 'user_name = ?';
        $params[] = &$user_name;
        $types .= 's';
    }
    // if (!empty($password)) {
    //     $conditions[] = 'password = ?';
    //     $params[] = &$password;
    //     $types .= 's';
    // }
    if (!empty($user_role)) {
        $conditions[] = 'user_role = ?';
        $params[] = &$user_role;
        $types .= 's';
    }
    if (!empty($is_deleted)) {
        $conditions[] = 'is_deleted = ?';
        $params[] = &$is_deleted;
        $types .= 's';
    }

    $query = "SELECT * FROM user";
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
            // echo "User ID: " . $row["user_id"]. " - Username: " . $row["user_name"]. " - Password: " . $row["password"]. " - User Role: " . $row["user_role"]. " - Status: " . $row["is_deleted"]. "<br>";
            echo "<tr>
  <td>" . $row["user_id"] . "</td>
  <td>" . $row["user_name"] . "</td>
  <td>" . $row["password"] . "</td>
  <td>" . $row["user_role"] . "</td>
  <td>" . $row["is_deleted"] . "</td>
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

function user_insert($username, $Password, $user_role, $input_patient_email) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $application_user_id = null;
    if ($user_role == "patient") {
        $application_user_id = "p" . floor(microtime(true));
    }
    else if($user_role == "employee") {
        $application_user_id = "d" . floor(microtime(true));

    }
    $user_password = "pass" . $application_user_id;
    $is_deleted = 0;

    $sql =  "INSERT INTO clinic_db.user VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $application_user_id, $input_patient_email, $user_password, $user_role, $is_deleted);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    // echo "Record inserted successfully!";
    return $application_user_id;
}

function mark_user_deleted($username, $Password, $application_user_id) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql =  "UPDATE clinic_db.user SET is_deleted = 1 WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $application_user_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record marked as deleted successfully!";
    // return $application_user_id;
}

function insert_user_with_pw($username, $Password, $user_id, $user_name, $user_role, $is_deleted, $user_pw) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($user_id) || empty($user_name) || empty($user_role)  ||
    empty($user_pw)) {
        die("Missing values:");
    }

    $user_password = "pass" . $user_id;
    $is_deleted = 0;

    $sql =  "INSERT INTO clinic_db.user VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $user_id, $user_name, $user_pw, $user_role, $is_deleted);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record inserted successfully!";
    // return $user_id;
}

function edit_user($username, $Password, $user_id, $user_name, $user_role, $is_deleted, $user_pw){
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($user_id) || empty($user_name) || empty($user_role)  ||
    empty($user_pw)) {
        die("Missing values:");
    }

    $int_valu_is_deleted = $is_deleted?1:0;

    $arrived = 0;

    $sql =  "UPDATE clinic_db.user SET user_name = ?, password = ?, user_role = ?, is_deleted = ? WHERE user_id = ?" ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $user_name, $user_pw, $user_role, $int_valu_is_deleted, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record updated successfully!";

}
?>
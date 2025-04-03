<?php
function depeartment_select($username, $Password, $department_code, $department_name){
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

    if (!empty($department_code)) {
        $conditions[] = 'department_code = ?';
        $params[] = &$department_code;
        $types .= 's';
    }
    if (!empty($department_name)) {
        $conditions[] = 'department_name = ?';
        $params[] = &$department_name;
        $types .= 's';
    }

    $query = "SELECT * FROM department";
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
            // echo "Department Code: " . $row["department_code"]. " - Department Code: " . $row["department_name"]."<br>";
            echo "<tr>
  <td>" . $row["department_code"] . "</td>
  <td>" . $row["department_name"] . "</td>
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

function depeartment_insert($username, $Password, $department_name) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($department_name)) {
            die("Missing values:");
    }

    $department_code = "dc". floor(microtime(true));

    $sql =  "INSERT INTO clinic_db.department VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $department_code, $department_name);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record inserted successfully!";
}

function depeartment_update($username, $Password, $department_name, $department_code) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($department_name) || empty($department_code)) {
            echo("Sending app id: ". $department_code);
            die("Missing values:");
    }

    $arrived = 0;

    $sql =  "UPDATE clinic_db.department SET department_name = ? WHERE department.department_code = ?" ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $department_name, $department_code);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record updated successfully!";
}

function depeartment_delete($username, $Password, $department_id) {
    $servername = "localhost";
    $dbname = "clinic_db";
    $conn = new mysqli($servername, $username, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($department_id)) {
            echo("Sending app id: ". $department_id);
            die("Missing values:");
    }

    $arrived = 0;

    $sql =  "DELETE FROM department WHERE department.department_code = ? " ;
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $department_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    echo "Record deleted successfully!";

}
?>

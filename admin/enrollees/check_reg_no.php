<?php
// Assuming you have a database connection established

// Check if the registration number exists in the database
if(isset($_POST['reg_no'])) {
    $reg_no = $_POST['reg_no'];
    $result = $this->conn->query("SELECT * FROM enrollee_list WHERE reg_no = '$reg_no'");
    if($result->num_rows > 0){
        // Registration number exists in the database
        echo '<span style="color: red;">Registration number already exists.</span>';
    } else {
        // Registration number doesn't exist in the database
        echo '<span style="color: green;">Registration number is available.</span>';
    }
}
?>

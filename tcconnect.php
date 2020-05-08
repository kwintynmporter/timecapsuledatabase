<?php
$fname = $_POST['fname']; 
$lname = $_POST['lname']; 
$email = $_POST['email']; 
$notes = $_POST['notes']; 

if (!empty($notes)) {
    $host = "localhost";
    $dbusername = "root"; 
    $dbpassword = ""; 
    $dbname = "timecapsule"; 

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('.mysqli_connect_error().')'.mysqli_connect_error());
    } else {
        $SELECT = "SELECT email From notelog Where email = ? Limit 366";
        $INSERT = "INSERT Into notelog (fname, lname, email, notes) values (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email); 
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum==0) {
         $stmt->close();
         
         $stmt = $conn->prepare($INSERT);
         $stmt->bind_param("ssss", $fname, $lname, $email, $notes);
         $stmt->execute(); 
         echo "New record inserted successfully";
        } else {
            echo "Email already registered/expired";
        }
        $stmt-> close(); 
        $conn-> close(); 
    }

} else {
    echo "All fields are required"; 
    die();
}
?> 
<?php

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}



$servername = "(servername)";
$username = "(username)";
$password = "(password)";
$dbname = "(database)";
if (isset($_GET['r'])) {
    $url = $_GET['r'];
    $clenedurl = trim(strip_tags($url));

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $datetime = new DateTime( "now", new DateTimeZone( "UTC" ) );
    //change to your local timezone

    $date = $datetime->format( 'Y-m-d H:i:s' );

      $sql_url = mysqli_real_escape_string($conn, $url);
    $sql_date = mysqli_real_escape_string($conn, $date);
    $sql_ip = mysqli_real_escape_string($conn, $ip);

    $sql = "INSERT INTO links (url, dateofvisit, clientip)
VALUES ('$sql_url', '$sql_date', '$sql_ip')";

    if ($conn->query($sql) === true) {
        //echo "New record created successfully";
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();


header('Location: ' . $url);

} else {
    print 'Please enter a URL.';
}

?>

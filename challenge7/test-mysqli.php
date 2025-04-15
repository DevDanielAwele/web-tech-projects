<?php
$conn = mysqli_connect("localhost", "gradeUser", "gradeUser", "challenge5DB");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
  echo $row['FirstName'] . " " . $row['SecondName'] . "\n";
}

mysqli_close($conn);
?>

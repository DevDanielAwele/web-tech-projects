<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "gradeUser", "gradeUser", "challenge5DB");

if (!$conn) {
  die("❌ Database connection failed: " . mysqli_connect_error());
}

// Sanitize form input
$firstName = trim($_POST['first_name'] ?? '');
$lastName  = trim($_POST['last_name'] ?? '');
$courseName = trim($_POST['course'] ?? '');
$grade     = intval($_POST['grade'] ?? 0);

if (!$firstName || !$lastName || !$courseName || !$grade) {
  die("❌ Missing required fields.");
}

// Step 1: Get CourseID from CourseName
$courseQuery = "SELECT CourseID FROM courses WHERE CourseName = ?";
$stmt = mysqli_prepare($conn, $courseQuery);
mysqli_stmt_bind_param($stmt, "s", $courseName);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $courseID);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$courseID) {
  die("❌ Course not found.");
}

// Step 2: Check if student exists, if not insert
$studentID = null;
$checkStudent = "SELECT StudentID FROM students WHERE FirstName = ? AND SecondName = ?";
$stmt = mysqli_prepare($conn, $checkStudent);
mysqli_stmt_bind_param($stmt, "ss", $firstName, $lastName);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $studentID);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$studentID) {
  $insertStudent = "INSERT INTO students (FirstName, SecondName) VALUES (?, ?)";
  $stmt = mysqli_prepare($conn, $insertStudent);
  mysqli_stmt_bind_param($stmt, "ss", $firstName, $lastName);
  mysqli_stmt_execute($stmt);
  $studentID = mysqli_insert_id($conn);
  mysqli_stmt_close($stmt);
}

// Step 3: Insert grade (always inserts new attempt)
$insertGrade = "INSERT INTO grades (Grade, StudentID, CourseID) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $insertGrade);
mysqli_stmt_bind_param($stmt, "iis", $grade, $studentID, $courseID);
$success = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);

if ($success) {
  header("Location: index.php?success=1");
  exit();
} else {
  die("❌ Failed to insert grade.");
}
?>

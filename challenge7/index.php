<!DOCTYPE html>
<html>
<head>
  <title>Challenge 7 – Student Grades</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 30px; background-color: #f5f5f5; }
    h2 { color: #333; }
    table {
      border-collapse: collapse;
      width: 85%;
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: left;
    }
    th {
      background-color: #eaeaea;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>

<h2>Student Grade Report</h2>

<?php
$conn = mysqli_connect("localhost", "gradeUser", "gradeUser", "challenge5DB");

if (!$conn) {
  die("<p style='color:red;'>❌ Connection failed: " . mysqli_connect_error() . "</p>");
}

$query = "
  SELECT 
    students.FirstName,
    students.SecondName,
    courses.CourseName,
    grades.Grade
  FROM grades
  JOIN students ON grades.StudentID = students.StudentID
  JOIN courses ON grades.CourseID = courses.CourseID
  ORDER BY students.FirstName, courses.CourseName;
";

$result = mysqli_query($conn, $query);

if (!$result) {
  echo "<p>❌ Query Error: " . mysqli_error($conn) . "</p>";
} elseif (mysqli_num_rows($result) > 0) {
  echo "<table>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Course</th>
            <th>Grade</th>
          </tr>";
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['FirstName']}</td>
            <td>{$row['SecondName']}</td>
            <td>{$row['CourseName']}</td>
            <td>{$row['Grade']}</td>
          </tr>";
  }
  echo "</table>";
} else {
  echo "<p>No student data found.</p>";
}

mysqli_close($conn);
?>
</body>
</html>

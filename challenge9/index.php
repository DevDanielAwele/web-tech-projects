<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Challenge 9 - Grades Table</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 30px; background: #f4f4f4; }
    h2 { text-align: center; }
    table {
      border-collapse: collapse;
      margin: 0 auto;
      width: 95%;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      border: 1px solid #999;
      text-align: center;
    }
    th {
      background-color: #e0e0e0;
    }
  </style>
</head>
<body>
<h2>Challenge 9 - Student Grade Summary</h2>

<?php
$conn = mysqli_connect("localhost", "gradeUser", "gradeUser", "challenge5DB");

if (!$conn) {
  die("<p style='color:red;'>❌ Connection failed: " . mysqli_connect_error() . "</p>");
}

$query = "
  SELECT 
    students.FirstName,
    students.SecondName AS LastName,
    courses.CourseID,
    courses.CourseName,
    grades.Grade,
    CASE 
      WHEN grades.Grade >= 90 THEN 'A+'
      WHEN grades.Grade >= 80 THEN 'A'
      WHEN grades.Grade >= 70 THEN 'B'
      WHEN grades.Grade >= 60 THEN 'C'
      WHEN grades.Grade >= 50 THEN 'D'
      ELSE 'F'
    END AS LetterGrade
  FROM grades
  JOIN students ON grades.StudentID = students.StudentID
  JOIN courses ON grades.CourseID = courses.CourseID
  ORDER BY students.FirstName;
";

$result = mysqli_query($conn, $query);

if (!$result) {
  echo "<p style='color:red;'>❌ Query error: " . mysqli_error($conn) . "</p>";
  exit();
}

if (mysqli_num_rows($result) > 0) {
  echo "<table>
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Course #</th>
              <th>Course Name</th>
              <th>Grade</th>
              <th>Letter Grade</th>
            </tr>
          </thead>
          <tbody>";

  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['FirstName']}</td>
            <td>{$row['LastName']}</td>
            <td>{$row['CourseID']}</td>
            <td>{$row['CourseName']}</td>
            <td>{$row['Grade']}</td>
            <td>{$row['LetterGrade']}</td>
          </tr>";
  }
  echo "</tbody></table>";
} else {
  echo "<p>No grades available to display.</p>";
}

mysqli_close($conn);
?>

</body>
</html>

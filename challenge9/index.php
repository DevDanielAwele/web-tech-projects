<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enter Course Grades</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="logout">
    <button>Logout</button>
  </div>

  <div class="container">
    <img src="img/cnet.png" alt="Computer Networking Technology Logo" class="logo">
    <h1>Enter Course Grades</h1>

    <form action="submit.php" method="POST" onsubmit="return validateAndInsert();">
      <span class="form-group">
        <label>First Name :</label>
        <input type="text" id="firstName" name="first_name" placeholder="First Name Only">
      </span>
      <span class="form-group">
        <label>Last Name :</label>
        <input type="text" id="lastName" name="last_name" placeholder="Last Name only">
      </span>
      <span class="form-group">
        <label>Course Number :</label>
        <select id="course" name="course" required>
          <option value="">-- Select a course --</option>
<?php
$conn = mysqli_connect("localhost", "gradeUser", "gradeUser", "challenge5DB");
if ($conn) {
  $query = "SELECT CourseName FROM courses ORDER BY CourseName ASC";
  $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $course = htmlspecialchars($row['CourseName']);
    echo "<option value='$course'>$course</option>";
  }
  mysqli_close($conn);
}
?>
        </select>
      </span>
      <span class="form-group">
        <label>Final Grade :</label>
        <input type="number" id="grade" name="grade" value="100">
      </span>
      <input type="submit" value="Submit">
      <input type="reset" value="Reset">
    </form>
  </div>

  <div class="table-section">
    <p class="note">The table below displays the contents entered on this page.</p>
    <table>
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Course #</th>
          <th>Grade</th>
          <th>Letter Grade</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td id="cellFirstName"></td>
          <td id="cellLastName"></td>
          <td id="cellCourse"></td>
          <td id="cellGrade"></td>
          <td id="cellLetter"></td>
        </tr>
<?php
$conn = mysqli_connect("localhost", "gradeUser", "gradeUser", "challenge5DB");
if (!$conn) {
  echo "<tr><td colspan='5' style='color:red;'>❌ DB connection failed: " . mysqli_connect_error() . "</td></tr>";
} else {
  $query = "
    SELECT 
      students.FirstName,
      students.SecondName AS LastName,
      courses.CourseID,
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
  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>
              <td>{$row['FirstName']}</td>
              <td>{$row['LastName']}</td>
              <td>{$row['CourseID']}</td>
              <td>{$row['Grade']}</td>
              <td>{$row['LetterGrade']}</td>
            </tr>";
    }
  }
  mysqli_close($conn);
}
?>
      </tbody>
    </table>
    <button class="clear">Clear Text File</button>
  </div>

  <script>
    function validateAndInsert() {
      const firstName = document.getElementById('firstName').value.trim();
      const lastName = document.getElementById('lastName').value.trim();
      const course = document.getElementById('course').value;
      const grade = document.getElementById('grade').value;

      if (!firstName || !lastName || !grade || !course) {
        alert("Please fill in all fields.");
        return false;
      }

      document.getElementById('cellFirstName').innerText = firstName;
      document.getElementById('cellLastName').innerText = lastName;
      document.getElementById('cellCourse').innerText = course;
      document.getElementById('cellGrade').innerText = grade;
      document.getElementById('cellLetter').innerText = calculateLetterGrade(grade);

      return true;
    }

    function calculateLetterGrade(grade) {
      const num = parseInt(grade);
      if (num >= 90) return 'A+';
      if (num >= 80) return 'A';
      if (num >= 70) return 'B';
      if (num >= 60) return 'C';
      if (num >= 50) return 'D';
      return 'F';
    }
  </script>
</body>
</html>

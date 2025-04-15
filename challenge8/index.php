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

    <form onsubmit="validateAndInsert(); return false;">
      <span class="form-group">
        <label>First Name :</label>
        <input type="text" id="firstName" placeholder="First Name Only">
      </span>
      <span class="form-group">
        <label>Last Name :</label>
        <input type="text" id="lastName" placeholder="Last Name only">
      </span>
      <span class="form-group">
        <label>Course Number :</label>
        <select id="course" required>
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
        <input type="number" id="grade" value="100">
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
        return;
      }

      document.getElementById('cellFirstName').innerText = firstName;
      document.getElementById('cellLastName').innerText = lastName;
      document.getElementById('cellCourse').innerText = course;
      document.getElementById('cellGrade').innerText = grade;
      document.getElementById('cellLetter').innerText = calculateLetterGrade(grade);
    }

    function calculateLetterGrade(grade) {
      const num = parseInt(grade);
      if (num >= 90) return 'A';
      if (num >= 80) return 'B';
      if (num >= 70) return 'C';
      if (num >= 60) return 'D';
      return 'F';
    }
  </script>
</body>
</html>

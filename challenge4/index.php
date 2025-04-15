<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CSV Table</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    table { border-collapse: collapse; width: 70%; margin-top: 20px; }
    th, td { border: 1px solid #444; padding: 8px; text-align: left; }
    th { background-color: #eee; }
  </style>
</head>
<body>

  <h1>Student Grades (Imported from CSV)</h1>

  <?php
    $file = 'students.csv';
    if (!file_exists($file)) {
      echo "<p><strong>Error:</strong> CSV file not found.</p>";
    } else {
      $csv = fopen($file, 'r');
      echo "<table>";
      $headerPrinted = false;
      while (($row = fgetcsv($csv)) !== false) {
        echo "<tr>";
        foreach ($row as $cell) {
          $tag = $headerPrinted ? "td" : "th";
          echo "<$tag>" . htmlspecialchars($cell) . "</$tag>";
        }
        echo "</tr>";
        $headerPrinted = true;
      }
      fclose($csv);
      echo "</table>";
    }
  ?>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Database - Doctors</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
  <h1>Doctors</h1>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Birthday</th>
        <th scope="col">License number</th>
        <th scope="col">License date</th>
        <th scope="col">Hospital</th>
        <th scope="col">Specialty</th>
      </tr>
    </thead>
    <tbody>
      <?php
        include 'connectdb.php';
        $sortby = $_POST['sort'] ?? 'lastname';
        $sortOrder = $_POST['order'] ?? 'ASC'; // ASC DESC
        $special = $_POST['special'] ?? '';
        $query = "SELECT * FROM doctor WHERE speciality LIKE \"%" . $special . "\" ORDER BY " . $sortby . " " . $sortOrder . ";";
        $result = mysqli_query($connection,$query);
        if (!$result) {
          die("databases query failed.");
        }
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['firstname'] . "</td>";
          echo "<td>" . $row['lastname'] . "</td>";
          echo "<td>" . $row['birthdate'] . "</td>";
          echo "<td>" . $row['licensenum'] . "</td>";
          echo "<td>" . $row['licensedate'] . "</td>";
          echo "<td>" . $row['hosworksat'] . "</td>";
          echo "<td>" . $row['speciality'] . "</td>";
          echo "</tr>";
        }
      ?>
    </tbody>
    
  </table>
  <!-- licensenum | firstname   | lastname    | licensedate | birthdate   | hosworksat | speciality -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Database - Doctors</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
  <!-- Database connect -->
  <?php
    include 'connectdb.php';
    session_start();
  ?>
  <!-- Header on all pages -->
  <div class="header">
    <a class="h2 text-center my-auto" href="http://cs3319.gaul.csd.uwo.ca/vm269/a3panda/">Hospital Database</a>
  </div>

  <!-- Doctor-Patient -->
  <form id="doctorpatient" class="doctorpatient container mt-3" action="doctorpatient.php" method="post" enctype="multipart/form-data">
    <h3 class="pb-1">Doctor-Patient relationship</h3>
    <!-- Assign alert -->
    <?php
      if (isset($_SESSION['doctorpatient_message'])) {
        echo "<div class=\"alert alert-" . $_SESSION['doctorpatient_status'] . " alert-dismissible fade show\" role=\"alert\">";
        echo $_SESSION['doctorpatient_message'];
        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
        echo "</div>";
        unset($_SESSION['doctorpatient_message']);
        unset($_SESSION['doctorpatient_status']);
      }
    ?>
    <div class="row">
      <!-- doctor -->
      <div class="col">
        <select required class="form-select" name="licensenum">
          <option selected disabled><strong>Select a doctor</strong></option>
          <?php
            $docQuery = "SELECT licensenum, firstname, lastname FROM doctor;";
            $res = mysqli_query($connection, $docQuery);
            if (!$res) {
              die("database query failed.");
            }
            while ($row = mysqli_fetch_assoc($res)) {
              echo "<option value=\"" . $row['licensenum'] . "\">";
              echo $row['licensenum'] . " - " . $row['firstname'] . " " . $row['lastname'];
              echo "</option>";
            }
            mysqli_free_result($res);
          ?>
        </select>
      </div>
      <!-- patient -->
      <div class="col">
        <select required class="form-select" name="ohipnum">
          <option selected disabled><strong>Select a patient</strong></option>
          <?php
            $patQuery = "SELECT ohipnum, firstname, lastname FROM patient;";
            $res = mysqli_query($connection, $patQuery);
            if (!$res) {
              die("database query failed.");
            }
            while ($row = mysqli_fetch_assoc($res)) {
              echo "<option value=\"" . $row['ohipnum'] . "\">";
              echo $row['ohipnum'] . " - " . $row['firstname'] . " " . $row['lastname'];
              echo "</option>";
            }
            mysqli_free_result($res);
          ?>
        </select>
      </div>
    </div>
    <br>
    <input type="submit" value="Assign" class="btn btn-primary">
  </form>

  <hr>

  <!-- View patients -->
  <form class="looksafter container mt-3" action="" method="post" enctype="multipart/form-data">
    <h3 class="pb-1">View doctors patients</h3>
    <!-- Current doc alert -->
    <?php
      if (isset($_POST['licensenum'])) {
        echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">";
        echo "Showing patients under doctor " . $_POST['licensenum'];
        echo "</div>";
        unset($_SESSION['doctorpatient_message']);
        unset($_SESSION['doctorpatient_status']);
      }
    ?>
    <div class="row">
      <!-- Doctor select -->
      <div class="col">
        <select required class="form-select" name="licensenum">
          <option selected disabled><strong>Select a doctor</strong></option>
          <?php
            $docQuery = "SELECT licensenum, firstname, lastname FROM doctor;";
            $res = mysqli_query($connection, $docQuery);
            if (!$res) {
              die("database query failed.");
            }
            while ($row = mysqli_fetch_assoc($res)) {
              echo "<option value=\"" . $row['licensenum'] . "\">";
              echo $row['licensenum'] . " - " . $row['firstname'] . " " . $row['lastname'];
              echo "</option>";
            }
            mysqli_free_result($res);
          ?>
        </select>
      </div>
    </div>
    <br>
    <input type="submit" value="View patients" class="btn btn-primary">
  </form>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">OHIP number</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Birthdate</th>
      </tr>
    </thead>
    <tbody>
      <?php
        if (isset($_POST['licensenum'])) {
          $doc = $_POST['licensenum'];
          $patientTableQuery = "SELECT patient.ohipnum, firstname, lastname, birthdate FROM patient, looksafter WHERE patient.ohipnum = looksafter.ohipnum AND looksafter.licensenum like \"%" . $doc . "\";";
          $res = mysqli_query($connection, $patientTableQuery);
          if (!$res) {
            die("databases query failed.");
          }
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>" . $row['ohipnum'] . "</td>";
            echo "<td>" . $row['firstname'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td>" . $row['birthdate'] . "</td>";
            echo "</tr>";
          }
          mysqli_free_result($res);
        }
      ?>
    </tbody>
  </table>

  <div class="footer mt-3">
    <p class="text-center my-auto">48's head hurts from all the PHP 😫</p>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>

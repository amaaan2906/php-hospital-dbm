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

  <!-- select hospital -->
  <form class="hospital container mt-3" action="" method="post" enctype="multipart/form-data">
    <h3 class="pb-1">Hospital Data</h3>
    <!-- Current doc alert -->
    <?php
      if (isset($_POST['hos'])) {
        echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">";
        echo "Showing all data for hospital " . $_POST['hos'];
        echo "</div>";
      }
    ?>
    <div class="row justify-content-start">
      <!-- hospital -->
      <div class="col-4">
        <select required class="form-select" name="hos">
          <option selected disabled><strong>Select hospital</strong></option>
          <?php
            $hosQuery = "SELECT hoscode, hosname FROM hospital;";
            $res = mysqli_query($connection, $hosQuery);
            if (!$res) {
              die("databases query failed.");
            }
            while ($row = mysqli_fetch_assoc($res)) {
              echo "<option value=\"" . $row['hoscode'] . "\">";
              echo $row['hoscode'] . ": " . $row['hosname'];
              echo "</option>";
            }
            mysqli_free_result($res);
          ?>
        </select>
      </div>
      <div class="col-2">
        <input type="submit" value="View info" class="btn btn-primary">
      </div>
    </div>
  </form>
  <!-- hospital data -->
  <div class="data container mt-3">
    <?php
      if (isset($_POST['hos'])) {
        $hosQuery = "SELECT * FROM hospital, doctor WHERE licensenum=headdoc AND hoscode LIKE \"%" . $_POST['hos'] . "\";";
        $docQuery = "SELECT firstname, lastname FROM doctor WHERE hosworksat LIKE \"%" . $_POST['hos'] . "\";";
      }
    ?>
    <table class="container table table-striped">
      <thead>
        <tr>
          <th scope="col">Code</th>
          <th scope="col">Name</th>
          <th scope="col">Location</th>
          <th scope="col">Num of beds</th>
          <th scope="col">Head doctor</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php
          if (isset($hosQuery)) {
            $res = mysqli_query($connection, $hosQuery);
            if (!$res) {
              die("databases query failed.");
            }
            while ($row = mysqli_fetch_assoc($res)) {
              echo "<tr>";
              echo "<td>" . $row['hoscode'] . "</td>";
              echo "<td>" . $row['hosname'] . "</td>";
              echo "<td>" . $row['city'] . ", " . $row['prov'] . "</td>";
              echo "<td>" . $row['numofbed'] . "</td>";
              echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
              echo "</tr>";
            }
            mysqli_free_result($res);
          }
        ?>
      </tbody>
    </table>
  </div>

  <hr>

  <!-- Update beds -->
  <form id="beds" class="beds container mt-3" action="updatebeds.php" method="post" enctype="multipart/form-data">
    <h3 class="pb-1">Update hospital bed count</h3>
    <!-- Update alert -->
    <?php
      if (isset($_SESSION['setBeds_message'])) {
        echo "<div class=\"alert alert-" . $_SESSION['setBeds_status'] . " alert-dismissible fade show\" role=\"alert\">";
        echo $_SESSION['setBeds_message'];
        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
        echo "</div>";
        unset($_SESSION['setBeds_message']);
        unset($_SESSION['setBeds_status']);
      }
    ?>
    <div class="row">
      <!-- hospital -->
      <div class="col-6">
        <select required class="form-select" name="hos">
          <option selected disabled><strong>Select hospital</strong></option>
          <?php
            $hosQuery = "SELECT hoscode, hosname FROM hospital;";
            $res = mysqli_query($connection, $hosQuery);
            if (!$res) {
              die("databases query failed.");
            }
            while ($row = mysqli_fetch_assoc($res)) {
              echo "<option value=\"" . $row['hoscode'] . "\">";
              echo $row['hoscode'] . ": " . $row['hosname'];
              echo "</option>";
            }
            mysqli_free_result($res);
          ?>
        </select>
      </div>
      <!-- bed count -->
      <div class="col-6 input-group w-50">
        <span class="input-group-text" id="beds-count">Number of beds</span>
        <input
          required
          type="number" 
          class="form-control" 
          aria-describedby="beds-count"
          name="beds"
          placeholder="Number of beds"
        >
      </div>
    </div>
    <br>
    <input type="submit" value="Update beds" class="btn btn-primary">
  </form>

  <div class="footer mt-3">
    <p class="text-center my-auto">48's head hurts from all the PHP 😫</p>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>

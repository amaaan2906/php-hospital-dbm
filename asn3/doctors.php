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
    <h2 class="text-center my-auto">Hospital Database</h2>
  </div>
  <!-- Add new doctor form -->
  <form class="new container mt-3" action="newdoctor.php" method="post" enctype="multipart/form-data">
    <h3 class="pb-1">Add new doctor</h3>
    <!-- Add alert -->
    <?php
      if (isset($_SESSION['newDoctor_message'])) {
        echo "<div class=\"alert alert-" . $_SESSION['newDoctor_status'] . " alert-dismissible fade show\" role=\"alert\">";
        echo $_SESSION['newDoctor_message'];
        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
        echo "</div>";
        unset($_SESSION['newDoctor_message']);
        unset($_SESSION['newDoctor_status']);
      }
    ?>
    <div class="row"> 
      <!-- firstname -->
      <div class="col input-group mb-3">
        <span class="input-group-text" id="new-firstname">First name</span>
        <input
          required
          type="text" 
          class="form-control" 
          aria-describedby="new-firstname"
          name="firstname"
          placeholder="John"
        >
      </div>
      <!-- lastname -->
      <div class="col input-group mb-3">
        <span class="input-group-text" id="new-lastname">Last name</span>
        <input 
          required
          type="text" 
          class="form-control" 
          aria-describedby="new-lastname"
          name="lastname"
          placeholder="Doe"
        >
      </div>
      <!-- birthdate -->
      <div class="col input-group mb-3">
        <span class="input-group-text" id="new-birthdate">Birthdate</span>
        <input 
          required
          type="date" 
          class="form-control" 
          aria-describedby="new-birthdate"
          name="birthdate"
        >
      </div>
    </div>
    <div class="row">
      <!-- licensenum -->
      <div class="col input-group mb-3">
        <span class="input-group-text" id="new-licensenum">License Number</span>
        <input
          required
          type="text" 
          class="form-control" 
          aria-describedby="new-licensenum"
          name="licensenum"
          placeholder="AA00"
        >
      </div>
      <!-- licensedate -->
      <div class="col input-group mb-3">
        <span class="input-group-text" id="new-licensedate">License Date</span>
        <input
          required
          type="date" 
          class="form-control" 
          aria-describedby="new-licensedate"
          name="licensedate"
        >
      </div>
    </div>
    <div class="row">
      <!-- Specialty -->
      <div class="col input-group mb-3">
        <span class="input-group-text" id="new-speciality">Specialty</span>
        <input
          required
          type="text" 
          class="form-control" 
          aria-describedby="new-speciality"
          name="speciality"
          placeholder="eg: Surgeon"
        >
      </div>
      <!-- Hospital -->
      <div class="col">
        <select required class="form-select" name="hosworksat">
          <option selected disabled><strong>Hospital</strong></option>
          <?php
            $hosQuery = "SELECT hoscode, hosname FROM hospital;";
            $res = mysqli_query($connection,$hosQuery);
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
    </div>
    <input type="submit" value="Add doctor" class="btn btn-primary">
  </form>
  
  <hr>

  <!-- Filters -->
  <form class="filter container mt-3" action="doctors.php" method="post" enctype="multipart/form-data">
    <h3 class="pb-1">Doctor table</h3>
    <?php
      if (isset($_SESSION['deleteDoctor_message'])) {
        echo "<div class=\"alert alert-" . $_SESSION['deleteDoctor_status'] . " alert-dismissible fade show\" role=\"alert\">";
        echo $_SESSION['deleteDoctor_message'];
        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
        echo "</div>";
        unset($_SESSION['deleteDoctor_message']);
        unset($_SESSION['deleteDoctor_status']);
      }

      $sort = $_POST['sort'] ?? "lastname";;
      $currSort = $sort === "lastname" ? 'Last Name' : 'Birthdate';
      $order = $_POST['order'] ?? "ASC";
      $currOrder = $order === "ASC" ? 'Ascending' : 'Descending';
      $special = $_POST['special'] ?? '';
      $currSpecial = $special === "" ? 'All' : $special;
    ?>
    <div class="row">
      <!-- Sort By -->
      <div class="col">
        <span>Sort By</span>
        <br>
        <input class="form-check-input" value="lastname" type="radio" name="sort" id="sort-lastname" checked>
        <label class="form-check-label" for="sort-lastname">
          Last Name
        </label>
        <br>
        <input class="form-check-input" value="birthdate" type="radio" name="sort" id="sort-birthday">
        <label class="form-check-label" for="sort-birthday">
          Birthdate
        </label>
        <br>
        <?php
          echo "<span>Current: " . $currSort . "</span>"
        ?>
      </div>
      <!-- Order By -->
      <div class="col">
        <span>Order By</span>
        <br>
        <input class="form-check-input" value="ASC" type="radio" name="order" id="order-asc" checked>
        <label class="form-check-label" for="order-asc">
          Ascending
        </label>
        <br>
        <input class="form-check-input" value="DESC" type="radio" name="order" id="order-desc">
        <label class="form-check-label" for="order-desc">
          Descending
        </label>
        <br>
        <?php
          echo "<span>Current: " . $currOrder . "</span>"
        ?>
      </div>
      <!-- Specialty -->
      <div class="col">
        <span>Specialty</span>
        <br>
        <select class="form-select" id="special" name="special">
          <option value="" selected>Show all</option>
            <?php
              $specQuery = "SELECT DISTINCT speciality FROM doctor ORDER BY speciality ASC;";
              $res = mysqli_query($connection,$specQuery);
              while ($row = mysqli_fetch_assoc($res)) {
                echo "<option value=\"" . $row['speciality'] . "\">";
                echo $row['speciality'];
                echo "</option>";
              }
              mysqli_free_result($res);
            ?>
        </select>
        <?php
          echo "<span>Current: " . $currSpecial . "</span>"
        ?>
      </div>
    </div>
    <br>
    <input type="submit" value="Apply" class="btn btn-primary">
  </form>
  <br>
  <!-- Doctor table with delete function -->
  <form action="deletedoctor.php" method="post" enctype="multipart/form-data">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">License number</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Birthday</th>
          <th scope="col">License date</th>
          <th scope="col">Hospital</th>
          <th scope="col">Specialty</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $tableQuery = "SELECT * FROM doctor WHERE speciality LIKE \"%" . $special . "\" ORDER BY " . $sort . " " . $order . ";";
          $res = mysqli_query($connection, $tableQuery);
          if (!$res) {
            die("databases query failed.");
          }
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>" . $row['licensenum'] . "</td>";
            echo "<td>" . $row['firstname'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td>" . $row['birthdate'] . "</td>";
            echo "<td>" . $row['licensedate'] . "</td>";
            echo "<td>" . $row['hosworksat'] . "</td>";
            echo "<td>" . $row['speciality'] . "</td>";
            echo "<td><input onclick=\"return confirm('Are you sure you want to do that?');\" type=\"submit\" value=\"X\" class=\"btn btn-primary\" name=\"" . $row['licensenum'] . "\"></td>";
            echo "</tr>";
          }
          mysqli_free_result($res);
        ?>
      </tbody>
    </table>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>

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
    <h2>Hospital Database</h2>
  </div>
  <!-- Show routes -->
  <div class="nav p-3">
    <span><a href="/">Home</a> / Doctor</span>
  </div>
  <!-- Add new doctor form -->
  <?php
    if (isset($_SESSION['newDoctor_message'])) {
      echo $_SESSION['newDoctor_message'];
      unset($_SESSION['newDoctor_message']);
    }
  ?>
  <form class="new container" action="newdoctor.php" method="post" enctype="multipart/form-data">
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
        <span class="input-group-text" id="new-licensedate">License Number</span>
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
          placeholder="AA00"
        >
      </div>
      <!-- Hospital -->
      <div class="col">
        <select required class="form-select" name="hosworksat">
          <option selected disabled>Hospital</option>
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
          ?>
        </select>
      </div>
    </div>
    <input type="submit" value="Add doctor" class="btn btn-primary">
  </form>
  <hr>

  <!-- Doctors table -->
  <form action="doctors.php" method="post" enctype="multipart/form-data" class="filter d-flex flex-row justify-content-evenly align-items-center">
    <div class="filter__sort w-25">
      <p>Sort by:</p>
      <div class="form-check">
        <input class="form-check-input" value="lastname" type="radio" name="sort" id="sort-lastname" checked>
        <label class="form-check-label" for="sort-lastname">
          Last Name
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" value="birthdate" type="radio" name="sort" id="sort-birthday">
        <label class="form-check-label" for="sort-birthday">
          Birthday
        </label>
      </div>
      <?php
        echo "<p>Current: " . $_POST['sort'] . "</p>"
      ?>
    </div>
    <div class="filter__order w-25">
      <p>Order by:</p>
      <div class="form-check">
        <input class="form-check-input" value="ASC" type="radio" name="order" id="order-asc" checked>
        <label class="form-check-label" for="order-asc">
          Ascending
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" value="DESC" type="radio" name="order" id="order-desc">
        <label class="form-check-label" for="order-desc">
          Descending
        </label>
      </div>
      <?php
        echo "<p>Current: " . $_POST['order'] . "</p>"
      ?>
    </div>
    <div class="filter__special w-25">
      <p>Specialty: </p>
      <select class="form-select" id="special" name="special">
        <option value="" selected>Show all specialty</option>
        <?php
          $query1 = "SELECT DISTINCT speciality FROM doctor ORDER BY speciality ASC;";
          $result1 = mysqli_query($connection,$query1);
          while ($row = mysqli_fetch_assoc($result1)) {
            echo "<option value=\"" . $row['speciality'] . "\">";
            echo $row['speciality'];
            echo "</option>";
          }
          mysqli_free_result($result1);
        ?>
      </select>
      <?php
        echo "<p>Current: " . $_POST['special'] ?? "All" . "</p>"
      ?>
    </div>
    <input type="submit" value="Apply" class="btn btn-primary">
  </form>
  <hr>
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
      </tr>
    </thead>
    <tbody>
      <?php
        $sortby = $_POST['sort'] ?? 'lastname';
        $sortOrder = $_POST['order'] ?? 'ASC'; // ASC DESC
        $special = $_POST['special'] ?? '';
        $query2 = "SELECT * FROM doctor WHERE speciality LIKE \"%" . $special . "\" ORDER BY " . $sortby . " " . $sortOrder . ";";
        $result2 = mysqli_query($connection,$query2);
        if (!$result2) {
          die("databases query failed.");
        }
        while ($row = mysqli_fetch_assoc($result2)) {
          echo "<tr>";
          echo "<td>" . $row['licensenum'] . "</td>";
          echo "<td>" . $row['firstname'] . "</td>";
          echo "<td>" . $row['lastname'] . "</td>";
          echo "<td>" . $row['birthdate'] . "</td>";
          echo "<td>" . $row['licensedate'] . "</td>";
          echo "<td>" . $row['hosworksat'] . "</td>";
          echo "<td>" . $row['speciality'] . "</td>";
          echo "</tr>";
        }
        mysqli_free_result($result2);
      ?>
    </tbody>
  </table>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>

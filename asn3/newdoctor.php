<?php
  include 'connectdb.php';
  session_start();

  $first = $_POST['firstname'];
  $last = $_POST['lastname'];
  $birthdate = $_POST['birthdate'];
  $licensenum = $_POST['licensenum'];
  $licensedate = $_POST['licensedate'];
  $speciality = $_POST['speciality'];
  $hosworksat = $_POST['hosworksat'];

  $licensenumCheckQuery = "SELECT * FROM doctor WHERE licensenum LIKE \"%" . $licensenum .  "\";";
  $numRows = mysqli_num_rows(mysqli_query($connection, $licensenumCheckQuery));
  if ($numRows > 0) {
    $_SESSION['newDoctor_status'] = "warning";
    $_SESSION['newDoctor_message'] = "Doctor license number cannot be duplicated";
  } else {
    $insertQuery = 'INSERT INTO doctor (licensenum, firstname, lastname, licensedate, birthdate, hosworksat, speciality) VALUES ("' . $licensenum . '", "' . $first . '", "' . $last . '", "' . $licensedate . '", "' . $birthdate . '", "' . $hosworksat . '", "' . $speciality . '");';
    if (!mysqli_query($connection, $insertQuery)) {
      die ("Error while trying to add new doctor". mysqli_error($connection));
    } else {
      $_SESSION['newDoctor_status'] = "success";
      $_SESSION['newDoctor_message'] = "Doctor " . $last . " added successfully!";
    }
  }
  header('Location: doctors.php');
  exit;
?>

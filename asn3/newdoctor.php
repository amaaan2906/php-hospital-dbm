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
    $_SESSION['newDoctor_message'] = "Doctor license number cannot be duplicated";
  } else {
    $_SESSION['newDoctor_message'] = "Doctor " . $last . " added successfully!";
  }
  header('Location: doctors.php');
  exit;
?>

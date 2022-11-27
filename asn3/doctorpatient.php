<?php
  include 'connectdb.php';
  session_start();
  
  $licensenum = $_POST['licensenum'];
  $ohipnum = $_POST['ohipnum'];

  $existsQuery = "SELECT * FROM looksafter WHERE licensenum = \"" . $licensenum . "\" AND ohipnum = \"" . $ohipnum . "\";";
  if (mysqli_num_rows(mysqli_query($connection, $existsQuery)) > 0) {
    $_SESSION['doctorpatient_status'] = "warning";
    $_SESSION['doctorpatient_message'] = "Doctor is already treating patient";
  } else {
    $insertQuery = "INSERT INTO looksafter (ohipnum, licensenum) VALUES (\"" . $ohipnum . "\", \"" . $licensenum . "\");";
    if (!mysqli_query($connection, $insertQuery)) {
      $_SESSION['doctorpatient_status'] = "warning";
      $_SESSION['doctorpatient_message'] = "Error while trying to assign patient to doctor: " . mysqli_error($connection);
    } else {
      $_SESSION['doctorpatient_status'] = "success";
      $_SESSION['doctorpatient_message'] = "Doctor assigned to patient successfully!";
    }
  }

  header('Location: doctors.php');
  exit;
?>

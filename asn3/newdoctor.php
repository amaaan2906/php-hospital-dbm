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

  if (strlen($licensenum) != 4) {
    // invalid license number length
    $_SESSION['newDoctor_status'] = "warning";
    $_SESSION['newDoctor_message'] = "Doctor license number must be 4 characters";
  } else {
    // valid length, check for duplicate
    $licensenumCheckQuery = "SELECT * FROM doctor WHERE licensenum LIKE \"%" . $licensenum .  "\";";
    $numRows = mysqli_num_rows(mysqli_query($connection, $licensenumCheckQuery));
    if ($numRows != 0) {
      $_SESSION['newDoctor_status'] = "warning";
      $_SESSION['newDoctor_message'] = "Doctor license number must be unique";
    } else {
      $insertQuery = 'INSERT INTO doctor (licensenum, firstname, lastname, licensedate, birthdate, hosworksat, speciality) VALUES ("' . $licensenum . '", "' . $first . '", "' . $last . '", "' . $licensedate . '", "' . $birthdate . '", "' . $hosworksat . '", "' . $speciality . '");';
      if (!mysqli_query($connection, $insertQuery)) {
        $_SESSION['newDoctor_status'] = "warning";
        $_SESSION['newDoctor_message'] = "Error while trying to add new doctor: " . mysqli_error($connection);
      } else {
        $_SESSION['newDoctor_status'] = "success";
        $_SESSION['newDoctor_message'] = "Doctor " . $last . " added successfully!";
      }
    }
  }
  mysqli_close($connection);
  header('Location: doctors.php#new');
  exit;
?>

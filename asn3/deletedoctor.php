<?php
  include 'connectdb.php';
  session_start();

  $deleteKey = strval(array_keys($_POST)[0]);
  
  $checkHeadDocQuery = "SELECT * FROM hospital WHERE headdoc LIKE \"%" . $deleteKey . "\";";
  if (mysqli_num_rows(mysqli_query($connection, $checkHeadDocQuery)) {
    $_SESSION['deleteDoctor_status'] = "warning";
    $_SESSION['deleteDoctor_message'] = "Unable to delete a head doctor.";
  } else {
    $checkPatients = "SELECT * FROM looksafter WHERE licensenum LIKE \"%" . $deleteKey . "\";";
    if (mysqli_num_rows(mysqli_query($connection, $checkPatients)) {
      $_SESSION['deleteDoctor_status'] = "warning";
      $_SESSION['deleteDoctor_message'] = "Unable to delete doctor currently treating a patient.";
    } else {
      $deleteQuery = "DELETE FROM doctor WHERE licensenum = '" . $deleteKey . "';";
      $res = mysqli_query($connection, $deleteQuery);
      if (mysqli_affected_rows($connection) === 1) {
        $_SESSION['deleteDoctor_status'] = "success";
        $_SESSION['deleteDoctor_message'] = "Doctor deleted successfully!";
      } else {
        $_SESSION['deleteDoctor_status'] = "danger";
        $_SESSION['deleteDoctor_message'] = mysqli_error($connection);
      }
      mysqli_free_result($res);
    }
  }

  header('Location: doctors.php');
  exit;
?>

<?php
  include "connectdb.php";

  $hos = $_POST['hos'];
  $num = $_POST['beds'];

  $updateQuery = "UPDATE hospital SET numofbed = " . intval($num) . " WHERE hoscode LIKE \"%" . $hos . "\";";

  if (mysqli_query($connection, $updateQuery)) {
    $_SESSION['setBeds_status'] = "success";
    $_SESSION['setBeds_message'] = "Hospital " . $hos . " updated to " . $num . " beds!";
  } else {
    $_SESSION['setBeds_status'] = "warning";
    $_SESSION['setBeds_message'] = "Unable to update hospital " . $hos . " beds!";
  }

  mysqli_close($connection);
  header('Locaiton: hospital.php#beds');
  exit;
?>
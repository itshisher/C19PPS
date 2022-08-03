<?php
require_once 'includes/dbh.php';

if(!isset($_GET['id'])) {
  header('location: cded_orgs.php');
}



$oid = $_GET['id'];
$sql = "DELETE FROM Organizations WHERE oID = $oid;";

if ($connection->query($sql) === TRUE) {
  echo ("<script LANGUAGE='JavaScript'>
                  window.alert('Congrats! You have successfully deleted an organization!');
                  window.location.href='../cded_orgs.php';
              </script>");
} else {
  echo "Error updating record: " . $connection->error;
}


    // @yang execute the DELETE query on the database
    // https://www.php.net/manual/en/book.mysqli.php
    // https://duckduckgo.com/?t=ffab&q=php+delete+mysqli

    // @yang maybe some confirmation prompt "do you really want to delete a user?"
header('location: cded_orgs.php');
?>
    
<?php
    include_once 'footer.php';
?>
<?php
require_once 'includes/dbh.php';

if(!isset($_GET['id'])) {
  header('location: cded_users.php');
}



$uid = $_GET['id'];
$sql = "DELETE FROM User WHERE userID = $uid;";

if ($connection->query($sql) === TRUE) {
  echo ("<script LANGUAGE='JavaScript'>
                  window.alert('Congrats! You have successfully deleted an user!');
                  window.location.href='../cded_users.php';
              </script>");
} else {
  echo "Error updating record: " . $connection->error;
}


    // @yang execute the DELETE query on the database
    // https://www.php.net/manual/en/book.mysqli.php
    // https://duckduckgo.com/?t=ffab&q=php+delete+mysqli

    // @yang maybe some confirmation prompt "do you really want to delete a user?"
header('location: cded_users.php');
?>
    
<?php
    include_once 'footer.php';
?>
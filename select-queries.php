<?php
if (!isset($_GET['qry_id'])) {
  // Show base page listing the available queries
  include_once 'header.php';
  echo <<<EOD
    <section class="select-queries-section">
      <ol start="11">
        <li><a href="select-queries.php?qry_id=11">All articles briefing</a></li>
        <li><a href="select-queries.php?qry_id=12">Removed articles briefing</a></li>
        <li><a href="select-queries.php?qry_id=13">Suspended accounts</a></li>
      </ol>
    </section>
  EOD;
  include_once 'footer.php';

} else {

  $qry_id = $_GET['qry_id'];


  // Select the right query based on GET request
  require_once 'includes/sql.php';
  $sql = $arr_sql[$qry_id];
  $headers = $arr_headers[$qry_id];

  // Validate if query exists
  if (strlen($sql) == 0) {
    header('location: ./select-queries.php'); // base page listing
    exit();
  }


  // Perform SELECT query and get result
  require_once 'includes/dbh.php';
  $result = $connection->query($sql);


  // Display result page
  include_once 'header.php';

  echo '<section class="select-queries-section">';

  require_once 'includes/functions.php';
  display_qry_result($result, $headers);

  echo '</section>';

  include_once 'footer.php';


  unset($qry_id);
  unset($sql);
  unset($headers);
  unset($result);
}
?>

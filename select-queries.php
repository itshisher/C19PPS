<?php
if (!isset($_GET['qry_id'])) {
  // Show base page listing the available queries
  include_once 'header.php';
  echo <<<EOD
    <section class="select-queries-section">
      <ol start="11">
        <li><a href="select-queries.php?qry_id=11">All articles briefing</a></li>
        <li><a href="select-queries.php?qry_id=12">All removed articles</a></li>
        <li><a href="select-queries.php?qry_id=13">Suspended users</a></li>
        <li><a href="select-queries.php?qry_id=14">Articles of an author</a></li>
        <li><a href="select-queries.php?qry_id=15">All publishers</a></li>
        <li><a href="select-queries.php?qry_id=16">Authors and publications</a></li>
        <li><a href="select-queries.php?qry_id=17">Virus progress all countries</a></li>
        <li><a href="select-queries.php?qry_id=18">All emails</a></li>
        <li><a href="select-queries.php?qry_id=19">Historical reports Canada</a></li>
        <li><a href="select-queries.php?qry_id=20">Subscriptions by author</a></li>
      </ol>
    </section>
  EOD;
  include_once 'footer.php';

  // Query #14 requires an author
} else if ($_GET['qry_id'] == 14 && !isset($_GET['auth'])) {

  $qry_id = $_GET['qry_id'];

  // Get list of authors

  require_once 'includes/dbh.php';
  $sql = 'SELECT DISTINCT author FROM Articles ORDER BY author;';
  $result = $connection->query($sql);


  include_once 'header.php';

  echo <<<EOD
  <section class="select-queries-section">
    <div><a href="select-queries.php">Back</a></div>
    <p>Please select an author to display information for.</p>
    <form action="select-queries.php" method="get">
      <input type="hidden" name="qry_id" value="$qry_id"/>
      <label for="author-select">Author: </label>
      <select name="auth" id="author-select">
  EOD;

  while ($author = $result->fetch_assoc()['author'])
    echo '<option value="' . $author . '">' . htmlspecialchars($author) . '</option>';

  echo <<<EOD
      </select>
      <button type="submit">Confirm</button>
    </form>
  </section>
  EOD;

  include_once 'footer.php';

  // #18 requires a time range
} else if ($_GET['qry_id'] == 18 && (
  !isset($_GET['date1']) || !isset($_GET['time1']) ||
  !isset($_GET['date2']) || !isset($_GET['time2'])
)) {

  $qry_id = $_GET['qry_id'];

  // Choose time range

  include_once 'header.php';

  echo <<<EOD
  <section class="select-queries-section">
    <div><a href="select-queries.php">Back</a></div>
    <p>Please select a time range.</p>
    <form action="select-queries.php" method="get">
      <input type="hidden" name="qry_id" value="$qry_id"/>
      <div>
        <label for="date1">Start date:</label>
        <input type="date" id="date1" name="date1"/>
      </div>
      <div>
        <label for="time1">Start time:</label>
        <input type="time" id="time1" name="time1"/>
      </div>
      <div>
        <label for="date2">End date:</label>
        <input type="date" id="date2" name="date2"/>
      </div>
      <div>
        <label for="time2">End time:</label>
        <input type="time" id="time2" name="time2"/>
      </div>
      <div>
        <button type="submit">Confirm</button>
      </div>
    </form>
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


  // Interpolate SQL query if needed
  if ($qry_id == 14) {
    $auth = $_GET['auth'];
    $sql = str_replace('<<;;>>', $auth, $sql);
    unset($auth);
  }
  if ($qry_id == 18) {
    $sql = str_replace('<<;a;>>', "'$_GET[date1] $_GET[time1]'", $sql);
    $sql = str_replace('<<;b;>>',  "'$_GET[date2] $_GET[time2]'", $sql);
  }

  // Perform SELECT query and get result
  require_once 'includes/dbh.php';
  $result = $connection->query($sql);


  // Display result page
  include_once 'header.php';
  echo '<section class="select-queries-section">';

  echo '<div><a href="select-queries.php">Back</a></div>';

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

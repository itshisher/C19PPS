<?php

/**
 * An array of sql strings.
 *
 * Each string in the array is one of the SELECT requests required
 * to be displayed. In the project description document, these are
 * numbered from 11 to 20.
 */
$arr_sql = array(
  11 => "
SELECT author, majorTopic, minorTopic, pubDate, cName AS citizenship
FROM Articles
LEFT JOIN (
  (
    SELECT CONCAT(firstName, ' ', lastName) AS name, cName
    FROM Users
    LEFT JOIN Countries on citizenshipID=cID
    WHERE privilegeName='researcher'
  ) UNION (
    SELECT oName AS name, cName
    FROM Organizations
    LEFT JOIN Countries on countryID=cID
  )
) Authors ON Articles.author=Authors.name
ORDER BY citizenship, author, pubDate;
",
  12 => "",
  13 => "",
  14 => "",
  15 => "",
  16 => "",
  17 => "",
  18 => "",
  19 => "",
  20 => "",
);

/**
 * A list of list of strings to be displayed as table headers.
 *
 * For each query described in the project requirements (numbers 11 to 20),
 * this array holds a list of the column headers for the query results.
 */
$arr_headers = array(
  11 => ["Author", "Major Topic", "Minor Topic", "Date of Publication", "Country"],
  12 => [],
  13 => [],
  14 => [],
  15 => [],
  16 => [],
  17 => [],
  18 => [],
  19 => [],
  20 => [],
);
?>

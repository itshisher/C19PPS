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
  14 => "
SELECT pubDate, majorTopic, minorTopic, summary, article
FROM Articles
WHERE author='<<;;>>'
ORDER BY pubDate;
",
  15 => "
SELECT author, cName AS citizenship, COUNT(Articles.aID) AS nPub
FROM Articles
INNER JOIN (
  SELECT name, cID
  FROM (
    (
        SELECT CONCAT(firstName, ' ', lastName) AS name, citizenshipID AS cID
        FROM Users
        WHERE privilegeName='researcher'
    ) UNION (
        SELECT oName AS name, countryID AS cID
        FROM Organizations
    )
  ) Authors
) Authors ON Articles.author=Authors.name
LEFT JOIN Countries ON Authors.cID=Countries.cID
GROUP BY Articles.author;
",
  16 => "
SELECT Regions.rName,
  Countries.cName,
  COUNT(Authors.auName) AS nAuthors,
  IFNULL(SUM(Authors.nPub), 0) AS totNumPub
FROM Regions
LEFT JOIN Countries ON Regions.rID=Countries.rID
LEFT JOIN (
  SELECT auName, cID, COUNT(Articles.aID) AS nPub
  FROM (
    (
      SELECT CONCAT(firstName, ' ', lastName) AS auName, citizenshipID AS cID
      FROM Users
      WHERE privilegeName='researcher'
    ) UNION (
      SELECT oName AS auName, countryID AS cID FROM Organizations
    )
  ) _
  LEFT JOIN Articles ON auName=Articles.author
  GROUP BY auName
) Authors ON Countries.cID=Authors.cID
GROUP BY Countries.cID
ORDER BY Regions.rName, nPub DESC;
",
  17 => "
SELECT Regions.rName,
  Countries.cName
  SUM(population) AS cPop,
  SUM(pstVax) AS cVax,
  SUM(pstDeaths) AS cDeaths,
",
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
  14 => ["Date of Publication", "Major Topic", "Minor Topic", "Summary", "Article"],
  15 => ["Author", "Country", "Number of Publications"],
  16 => ["Region", "Country", "Number of Authors", "Number of Publications"],
  17 => [],
  18 => [],
  19 => [],
  20 => [],
);
?>

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
    SELECT CONCAT(uFName, ' ', uLName) AS name, cName
    FROM User
    LEFT JOIN Countries on citizenshipID=cID
    WHERE userType='researchers'
  ) UNION (
    SELECT oName AS name, cName
    FROM Organizations
    LEFT JOIN Countries on countryID=cID
  )
) Authors ON Articles.author=Authors.name
ORDER BY citizenship, author, pubDate;
",
  12 => "
SELECT author, majorTopic, minorTopic, pubDate, cName AS citizenship
FROM Articles
LEFT JOIN (
  (
    SELECT CONCAT(uFName, ' ', uLName) AS name, cName
    FROM User
    LEFT JOIN Countries on citizenshipID=cID
    WHERE userType='researchers'
  ) UNION (
    SELECT oName AS name, cName
    FROM Organizations
    LEFT JOIN Countries on countryID=cID
  )
) Authors ON Articles.author=Authors.name
ORDER BY citizenship, author, pubDate;
",
  13 => "
SELECT userType, username, uFName, uLName, cName, email, phone_number, suspendDate
FROM User
JOIN Countries ON citizenshipID=cID
WHERE isSuspended = true
ORDER BY suspendDate ASC;
",
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
        SELECT CONCAT(uFName, ' ', uLName) AS name, citizenshipID AS cID
        FROM User
        WHERE userType='researchers'
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
      SELECT CONCAT(uFName, ' ', uLName) AS auName, citizenshipID AS cID
      FROM User
      WHERE userType='researchers'
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
SELECT rName, cName,
  SUM(Pst1.pstInjections) AS cInjections,
  SUM(Pst1.pstDeathsTot) AS cDeathsTot,
  SUM(Pst1.pstDeathsVax) AS cDeathsVax,
  SUM(Pst2.pstPopulation) AS cPopulation
FROM Countries
RIGHT JOIN Regions ON Countries.rID=Regions.rID
LEFT JOIN ProStaTe ON Countries.cID=ProStaTe.cID
LEFT JOIN (
  SELECT Vd1.pstID,
    SUM(Vd1.nInjections) AS pstInjections,
    SUM(Vd1.nDeaths) AS pstDeathsTot,
    SUM(Vd2.nDeathsVax) AS pstDeathsVax
  FROM VaccineData Vd1
  LEFT JOIN (
    SELECT pstID, updatedDate, nDeaths AS nDeathsVax
    FROM VaccineData
    WHERE vID IS NOT NULL
  ) Vd2 ON Vd1.pstID=Vd2.pstID AND Vd1.updatedDate=Vd2.updatedDate
  JOIN (
    SELECT pstID, MAX(updatedDate) AS latestDate
    FROM VaccineData
    GROUP BY pstID
  ) Vd3 ON Vd1.pstID=Vd3.pstID AND Vd1.updatedDate=Vd3.latestDate
  GROUP BY Vd1.pstID
) Pst1 ON ProStaTe.pstID=Pst1.pstID
LEFT JOIN (
  SELECT Pop1.pstID,
    SUM(Pop1.population) AS pstPopulation
  FROM Populations Pop1
  JOIN (
    SELECT pstID, MAX(updatedDate) AS latestDate
    FROM Populations
    GROUP BY pstID
  ) Pop2 ON Pop1.pstID=Pop2.pstID AND Pop1.updatedDate=Pop2.latestDate
  GROUP BY Pop1.pstID
) Pst2 ON ProStaTe.pstID=Pst2.pstID
GROUP BY Countries.cID
ORDER BY cDeathsTot;
",
  18 => "
SELECT timeSent, email, subject
FROM Notifications N
JOIN User U ON N.userID=U.userID
WHERE timeSent >= <<;a;>>
  AND timeSent <= <<;b;>>
ORDER BY timeSent;
",
  19 => "
SELECT Base.updatedDate,
  SUM(Pop.population) AS cPop,
  SUM(Vd1.nInjections) AS nInj1,
  SUM(Vd2.nInjections) AS nInj2,
  SUM(Vd3.nInjections) AS nInj3,
  SUM(Vd4.nInjections) AS nInj4,
  SUM(Vd.nInfections) AS cInf,
  SUM(Vd1.nDeaths) AS nDeaths1,
  SUM(Vd2.nDeaths) AS nDeaths2,
  SUM(Vd3.nDeaths) AS nDeaths3,
  SUM(Vd4.nDeaths) AS nDeaths4
FROM ((SELECT pstID, updatedDate FROM VaccineData) UNION (SELECT pstID, updatedDate FROM Populations)) Base
JOIN ProStaTe Pst ON Base.pstID=Pst.pstID AND Pst.cID=2 -- Canada
LEFT JOIN (SELECT * FROM Populations) Pop ON Base.pstID=Pop.pstID AND Base.updatedDate=Pop.updatedDate
LEFT JOIN (SELECT * FROM VaccineData) Vd ON Base.pstID=Vd.pstID AND Base.updatedDate=Vd.updatedDate
LEFT JOIN (SELECT * FROM VaccineData WHERE vID=1) Vd1 ON Base.pstID=Vd1.pstID AND Base.updatedDate=Vd1.updatedDate AND Vd.vID=Vd1.vID
LEFT JOIN (SELECT * FROM VaccineData WHERE vID=2) Vd2 ON Base.pstID=Vd2.pstID AND Base.updatedDate=Vd2.updatedDate AND Vd.vID=Vd2.vID
LEFT JOIN (SELECT * FROM VaccineData WHERE vID=3) Vd3 ON Base.pstID=Vd3.pstID AND Base.updatedDate=Vd3.updatedDate AND Vd.vID=Vd3.vID
LEFT JOIN (SELECT * FROM VaccineData WHERE vID=4) Vd4 ON Base.pstID=Vd4.pstID AND Base.updatedDate=Vd4.updatedDate AND Vd.vID=Vd4.vID
GROUP BY Base.updatedDate
ORDER BY Base.updatedDate DESC
",
  20 => "
(
  SELECT CONCAT(uFName, ' ', uLName) AS name, cName, COUNT(Sub.userID) AS numSub
  FROM User
  JOIN Countries ON citizenshipID=cID
  JOIN Subscription Sub ON User.userID=Sub.authorID
    AND Sub.authorType='researchers'
  GROUP BY User.userID
) UNION (
  SELECT oName AS name, cName, COUNT(Sub.userID) AS numSub
  FROM Organizations Org
  JOIN Countries ON countryID=cID
  JOIN Subscription Sub ON Org.oID=Sub.authorID
    AND Sub.authorType='organization'
  GROUP BY Org.oID
)
ORDER BY numSub DESC;
",
);

/**
 * A list of list of strings to be displayed as table headers.
 *
 * For each query described in the project requirements (numbers 11 to 20),
 * this array holds a list of the column headers for the query results.
 */
$arr_headers = array(
  11 => ["Author", "Major Topic", "Minor Topic", "Date of Publication", "Country"],
  12 => ["Author", "Major Topic", "Minor Topic", "Date of Publication", "Country"],
  13 => ["Privilege Name", "Username", "First Name", "Last Name", "Citizenship", "Email", "Phone", "Suspension Date"],
  14 => ["Date of Publication", "Major Topic", "Minor Topic", "Summary", "Article"],
  15 => ["Author", "Country", "Number of Publications"],
  16 => ["Region", "Country", "Number of Authors", "Number of Publications"],
  17 => ["Region", "Country", "Injections", "Total Deaths", "Vaccinated Deaths", "Population"],
  18 => ["Time Sent", "Email", "Subject"],
  19 => ["Report Date", "Population", "#Pfizer", "#Moderna", "#AstraZeneca", "#Johnson&Johnson",
         "Infections", "Deaths Pfizer", "Deaths Moderna", "Deaths AstraZeneca", "Deaths Johnson&Johnson"],
  20 => ["Author", "Citizenship", "Number of Subscribers"],
);
?>

<?php
require_once('./conf.php');
$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};

/*
6. Készítsen összesítést az adatokból, amelynek eredményét mentse osszesites.csv
állományba! <br> Az állomány minden sora – pontosvesszővel elválasztva – tartalmazza a
nyelvet, a kilenc év alatti összes vizsga számát és a sikeres vizsgák arányát két
tizedesjegyre kerekítve!
*/

$createCsv = fopen("osszesites.csv  ", "w") or die("Fájl megnyitása nem lehetséges!");
fclose($createCsv);



$sql = "SELECT   sikeresvizs.nyelv AS nyelv, 
(sikeresvizs._2009+sikeresvizs._2010+sikeresvizs._2011+sikeresvizs._2012+sikeresvizs._2013+sikeresvizs._2014
+sikeresvizs._2015+sikeresvizs._2016+sikeresvizs._2017+sikeresvizs._2018+sikertelenvizs._2009+sikertelenvizs._2010
+sikertelenvizs._2011+sikertelenvizs._2012+sikertelenvizs._2013+sikertelenvizs._2014+sikertelenvizs._2015+sikertelenvizs._2016
+sikertelenvizs._2017+sikertelenvizs._2018) AS osszeg,
ROUND((((sikertelenvizs._2009+sikertelenvizs._2010+sikertelenvizs._2011+sikertelenvizs._2012+sikertelenvizs._2013+sikertelenvizs._2014
+sikertelenvizs._2015+sikertelenvizs._2016+sikertelenvizs._2017+sikertelenvizs._2018)/
(sikeresvizs._2009+sikeresvizs._2010+sikeresvizs._2011+sikeresvizs._2012+sikeresvizs._2013+sikeresvizs._2014
+sikeresvizs._2015+sikeresvizs._2016+sikeresvizs._2017+sikeresvizs._2018+sikertelenvizs._2009+sikertelenvizs._2010
+sikertelenvizs._2011+sikertelenvizs._2012+sikertelenvizs._2013+sikertelenvizs._2014+sikertelenvizs._2015+sikertelenvizs._2016
+sikertelenvizs._2017+sikertelenvizs._2018)))*100, 2) AS arany
FROM sikeresvizs, sikertelenvizs WHERE sikeresvizs.nyelv= sikertelenvizs.nyelv";
$result = mysqli_query($conn, $sql);



$writeCsv = fopen("osszesites.csv", "a") or die("Fájl megnyitása nem lehetséges!");

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($writeCsv, $row, ";");
}

fclose($writeCsv);

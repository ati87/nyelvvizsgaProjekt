<?php
require_once('./conf.php');
$conn = mysqli_connect("localhost", "root", "", "blog");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h4>2.Határozza meg és írja ki a képernyőre, hogy a kilenc év sikeres és sikertelen vizsgáit
        összegezve melyik 3 nyelv volt a legnépszerűbb! <br> A kiírás során a nyelvek népszerűségi
        sorrendben jelenjenek meg! (Feltételezheti, hogy nem alakult ki holtverseny.)</h4>

    <?php
    $sql = "SELECT  sikeresvizs.nyelv as nyelv, SUM(sikeresvizs._2009+sikeresvizs._2010+sikeresvizs._2011+sikeresvizs._2012+sikeresvizs._2013+sikeresvizs._2014
+sikeresvizs._2015+sikeresvizs._2016+sikeresvizs._2017+sikeresvizs._2018+
sikertelenvizs._2009+sikertelenvizs._2010+sikertelenvizs._2011+sikertelenvizs._2012+sikertelenvizs._2013+sikertelenvizs._2014
+sikertelenvizs._2015+sikertelenvizs._2016+sikertelenvizs._2017+sikertelenvizs._2018) as total
FROM sikeresvizs, sikertelenvizs WHERE sikeresvizs.nyelv = sikertelenvizs.nyelv
GROUP BY nyelv  ORDER BY total desc LIMIT 3";
    //itt biztos van rövidebb megoldás a lekérdezésre
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            print($row['nyelv']);
            print('<br>');
        }
    } else {
        print("Nincs eredmény");
    }
    ?>
    <h4>3. Kérjen be a felhasználótól egy évet! Ellenőrizze, hogy a bekért év 2009 és 2017 között
        van! A program futása csak akkor folytatódjon, ha a felhasználó helyes értéket ad meg.
        (Feltételezheti, hogy a felhasználó számot ad meg.)</h4>
    <h4>4. Határozza meg, hogy a 3. feladat során bekért évben melyik volt az a nyelv, amely
        esetében a legnagyobb volt a sikertelen vizsgák aránya! <br>(Az arány meghatározásánál
        vegye figyelembe a sikertelen és az összes vizsga számát!) <br>A nyelv mellett – két
        tizedesjegy pontossággal – írja ki azt is, hogy mekkora volt a sikertelen vizsgák aránya!<br>
        Ha a 3. feladatot nem tudta megoldani, akkor a 2014-es évvel számoljon!
    </h4>
    <form action="nyelvvizsga.php" method="POST">
        <label for="year">Írjon be egy évszáom 2009 és 2017 között</label>
        <input type="number" id='year' name="year" min="2009" max="2017">
        <input type="submit">
    </form>
    <?php
    if (isset($_POST['year']) && is_numeric($_POST['year'])) {
        $year = $_POST['year'];
        if (2008 < $year && 2018 > $year) {
            $yearSql = '_' . $_POST['year'];
            //  print($yearSql);
            $sql2 = "SELECT  sikeresvizs.nyelv as nyelv,  
            ROUND(((sikertelenvizs.$yearSql/(sikertelenvizs.$yearSql+sikeresvizs.$yearSql))*100), 2) AS total
            FROM sikeresvizs, sikertelenvizs WHERE sikeresvizs.nyelv = sikertelenvizs.nyelv GROUP BY nyelv  
            ORDER BY total  desc   LIMIT 1";
            $result2 = mysqli_query($conn, $sql2);
            while ($row2 = mysqli_fetch_array($result2)) {

                print($year . '-ben a(z) ' . $row2['nyelv'] . ' nyelvből a sikertelen vizsgák aránya ' . $row2['total'] . '%');
            }
        } else {
            print('Az évszám nem 2009 és 2017 között van megadva');
        }
    }
    ?>
    <h4>5. Írja ki a képernyőre azon nyelveket, amelyekből a 3. feladatban megadott évben nem
        volt egyetlen vizsgázó sem. <br> Ha nem volt ilyen nyelv, akkor írja ki, hogy „Minden
        nyelvből volt vizsgázó” Ha a 3. feladatot nem tudta megoldani, akkor a 2014-es
        évvel számoljon!
    </h4>
    <?php
    if (isset($_POST['year']) && is_numeric($_POST['year'])) {
        if (2008 < $year && 2018 > $year) {
            $yearSql = '_' . $_POST['year'];
            $sql3 = "SELECT  sikeresvizs.nyelv as nyelv FROM sikeresvizs, sikertelenvizs  
            WHERE sikeresvizs.nyelv = sikertelenvizs.nyelv AND sikertelenvizs.$yearSql=0 AND sikeresvizs.$yearSql=0";
            $result3 = mysqli_query($conn, $sql3);
            while ($row3 = mysqli_fetch_array($result3)) {

                print($row3['nyelv']);
                print('<br>');
            }
        } else {
            print('Az évszám nem 2009 és 2017 között van megadva');
        }
    }
    ?>
   

</body>

</html>
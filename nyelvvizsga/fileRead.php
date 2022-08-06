<?php
require_once('./conf.php');

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};

//a táblákat és oszlopait előre létrehoztam a HeidiSQL-ben
// a nyelv oszlop értékei átlettek nevezve, mert a fájl beolvasásál nem jelenítette meg az ékezetes betűket

$fileOpen = fopen('./sikeres.csv', 'r') or exit("A fájl nem található");
$row = 0;
while (($di = fgetcsv($fileOpen, 10000, ";")) !== FALSE){
    if ($row > 0)  {
            
            $sql = "INSERT INTO sikeresvizs (nyelv, _2009, _2010, _2011, _2012, _2013, _2014, _2015, _2016, _2017, _2018) VALUES 
            ('{$di[0]}','{$di[1]}','{$di[2]}','{$di[3]}','{$di[4]}','{$di[5]}','{$di[6]}','{$di[7]}','{$di[8]}','{$di[9]}','{$di[10]}')";
            $result = mysqli_query($conn, $sql);
           
        }
         $row++;
    }
fclose($fileOpen);

$fileOpen = fopen('./sikertelen.csv', 'r') or exit("A fájl nem található");
$row = 0;
while (($di = fgetcsv($fileOpen, 10000, ";")) !== FALSE){
    if ($row > 0)  {
            
            $sql2 = "INSERT INTO sikertelenvizs (nyelv, _2009, _2010, _2011, _2012, _2013, _2014, _2015, _2016, _2017, _2018) VALUES 
            ('{$di[0]}','{$di[1]}','{$di[2]}','{$di[3]}','{$di[4]}','{$di[5]}','{$di[6]}','{$di[7]}','{$di[8]}','{$di[9]}','{$di[10]}')";
            $result = mysqli_query($conn, $sql2);
           
        }
         $row++;
    }
fclose($fileOpen);
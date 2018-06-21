<?php

header("Access-Control-Allow-Origin: *");

$DEBUG = 0;

if($DEBUG==1) {
    echo"<pre>";
}

include("dbconnect.php");
include("functions.php");

$code           = " select                          ";
$code          .= "     *                           ";
$code          .= " from                            ";
$code          .= "     Ergebnisse        ";


$Anzahl_Daten = 0;

echo " 

{ 
     \"success\"     :    true ,
     \"Sahin\"       :    \"cool\",

";

echo"

     \"result\"      : {

";

$anfrage        = dbsearch_mysql("$code");    
while($ergebnis = dbout_mysql($anfrage)) {         
    
    $Anzahl_Daten++;
    
    $ergebnissID     = $ergebnis["ergebnissID"];                
    $tuweID   = $ergebnis["tuweID"];
    $schuelerID    = $ergebnis["schuelerID"];
    $ergebnis    = $ergebnis["ergebnis"];

    echo"
        \"ergebniss_$ergebnissID\"   : {

            \"ergebnissID\"    :   \"$ergebnissID\"   ,
            \"tuweID\"  :   \"$tuweID\" ,
            \"schuelerID\"   :   \"$schuelerID\"  ,
            \"ergebnis\"   :   \"$ergebnis\"  ,

            \"done\"      :   1
        }, 

    ";

}




echo"
        \"done_all\"  : { 

            \"All_true\"    : \"yes\"

        }
     
     }

}

";

if($DEBUG==1) {
    echo"<pre>";
}

?>
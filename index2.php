<?php


if(!isset($_POST["schueler_ID"])) {    
        $schueler_ID = "";
} else {
    $schueler_ID = $_POST["schueler_ID"];
}

if(!isset($_POST["wettkampf_ID"])) {    
        $wettkampf_ID = "";
} else {
    $wettkampf_ID = $_POST["wettkampf_ID"];
}

if(!isset($_POST["klasse_name"])) {    
        $klasse_name = "";
} else {
    $klasse_name = $_POST["klasse_name"];
}



#include "query_wettkampf.php";
include "dbconnect.php";

echo"<!DOCTYPE HTML>";
echo"<html>";
	echo"<head>";  



	echo"<div id=\"chartContainer\" style=\"height: 370px; width: 100%;\"></div>
	<script src=\"https://canvasjs.com/assets/script/canvasjs.min.js\"></script>";
	echo"<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>";


	//echo"var brexit = {};";

		echo"<script type=\"text/javascript\">";
		
		echo"
    window.onload = function () {

				var chart = new CanvasJS.Chart(\"chartContainer\", 

        {
					animationEnabled: true,
					theme: \"light2\", // \"light1\", \"light2\", \"dark1\", \"dark2\"
					title:{
						text: \"Turnier\"
					},
          axisX: {        
            valueFormatString: \"##\",  
            showInLegend: true, 
            legendMarkerColor: \"grey\",
            legendText: \"Stefan ist cool\",
          },
					axisY: {
						includeZero: true
					},

          data: data,

			 });

				chart.render();

	       }
				";

 echo"</script>";       

// Array erschaffen und befüllen 
  echo"<script src=\"https://canvasjs.com/assets/script/jquery-1.11.1.min.js\"></script>";
  echo"<script src=\"https://canvasjs.com/assets/script/jquery.canvasjs.min.js\"></script>";
  
  echo "<script>";

  echo"
	
	var data = [];
	var dataSeries_1 = {
		                              type: \"column\" ,
                                  showInLegend: true, 
                                  name: \"series1\",
                                  legendText: \"schueler\",
                                  color: \"rgba(255,51,0,0.7)\" ,
                                  xValueFormatString: \"#\"


	};

	var dataPoints_1 = [];

";

echo "</script>";
echo"</head>";
/*
echo "<script>";
echo"

   function get_ergebnisse() {
	 var brexit = {};
          //console.log('hier');

          $.ajax({

              type:           'POST',
              dataType:       'json',        
              url:            'query_wettkampf.php',
              crossDomain:    true,   
              data:     ( {

                  Parameter_1:   'Sahin'     ,
                  Parameter_2:   'Jens'      , 

                  Test:          0
              } ),
            
              success: function (response) {
                            
                  console.log('Ergebnis ist da');                              
                  console.log(JSON.stringify(response));                                           
                  
                  if (response.success === true) {
                  
                      console.log('Ergebnis erfolgreich');   
                           
                      /////////////
                      // Hier muss es für Dich weiter gehen
                      // 1) Alle ankommenden Orte durchgehen (  $.each   )
                      // 2) Diese in ein globales Javascript-Objekt packen
                      // 3) DIeses Objekt in einer aneren Funktion weiter verwenden


                      $.each(response.result, function(i, item) {                          
                          var ID_Container = response.result[i];
                          console.log(i);

                            brexit[i] = {};

                            $.each(ID_Container, function(j, item2){
                                console.log(j);
                                var helpita = ID_Container[j];
                                console.log(j + helpita);
                                brexit[i][j] = ID_Container[j];

                            });

                            console.log(i);

                      });

                      console.log(\"Jetzt kommt der Brexit\");
                      console.log(JSON.stringify(brexit));

                      //int = Math.floor(Math.random() * (2 - 1 + 1)) + 1;
                      /*
                      alert(brexit['Geo_'+ int +'']['Geo_Name']);
                      alert(brexit['Geo_'+ int +'']['Geo_Lat']);
                      alert(brexit['Geo_'+ int +'']['Geo_Lng']);               */   

                      //var Geo_ID_1 = response.result.Geo_1.Geo_ID;
                      //var Geo_ID_2 = response.result.Geo_2.Geo_ID;                      

                      //console.log('Geo_ID1 '+ Geo_ID_1);
                      //console.log('Geo_ID2 '+ Geo_ID_2);
/*
                    	alert(brexit['ergebniss_'+ 1 +'']['schuelerID']);


                  }

              },

              error: function (xhr, ajaxOptions, thrownError) {

                  console.error('Ergebnis fehlerhaft');                              
                  console.error(xhr.status);
                  console.error(thrownError);

              }

          });

      }
      ";


      echo" get_ergebnisse()";
echo"</script>";

*/


echo"<body>";

 echo"<script>";
 	          $mysql = " SELECT ";
            $mysql.= "    * ";
            $mysql.= " FROM ";
            $mysql.= " ergebnisse ";
            $mysql.= "    WHERE ";
            $mysql.= "    `schuelerID`  = '$schueler_ID' ";
            $mysql.= "    AND `wettkampfID`   LIKE '$wettkampf_ID' ";

            #$mysql.= " WHERE ";
            #$mysql.= " `schuelerID` LIKE '$schueler_ID' ";
            

             $myresult = $mysql_conn->query($mysql);
            
            if ($myresult->num_rows >= 0) {
                                            
                while($ergebnis = $myresult->fetch_assoc()) {
                
                    
                    $flt_Value    = $ergebnis["ergebnis"];
                    $flt_x = $ergebnis["schuelerID"];
                    #$flt_x    = $schueler_ID;
                    #echo"alert($flt_Value)";          
                    
                    echo"
                    
                    dataPoints_1.push({
                      
                          x: $flt_x,
                          y: $flt_Value
                    });
                     
                    ";         
                    
                }               
                
            }
            echo"
            dataSeries_1.dataPoints = dataPoints_1;
			      data.push(dataSeries_1);
            ";
            
            echo "</script>";


            echo"&nbsp;&nbsp;&nbsp;&nbsp;";

            echo"<br><br>";

            echo"<form id=\"FRM_ID_Form\" action=\"index2.php\" method=\"post\">"; 

            echo"<font class=\"normal\"><b>Schüler Auswählen:</b></font>";
            echo"<br><br>";

            ///////////////////////////////////////////////////////////////////
            /*
              <select id="animal" name="animal">                      
              <option value="0">--Select Animal--</option>
              <option value="1">Cat</option>
              <option value="2">Dog</option>
              <option value="3">Cow</option>
              </select>

              if($_POST['submit'])
              {
              $animal=$_POST['animal'];
              }

                          
              $animals = array('--Select Animal--', 'Cat', 'Dog', 'Cow');
              $selected_key = $_POST['animal'];
              $selected_val = $animals[$_POST['animal']];
              */
              ///////////////////////////////////////////////////////////////////

                echo"<select class=\"Selectfeld\" id=\"schuelerID\" name=\"schueler_ID\">";
                
                $mysql = " SELECT ";
                $mysql.= "    * ";
                $mysql.= " FROM ";
                $mysql.= "    ergebnisse  ";
                $mysql.= "    JOIN ";
                $mysql.= "    schueler ";
                $mysql.= "    ON ";
                $mysql.= "    ergebnisse.schuelerID = schueler.schuelerID ";
                $mysql.= "    GROUP BY ";
                $mysql.= "    schueler.schuelerID ";
                #$mysql.= "    WHERE ";
                #$mysql.= "    `schuelerID` LIKE '$schueler_ID' ";

                /*

                alt
                $mysql = " SELECT ";
                $mysql.= "    * ";
                $mysql.= " FROM ";
                $mysql.= "    ergebnisse ";
                $mysql.= "    GROUP BY ";
                $mysql.= "    schuelerID ";

                */

                /*

                $mysql = " SELECT ";
                $mysql.= "    schuelerID ";
                $mysql.= " FROM ";
                $mysql.= "    schueler ";
                $mysql.= "    WHERE ";
                $mysql.= "    `klassenID` = '$klassenID_klasse_name' ";

                */
                
                $myresult = $mysql_conn->query($mysql);
                
                if ($myresult->num_rows > 0) {
                                                
                    while($ergebnis = $myresult->fetch_assoc()) {
                    
                        $schuelerID  = $ergebnis["schuelerID"];
                        $schuelername = $ergebnis["vorname"];
                        #$schuelerID_Schueler = $schuelerID . " " . $schuelername;
                        
                        if($schueler_ID==$schuelerID) {$sel = "selected";} else {$sel="";}
                        echo"<option $sel value=\"$schuelerID\">$schuelername</option>";
                        
                    }
                    
                }

               
            echo"</select>";

            echo"&nbsp;&nbsp;&nbsp;&nbsp;";
            
            echo"<br><br>";

            echo"<font class=\"normal\"><b>Wettkampf:</b></font>";
            echo"<br><br>";
            
            echo"<select class=\"Selectfeld\" id=\"wettkampfID\" name=\"wettkampf_ID\">";
                
                $mysql = " SELECT ";
                $mysql.= "    * ";
                $mysql.= " FROM ";
                $mysql.= "    ergebnisse  ";
                $mysql.= "    JOIN ";
                $mysql.= "    wettkampf ";
                $mysql.= "    ON ";
                $mysql.= "    ergebnisse.wettkampfID = wettkampf.wettkampfID ";
                $mysql.= "    GROUP BY ";
                $mysql.= "    ergebnisse.wettkampfID ";

                /*
                alt F4
                $mysql = " SELECT ";
                $mysql.= "    wettkampfID ";
                $mysql.= " FROM ";
                $mysql.= "    ergebnisse ";
                $mysql.= "    GROUP BY ";
                $mysql.= "    wettkampfID ";
                
                */

                $myresult = $mysql_conn->query($mysql);
                
                if ($myresult->num_rows > 0) {
                                                
                    while($ergebnis = $myresult->fetch_assoc()) {
                    
                        $wettkampfart  = $ergebnis["art"];
                        $wettkampfID = $ergebnis["wettkampfID"];
                          
                        if($wettkampf_ID==$wettkampfID) {$sel = "selected";} else {$sel="";}
                        echo"<option $sel value=\"$wettkampfID\">$wettkampfart</option>";
                        
                    }
                    
                }
                
            echo"</select>";


            echo"&nbsp;&nbsp;&nbsp;&nbsp;";
            
            echo"<br><br>";
            echo"<font class=\"normal\"><b>Klassen:</b></font>";
            echo"<br><br>";
            
            echo"<select class=\"Selectfeld\" name=\"klasse_name\">";

            /*
            SELECT * FROM ergebnisse JOIN schueler 
            ON ergebnisse.schuelerID = schueler.schuelerID 
            JOIN klasse 
            ON schueler.klassenID = klasse.klassenID 
            WHERE schueler.schuelerID = 1 
            GROUP BY ergebnisse.schuelerID = 1
            */

                $mysql = " SELECT ";
                $mysql.= "    * ";
                $mysql.= " FROM ";
                $mysql.= "    ergebnisse  ";
                $mysql.= "    JOIN ";
                $mysql.= "    schueler ";
                $mysql.= "    ON ";
                $mysql.= "    ergebnisse.schuelerID = schueler.schuelerID ";
                $mysql.= "    JOIN ";
                $mysql.= "    klasse ";
                $mysql.= "    ON ";
                $mysql.= "    schueler.klassenID = klasse.klassenID ";
                #$mysql.= "    WHERE";
                #$mysql.= "    schueler.schuelerID = 1 ";
                $mysql.= "    GROUP BY ";
                $mysql.= "    klasse.klassenID ";
                
                //ergebnisse.schuelerID = 1

                /*
                alt F4
                $mysql = " SELECT ";
                $mysql.= "    * ";
                $mysql.= " FROM ";
                $mysql.= "    klasse ";
                */
                $myresult = $mysql_conn->query($mysql);
                
                if ($myresult->num_rows > 0) {
                                                
                    while($ergebnis = $myresult->fetch_assoc()) {
                    
                        $klasse  = $ergebnis["name"];
                        $klassenID = $ergebnis["klassenID"];
                        #$klassenID_klasse = $klasse . " " . $klassenID;
                          
                        if($klasse_name==$klasse) {$sel = "selected";} else {$sel="";}
                        echo"<option $sel value=\"$klasse\">$klasse</option>";
                        
                    }
                    
                }
                
            echo"</select>";


            echo"<br><br><br>";
            
            echo"<acronym onclick=\"document.getElementById('FRM_ID_Form').submit();\" type=\"submit\" style=\"width:40px;\" class=\"button\">go</acronym>";

          echo"</form>";

          ////////////////////////////////////////
          //Bestimmung wie lange das Turnier noch dauert.
                $mysql = " SELECT ";
                $mysql.= "    Count(schuelerID) ";
                $mysql.= " FROM ";
                $mysql.= "    schueler ";
                $mysql.= "    GROUP BY ";
                $mysql.= "    schuelerID ";
                
                $myresult = $mysql_conn->query($mysql);
                
                if ($myresult->num_rows > 0) {
                                                
                    while($ergebnis = $myresult->fetch_assoc()) {
                    
                        $anzahl_alle  = $ergebnis["Count(schuelerID)"];

                        
                    }
                    
                }

                $mysql = " SELECT ";
                $mysql.= "    Count(schuelerID) ";
                $mysql.= " FROM ";
                $mysql.= "    ergebnisse ";


                
                $myresult = $mysql_conn->query($mysql);
                
                if ($myresult->num_rows > 0) {
                                                
                    while($ergebnis = $myresult->fetch_assoc()) {
                    
                        $anzahl_fertig  = $ergebnis["Count(schuelerID)"];

                      
                    }
                    
                }
                echo"<br><br><br>";

                $nicht_fertig = ($anzahl_fertig-$anzahl_alle)*15;
                $nicht_fertig_anz = $anzahl_fertig-$anzahl_alle;
                echo "Es sind bereits " .$anzahl_fertig. " Fertig. " . "Es gibt noch " . $nicht_fertig_anz  . " Schueler. Das Turnier dauert noch " . $nicht_fertig . " minuten bis alle Schüler fertig sind.";
                //Bestimmung wie lange das Turnier noch dauert.   
                ////////////////////////////////////////

                echo"<br><br><br>";
                /*
                ////////////////////////////////////////
                //Anzeigen Schueler
                $mysql = " SELECT ";
                $mysql.= "    * ";
                $mysql.= " FROM ";
                $mysql.= "    schueler ";
                $mysql.= "    WHERE ";
                $mysql.= "    `schuelerID` LIKE '$schueler_ID' ";

                
                $myresult = $mysql_conn->query($mysql);
                
                if ($myresult->num_rows > 0) {
                                                
                    while($ergebnis = $myresult->fetch_assoc()) {
                    
                        $schueler_vorname  = $ergebnis["vorname"];
                        $schueler_nachname = $ergebnis["nachname"];

                      
                    }
                    
                }

                echo "Schüler: " . $schueler_vorname . " " . $schueler_nachname;
                //Anzeigen Schueler
                ////////////////////////////////////////

                                echo"<br><br><br>";
                ////////////////////////////////////////
                //Anzeigen klasse
                

                $mysql = " SELECT ";
                $mysql.= "    * ";
                $mysql.= " FROM ";
                $mysql.= "    schueler  ";
                $mysql.= "    JOIN ";
                $mysql.= "    klasse ";
                $mysql.= "    ON ";
                $mysql.= "    klasse.klassenID = schueler.klassenID ";
                $mysql.= "    WHERE ";
                $mysql.= "    `schuelerID` LIKE '$schueler_ID' ";

                
                $myresult = $mysql_conn->query($mysql);
                
                if ($myresult->num_rows > 0) {
                                                
                    while($ergebnis = $myresult->fetch_assoc()) {
                    
                        $klassenname  = $ergebnis["name"];
                        

                      
                    }
                    
                }

                echo "Klasse: " . $klassenname;
                //Anzeigen klasse
                ////////////////////////////////////////
                */

  echo"</body>";
echo"</html>";

?>
<?php

include "query_wettkampf.php";
include "dbconnect.php";

echo"<!DOCTYPE HTML>";
echo"<html>";
	echo"<head>";  



	echo"<div id=\"chartContainer\" style=\"height: 370px; width: 100%;\"></div>
	<script src=\"https://canvasjs.com/assets/script/canvasjs.min.js\"></script>";
	echo"<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>";
	echo"var brexit = {};";
		echo"<script type=\"text/javascript\">";
		
		echo"window.onload = function () {

				var chart = new CanvasJS.Chart(\"chartContainer\", {
					animationEnabled: true,
					theme: \"light2\", // \"light1\", \"light2\", \"dark1\", \"dark2\"
					title:{
						text: \"Guys NIGHT\"
					},
					axisY: {
						title: \"Reserves(MMbbl)\"
					},
					data: [{        
						type: \"column\",  
						showInLegend: true, 
						legendMarkerColor: \"grey\",
						legendText: \"MMbbl = one million barrels\",
						dataPoints: [      
							{ y: 1, label: \"Tequila\" },
							{ y: 2,  label: \"Gin Basil\" },
							{ y: 3,  label: \"GreyGoose\" },
							{ y: 4,  label: \"Caipirinha\" }
						]
					}]
				});
				chart.render();

				}
				";

// Array erschaffen und befüllen 

echo "
	
	var data = [];
	var dataSeries_1 = {
		                          type: \"bar\" ,
                                  showInLegend: true, 
                                  name: \"series1\",
                                  legendText: \"schueler\",
                                  color: \"rgba(255,51,0,0.7)\" ,
                                  xValueFormatString: \"#####\"


	};

	var dataPoints_1 = [];

";


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



echo"</head>
<body>";

 echo"<script>";
 	        $mysql = " SELECT ";
            $mysql.= "    * ";
            $mysql.= " FROM ";
            $mysql.= "    ergebnisse";
            $mysql.= " WHERE ";
            $mysql.= "        `ergebnissID` LIKE '2' ";

             $myresult = $mysql_conn->query($mysql);
            
            if ($myresult->num_rows > 0) {
                                            
                while($ergebnis = $myresult->fetch_assoc()) {
                
                    
                    $flt_Value    = $ergebnis["ergebnis"];
                    $flt_x    = $ergebnis["schuelerID"];
                    alert($flt_Value);          
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

echo"</body>
</html>";

?>
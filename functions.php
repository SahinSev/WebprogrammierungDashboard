<?php


function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}


function un_utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = un_utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_decode($d);
    }
    return $d;
}



function convert_to_104($MySQL_Timestamp, $Mit_Wochentag=0, $Mit_Uhrzeit=0) {

	  $WoTa		= array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"); //zur Ausgabe der Wochentage
	  $WochenTage	= array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"); //zur Ausgabe der Wochentage


	  $Timestamp_Array	= explode(" ", $MySQL_Timestamp);
    $Datum				    = $Timestamp_Array[0];
	  $Zeit				      = $Timestamp_Array[1];

    $Datums_Array	= explode("-", $Datum);
    $Tag			  = $Datums_Array[2];
    $Tag			  = $Tag*1;
    $Monat			= $Datums_Array[1];
    $Monat			= $Monat*1;
    $Jahr			  = $Datums_Array[0];
	  $Jahr			  = $Jahr*1;

    if($Tag<10)   {$Tag="0$Tag";}
    if($Monat<10) {$Monat="0$Monat";}
    if($Jahr<10)  {$Jahr="000$Jahr";}
    
    if($Jahr==1970)  {return "";}
    
    $Datum_104	= "$Tag.$Monat.$Jahr";

  	$Zeit_Array	= explode(":", $Zeit);
  	$Stunde		= $Zeit_Array[0];
  	$Stunde		= $Stunde*1;
  	$Minute		= $Zeit_Array[1];
  	$Minute		= $Minute*1;
  	$Sekunde	= $Zeit_Array[2];
  	$Sekunde	= $Sekunde*1;

  	if($Stunde<10)  {$Stunde="0$Stunde";}
  	if($Minute<10)  {$Minute="0$Minute";}
  	if($Sekunde<10) {$Sekunde="0$Sekunde";}

  	if($Mit_Wochentag==1) {
    		$Wochentag		=date("w", mktime(1,1,1,$Monat,$Tag,$Jahr) );
    		$Wochentag_F 	= $WoTa[$Wochentag];
    		if($Mit_Uhrzeit==1) {
    			$Returnstring = "$Wochentag_F, $Datum_104 $Stunde:$Minute";
    		} else {
    			$Returnstring = "$Wochentag_F, $Datum_104";
    		}
    
  	} else {
    		$Returnstring = $Datum_104;
  	}

    return $Returnstring;

}




function convert_to_date_dd_MM_yy($MySQL_Timestamp) {

    if($MySQL_Timestamp == "") {
        return "";
    }

    if(eregi("0000", $MySQL_Timestamp)) {
        return "";
    }
    
    if($MySQL_Timestamp=="2000-01-01 00:00:00") {
        return "";
    }
    
    if($MySQL_Timestamp=="1970-01-01 00:00:00") {
        return "";
    }
    
    if($MySQL_Timestamp=="1970-01-01") {
        return "";
    }
    
    $Timestamp_Array	= explode(" ", $MySQL_Timestamp);
    $Datum				    = $Timestamp_Array[0];
	  $Zeit				      = $Timestamp_Array[1];

    $Datums_Array	= explode("-", $Datum);
    $Tag			  = $Datums_Array[2];
    $Tag			  = $Tag*1;
    $Monat			= $Datums_Array[1];
    $Monat			= $Monat*1;
    $Jahr			  = $Datums_Array[0];
	  $Jahr			  = $Jahr*1;

    if($Tag<10)   {$Tag="0$Tag";}
    if($Monat<10) {$Monat="0$Monat";}
    if($Jahr<10)  {$Jahr="000$Jahr";}
    $Datum_104	= "$Tag.$Monat.$Jahr";

  	$Zeit_Array	= explode(":", $Zeit);
  	$Stunde		= $Zeit_Array[0];
  	$Stunde		= $Stunde*1;
  	$Minute		= $Zeit_Array[1];
  	$Minute		= $Minute*1;
  	$Sekunde	= $Zeit_Array[2];
  	$Sekunde	= $Sekunde*1;

    
  	if($Stunde<10)  {$Stunde="0$Stunde";}
  	if($Minute<10)  {$Minute="0$Minute";}
  	if($Sekunde<10) {$Sekunde="0$Sekunde";}

    $Returnstring = date("d-M-Y", mktime(0, 0, 0, $Monat, $Tag, $Jahr));
    
    return $Returnstring;
    
}


function get_quartal($monat) {
     return (int)(($monat - 1) / 3) + 1;
}



function convert_dd_MM_yy_to_120($Timestamp_10x) {

    #echo"$Timestamp_10x";
    
    
    $Timestamp_Array=explode("-", $Timestamp_10x);
    
    $Monate = Array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

    $Arr_Monate["Jan"] = 1;
    $Arr_Monate["Feb"] = 2;
    $Arr_Monate["Mar"] = 3;
    $Arr_Monate["Apr"] = 4;
    $Arr_Monate["May"] = 5;
    $Arr_Monate["Jun"] = 6;
    $Arr_Monate["Jul"] = 7;
    $Arr_Monate["Aug"] = 8;
    $Arr_Monate["Sep"] = 9;
    $Arr_Monate["Oct"] = 10;
    $Arr_Monate["Nov"] = 11;
    $Arr_Monate["Dec"] = 12;
    
    $Tag=$Timestamp_Array[0]*1;
    $str_Monat=$Timestamp_Array[1];
    $Jahr=$Timestamp_Array[2]*1;
    
    
    
    $Monat = $Arr_Monate["$str_Monat"];
    
    if($Jahr<10) {
        $Jahr = "200$Jahr";
    } else if($Jahr<100) {
        $Jahr = "20$Jahr";
    }

    if(checkdate($Monat, $Tag, $Jahr)) {    
        $Datum_120="$Jahr-$Monat-$Tag 00:00:00";
    } else {
        $Datum_120="0000-00-00 00:00:00";
    }
    
    return $Datum_120;

}



function convert_to_120($Timestamp_104) {

    $Timestamp_Array=explode(".", $Timestamp_104);
    $Tag=$Timestamp_Array[0]*1;
    $Monat=$Timestamp_Array[1]*1;
    $Jahr=$Timestamp_Array[2]*1;
    
    if($Jahr<10) {
        $Jahr = "200$Jahr";
    } else if($Jahr<100) {
        $Jahr = "20$Jahr";
    }

    if(checkdate($Monat, $Tag, $Jahr)) {    
        $Datum_120="$Jahr-$Monat-$Tag 00:00:00";
    } else {
        $Datum_120="0000-00-00 00:00:00";
    }
    return $Datum_120;

}


function get_weekday($Timestamp, $strlength=10) {

    $day[0] = "Sonntag";
    $day[1] = "Montag";
    $day[2] = "Dienstag";
    $day[3] = "Mittwoch";
    $day[4] = "Donnerstag";
    $day[5] = "Freitag";
    $day[6] = "Samstag";
    $day[7] = "Sonntag";

    $Temp=explode(" ", $Timestamp);
    $Temp2=explode("-", $Temp[0]);

    $ReturnString=substr($day[date("w", mktime(0, 0, 0, $Temp2[1], $Temp2[2], $Temp2[0]))], 0, $strlength);
    
    return $ReturnString;
    
}




function get_Kalenderwoche($MySQL_Timestamp) {

    $Timestamp_Array=explode(" ", $MySQL_Timestamp);
    $Datum=$Timestamp_Array[0];
    $Zeit=$Timestamp_Array[1];

    $Datums_Array=explode("-", $Datum);
    $Tag=$Datums_Array[2];
    $Monat=$Datums_Array[1];
    $Jahr=$Datums_Array[0];

    $Zeit_Array=explode(":", $Zeit);
    $Stunde=$Zeit_Array[0];
    $Minute=$Zeit_Array[1];
    $Sekunde=$Zeit_Array[2];

    $KW=date("W", mktime(0,0,0,$Monat,$Tag,$Jahr) );
    return $KW;

}


function get_Jahr($MySQL_Timestamp) {

    $Timestamp_Array=explode(" ", $MySQL_Timestamp);
    $Datum=$Timestamp_Array[0];
    $Zeit=$Timestamp_Array[1];

    $Datums_Array=explode("-", $Datum);
    $Tag=$Datums_Array[2];
    $Monat=$Datums_Array[1];
    $Jahr=$Datums_Array[0];

    $Zeit_Array=explode(":", $Zeit);
    $Stunde=$Zeit_Array[0];
    $Minute=$Zeit_Array[1];
    $Sekunde=$Zeit_Array[2];

    $Jahr=date("Y", mktime(0,0,0,$Monat,$Tag,$Jahr) );
    return $Jahr;

}


function time_diff($Startzeit, $Endzeit) { #Erwartet zwei Zeitstempel im SQL-Server Zeitformat 120
    
    # @return Zeit in Sekunden
    # negativ bedeutet, dass die Endzeit vor der Startzeit liegt
    
    $date1_array=explode(" ", $Startzeit);
    $date2_array=explode(" ", $Endzeit);

    #arrout_pre($date1_array);
    #arrout_pre($date2_array);

    $date1=$date1_array[0];
    $time1=$date1_array[1];

    $date2=$date2_array[0];
    $time2=$date2_array[1];

    $d1 = explode("-", $date1);
    $y1 = $d1[0];
    $m1 = $d1[1];
    $d1 = $d1[2];

    $t1 = explode(":", $time1);
    $Stunde1 = $t1[0];
    $Minute1 = $t1[1];
    $Sekunde1 = $t1[2];

    $d2 = explode("-", $date2);
    $y2 = $d2[0];
    $m2 = $d2[1];
    $d2 = $d2[2];

    $t2 = explode(":", $time2);
    $Stunde2 = $t2[0];
    $Minute2 = $t2[1];
    $Sekunde2 = $t2[2];
    
    #out("$Stunde1, $Minute1, $Sekunde1, $m1, $d1, $y1");

    $date1_set = @mktime($Stunde1, $Minute1, $Sekunde1, $m1, $d1, $y1);
    $date2_set = @mktime($Stunde2, $Minute2, $Sekunde2, $m2, $d2, $y2);

    $Differenz=round(($date2_set-$date1_set), 8); #in Sekunden!

    #shout($Startzeit);


    return $Differenz;


}



function days_diff($Startzeit, $Endzeit) { #Erwartet zwei Zeitstempel im SQL-Server Zeitformat 120
    
    # @return Zeit in Sekunden
    # negativ bedeutet, dass die Endzeit vor der Startzeit liegt
    
    $date1_array=explode(" ", $Startzeit);
    $date2_array=explode(" ", $Endzeit);

    #print_r($date1_array);
    #print_r($date2_array);

    $date1=$date1_array[0];
    $time1=$date1_array[1];

    $date2=$date2_array[0];
    $time2=$date2_array[1];

    $d1 = explode("-", $date1);
    $y1 = $d1[0];
    $m1 = $d1[1];
    $d1 = $d1[2];

    $t1 = explode(":", $time1);
    $Stunde1 = $t1[0];
    $Minute1 = $t1[1];
    $Sekunde1 = $t1[2];

    $d2 = explode("-", $date2);
    $y2 = $d2[0];
    $m2 = $d2[1];
    $d2 = $d2[2];

    $t2 = explode(":", $time2);
    $Stunde2 = $t2[0];
    $Minute2 = $t2[1];
    $Sekunde2 = $t2[2];
    
    #out("$Stunde1, $Minute1, $Sekunde1, $m1, $d1, $y1");

    $date1_set = @mktime(0, 0, 0, $m1, $d1, $y1);
    $date2_set = @mktime(0, 0, 0, $m2, $d2, $y2);

    $Differenz=round((($date2_set-$date1_set)/60/60/24), 0); #in Tagen!

    #shout($Startzeit);


    return $Differenz;


}




function dauer_in_stunden($Startzeit, $Endzeit) { #Erwartet zwei Zeitstempel im SQL-Server Zeitformat 120

    $date1_array=explode(" ", $Startzeit);
    $date2_array=explode(" ", $Endzeit);

    $date1=$date1_array[0];
    $time1=$date1_array[1];

    $date2=$date2_array[0];
    $time2=$date2_array[1];

    $d1 = explode("-", $date1);
    $y1 = $d1[0];
    $m1 = $d1[1];
    $d1 = $d1[2];

    $t1 = explode(":", $time1);
    $Stunde1 = $t1[0];
    $Minute1 = $t1[1];
    $Sekunde1 = $t1[2];

    $d2 = explode("-", $date2);
    $y2 = $d2[0];
    $m2 = $d2[1];
    $d2 = $d2[2];

    $t2 = explode(":", $time2);
    $Stunde2 = $t2[0];
    $Minute2 = $t2[1];
    $Sekunde2 = $t2[2];

    $date1_set = mktime($Stunde1, $Minute1, $Sekunde1, $m1, $d1, $y1);
    $date2_set = mktime($Stunde2, $Minute2, $Sekunde2, $m2, $d2, $y2);

    $Differenz_in_Sekunden=round(($date2_set-$date1_set), 8);

    $Stunden=floor($Differenz_in_Sekunden/60/60);
    if($Stunden<10) {$Stunden="0$Stunden";}
    $Minuten=(floor($Differenz_in_Sekunden/60))-($Stunden*60);
    if($Minuten<10) {$Minuten="0$Minuten";}
    $Sekunden=((floor($Differenz_in_Sekunden))-($Minuten*60)-$Stunden*60*60);
    if($Sekunden<10) {$Sekunden="0$Sekunden";}

    $Dauer_in_Stunden=$Stunden+($Minuten/60)+($Sekunden/60/60);
    return "$Dauer_in_Stunden";

}



function add_hours($Startzeit, $Stunden) { #Erwartet einen Zeitstempel im SQL-Server Zeitformat 120 und eine float-Zahl

    $date1_array=explode(" ", $Startzeit);

    $date1=$date1_array[0];
    $time1=$date1_array[1];

    if(eregi("-", $Stunden)) {
        $Negativ="-";
    } else {
        $Negativ="";
    }
    #out($Negativ);

    if(eregi(".", $Stunden)) {
        $Arr_Stunden=explode(".", $Stunden);
        $Minuten_unveraendert=substr($Arr_Stunden[1], 0, 2);

        #out($Minuten_unveraendert);

        if(strlen($Minuten_unveraendert)==1) {
            $Minuten_F="$Negativ".$Spacer."0".$Minuten_unveraendert;
        } else if(strlen($Minuten)==2) {
            $Minuten_F="$Negativ".$Minuten_unveraendert*1;
        } else {
            $Minuten_F="$Negativ".$Minuten_unveraendert;
        }

        $Minuten_calc=$Minuten_F/100*60;
        #out($Minuten_calc);

        $Stunden=floor($Arr_Stunden[0]);
        #out($Stunden);

    } else {
        $Minuten_calc=0;
    }


    $datum1 = explode("-", $date1);

    $y1 = $datum1[0]*1;
    $m1 = $datum1[1]*1;
    $d1 = $datum1[2]*1;

    $zeit1 = explode(":", $time1);

    $Stunde1 = $zeit1[0]*1;
    $Minute1 = $zeit1[1]*1;
    $Sekunde1 = $zeit1[2]*1;


    if($y1>2000) {
        $date1_set = date("Y-m-d H:i:s", mktime( ($Stunde1 + $Stunden) , ($Minute1 + $Minuten_calc), $Sekunde1, $m1, $d1, $y1));
    } else {
        $date1_set = "0000-00-00 00:00:00";
    }

    #out("mktime( ($Stunde1 + $Stunden) , ($Minute1+$Minuten_calc), $Sekunde1, $m1, $d1, $y1)); $date1_set");

    return "$date1_set";

}




function add_minutes($Startzeit, $Minuten) { #Erwartet einen Zeitstempel im SQL-Server Zeitformat 120 und eine float-Zahl

    $date1_array=explode(" ", $Startzeit);

    $date1=$date1_array[0];
    $time1=$date1_array[1];

    if(eregi("-", $Minuten)) {
        $Negativ="-";
    } else {
        $Negativ="";
    }
    #out($Negativ);

    if(eregi(".", $Minuten)) {
        $Arr_Minuten=explode(".", $Minuten);
        $Sekunden_unveraendert=substr($Arr_Minuten[1], 0, 2);

        #out($Sekunden_unveraendert);

        if(strlen($Sekunden_unveraendert)==1) {
            $Sekunden_F="$Negativ".$Spacer."0".$Sekunden_unveraendert;
        } else if(strlen($Sekunden)==2) {
            $Sekunden_F="$Negativ".$Sekunden_unveraendert*1;
        } else {
            $Sekunden_F="$Negativ".$Sekunden_unveraendert;
        }

        $Sekunden_calc=$Sekunden_F/100*60;
        #out($Sekunden_calc);

        $Minuten=floor($Arr_Minuten[0]);
        #out($Stunden);

    } else {
        $Sekunden_calc=0;
    }


    $datum1 = explode("-", $date1);

    $y1 = $datum1[0]*1;
    $m1 = $datum1[1]*1;
    $d1 = $datum1[2]*1;

    $zeit1 = explode(":", $time1);

    $Stunde1 = $zeit1[0]*1;
    $Minute1 = $zeit1[1]*1;
    $Sekunde1 = $zeit1[2]*1;


    if($y1>2000) {
        $date1_set = date("Y-m-d H:i:s", mktime( ($Stunde1) , ($Minute1 + $Minuten), ($Sekunde1+$Sekunden_calc), $m1, $d1, $y1));
    } else {
        $date1_set = "0000-00-00 00:00:00";
    }

    #out("mktime( ($Stunde1 + $Stunden) , ($Minute1+$Minuten_calc), $Sekunde1, $m1, $d1, $y1)); $date1_set");

    return "$date1_set";

}


function get_rgb($hex) {

    $hex_array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
        'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14,
        'F' => 15);
    $hex = str_replace('#', '', strtoupper($hex));
    if (($length = strlen($hex)) == 3) {
        $hex = $hex{0}.$hex{0}.$hex{1}.$hex{1}.$hex{2}.$hex{2};
        $length = 6;
    }

    if ($length != 6 or strlen(str_replace(array_keys($hex_array), '', $hex))) {
        return NULL;
    }

    $rgb['r'] = $hex_array[$hex{0}] * 16 + $hex_array[$hex{1}];
    $rgb['g'] = $hex_array[$hex{2}] * 16 + $hex_array[$hex{3}];
    $rgb['b']= $hex_array[$hex{4}] * 16 + $hex_array[$hex{5}];
    return $rgb['r'].','.$rgb['g'].','.$rgb['b'];

}


function add_day($MySQL_Timestamp, $add_days) {

    $Timestamp_Array=explode(" ", $MySQL_Timestamp);
    $Datum=$Timestamp_Array[0];
    $Zeit=$Timestamp_Array[1];

    $Datums_Array=explode("-", $Datum);
    $Tag=$Datums_Array[2];
    $Monat=$Datums_Array[1];
    $Jahr=$Datums_Array[0];

    $Zeit_Array=explode(":", $Zeit);
    $Stunde=$Zeit_Array[0];
    $Minute=$Zeit_Array[1];
    $Sekunde=$Zeit_Array[2];

    $Datum_neu=date("Y-m-d h:i:s", mktime(0,0,0,$Monat,($Tag+$add_days),$Jahr) );
    return $Datum_neu;

}

function erase_telefonzeichen($String) {

    $String=str_replace(" ", "", $String); 
    $String=str_replace("(", "", $String); 
    $String=str_replace(")", "", $String);
    $String=str_replace("-", "", $String);
    $String=str_replace("/", "", $String);

    return $String; # und zurück!

}



function erase_sonderzeichen_aus_dateiname($String) {

    $Position=strrpos($String, ".");
    $Dateiname=substr($String, 0, $Position);
    $Rest=substr($String, $Position, 100);
    $Rest=trim($Rest);

    $String=$Dateiname;

    $String=str_replace(" ", "_", $String); #Space weg
    $String=str_replace("ü", "ue", $String);
    $String=str_replace("ä", "ae", $String);
    $String=str_replace("ö", "oe", $String);
    $String=str_replace("Ü", "Ue", $String);
    $String=str_replace("Ä", "Ae", $String);
    $String=str_replace("Ö", "Oe", $String);
    $String=str_replace("ß", "ss", $String);
    $String=str_replace(".", "_", $String);
    $String=str_replace("+", "_plus_", $String);
    $String=str_replace("-", "_", $String);
    $String=str_replace("!", "_", $String);
    $String=str_replace("\"", "_", $String);
    $String=str_replace("=", "_", $String);
    $String=str_replace("`", "_", $String);
    $String=str_replace("´", "_", $String);
    $String=str_replace("'", "_", $String);

    #$String=str_replace("$", "_", $String);
    #$String=str_replace("%", "_", $String);
    #$String=str_replace("&", "_", $String);
    #$String=str_replace("/", "_", $String);
    #$String=str_replace("(", "_", $String);
    #$String=str_replace(")", "_", $String);

    $String="$String$Rest";

    return $String; #und zurück!

}


function html_to_input($String) {

    $String=str_replace("&nbsp;", " ", $String); #Space weg
    $String=str_replace("<br>", " ", $String); #Return weg
    $String=str_replace("<b>", "", $String);
    $String=str_replace("</b>", "", $String);
    $String=str_replace("<i>", "", $String);
    $String=str_replace("</i>", "", $String);
    $String=str_replace("<u>", "", $String);
    $String=str_replace("</u>", "", $String);
    return $String; #und zurück!

}



function umlaute_austauschen($String) {

    $String=str_replace("Ä", "Ae", $String);
    $String=str_replace("ä", "ae", $String);
    $String=str_replace("Ö", "Oe", $String);
    $String=str_replace("ö", "oe", $String);
    $String=str_replace("Ü", "Ue", $String);
    $String=str_replace("ü", "ue", $String);

    return $String;

} #Ende Funktion umlaute_austauschen($String)


function istteilbardurch($sollzahl, $istzahl) { #Schaut, ob die erste Zahl der zweiten entspricht

    $test1=$istzahl/$sollzahl;
    $test2=round($test1,0);
    if( ($test1) == ($test2) ){
        return true;
    } else {
        return false;
    }

}


function form($SQL_Float, $Stellen) {

    $SQL_Float_F=number_format($SQL_Float, $Stellen, ",", ".");
    return $SQL_Float_F;

}



function Umlaute_to_HTML($String) { # Für zuverlässige Weitergaben in andere Textfelder, Applikationen, etc.

    $String=str_replace("ü", "%FC", $String);
    $String=str_replace("Ü", "%DC", $String);
    $String=str_replace("ä", "%E4", $String);
    $String=str_replace("Ä", "%C4", $String);
    $String=str_replace("ö", "%F6", $String);
    $String=str_replace("Ö", "%D6", $String);
    $String=str_replace("ß", "%DF", $String);
    $String=str_replace("&", "&amp;", $String);
    return $String; #und zurück!

}


function Link_to_UTF_8($String) { # Für zuverlässige Weitergaben in andere Textfelder, Applikationen, etc.

    $String=str_replace("ü", "%c3%bc", $String);
    $String=str_replace("Ü", "%c3%9c", $String);
    $String=str_replace("ä", "%c3%a4", $String);
    $String=str_replace("Ä", "%c3%84", $String);
    $String=str_replace("ö", "%c3%b6", $String);
    $String=str_replace("Ö", "%c3%96", $String);
    $String=str_replace("ß", "%C3%9F", $String);    
    $String=str_replace("&", "%26", $String);
    return $String; #und zurück!

}

function jetzt() {

    $jetzt=date("Y-m-d H:i:s");
    return $jetzt;

}




function dbsearch_mysql($SQL_String) {
    
    global $mysql_conn;
    global $Global_Benu_Benutzername;
    
    #$SQL_String = make_secure($SQL_String);
    
    $my_anfrage   = $mysql_conn->query($SQL_String);    
    $my_error_nr  = $mysql_conn->errno;
    
    if($my_error_nr==0) {
        return $my_anfrage;
    } else {
        if($Global_Benu_Benutzername == "Horing") {
            #echo "<font class=\"warning\">Error code {$mysql_conn->errno}: {$mysql_conn->error}</font>";        
        }
        return -1;
    }
   
    

} # End dbsearch()




function dbsearch_sql($tsql) {
    
    global $global_connect_sql;
    #$anfrage_sql  = sqlsrv_query($global_connect_sql, $tsql, array(), array( "Scrollable" => 'static' ) );  
    $anfrage_sql  = sqlsrv_query($global_connect_sql, $tsql );  
    
    if( $anfrage_sql === false) {
        echo"SQL Query Error: ";
        print_r(sqlsrv_errors());
    }
    
    #echo"rows: ".sqlsrv_num_rows($anfrage_sql);
        
    return $anfrage_sql;

} #End dbsearch()


function dbsearch_kupfer($tsql) {
    
    global $global_connect_kupfer;
    #$anfrage_sql  = sqlsrv_query($global_connect_sql, $tsql, array(), array( "Scrollable" => 'static' ) );  
    $anfrage_kupfer  = sqlsrv_query($global_connect_kupfer, $tsql );  
    
    if( $anfrage_kupfer === false) {
        echo"SQL Query Error: ";
        print_r(sqlsrv_errors());
    }
    
    #echo"rows: ".sqlsrv_num_rows($anfrage_sql);
        
    return $anfrage_kupfer;

} #End dbsearch()




function dbout_mysql($Query_Result) {
    
    #if($Query_Result==-1) {
    #    $my_ergebnis = -1;
    #} else {
        $my_ergebnis = $Query_Result->fetch_assoc();
    #}
  
    return $my_ergebnis;

} # End dbout()


function dbout_sql($anfrage_sql) {
    
    $ergebnis = @sqlsrv_fetch_array($anfrage_sql, SQLSRV_FETCH_ASSOC);   
    return $ergebnis;

}

function dbout_kupfer($anfrage_kupfer) {
    
    $ergebnis = @sqlsrv_fetch_array($anfrage_kupfer, SQLSRV_FETCH_ASSOC);   
    return $ergebnis;

}




function zaehle($anfrage) {

    $Anzahl_Zeilen=@mysqli_num_rows($anfrage);
    return $Anzahl_Zeilen;

}

function zaehle_sql($anfrage_sql) {

    $Anzahl_Zeilen = sqlsrv_num_rows($anfrage_sql);
    return $Anzahl_Zeilen;    

}



?>
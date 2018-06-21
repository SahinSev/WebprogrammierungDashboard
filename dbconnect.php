<?php
############################
# Variablen, die immer zur Verfügung stehen sollen
$jetzt_104  = date("d.m.Y");
$jetzt_120  = date("Y-m-d H:i:s");
# Variablen, die immer zur Verfügung stehen sollen
############################
############################
# Konfiguration Error-Reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE); # E_ALL
error_reporting(E_ALL);
# Konfiguration Error-Reporting
############################
    
############################
# Verbinden mit server
        $mysql_str_servername = "localhost"   ;
        $mysql_str_username   = "root"   ;
        $mysql_str_password   = ""     ;
        $mysql_str_dbname     = "sahins_db"   ;
        
        $mysql_conn = new mysqli($mysql_str_servername, $mysql_str_username, $mysql_str_password, $mysql_str_dbname);
        
        if ($mysql_conn->connect_error) {
            echo"<font class=\"normal\">Connection failed: ". $mysql_conn->connect_error ."</font>";
            $connection = 0;
        } else {        
            #echo"<font class=\"normal\">Connected successfully</font>";
            $connection = 1;
        }
# Verbinden mit server
############################
?>
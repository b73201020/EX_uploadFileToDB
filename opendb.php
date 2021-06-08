<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//連結MySQL Server
$mysqli = new mysqli($IP,$user,$password,$DB); 

?>
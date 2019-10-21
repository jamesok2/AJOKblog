<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="open-iconic/font/css/open-iconic-bootstrap.css">
    <script src="bootstrap/js/jquery-3.4.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <span class="oi oi-account-login" title="account-login" aria-hidden="true"></span><br>
    <span class="oi oi-grid-three-up" title="grid-three-up" aria-hidden="true"></span><br>
<?php
date_default_timezone_set("Africa/Dar_es_salaam");
$CurrentTime = time();
$DateTime = strftime("%B %d, %Y %H:%M:%S", $CurrentTime);
echo $DateTime;
?>
</body>
</html>
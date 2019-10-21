<?php
require_once("include/functions.php");
require_once("include/sessions.php");
/**
 * Created by PhpStorm.
 * User: Eddy
 * Date: 8/27/2019
 * Time: 5:49 PM
 */

$_SESSION['User_id'] = null;

session_destroy();

$_SESSION["SuccessMessage"] = "Successfully Logged Out!";
Redirect_to("Login.php");

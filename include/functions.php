<?php
require_once("include/db.php");
require_once("include/sessions.php");

/**
 * Created by PhpStorm.
 * User: Eddy
 * Date: 8/10/2019
 * Time: 8:59 PM
 */
function Redirect_to($NewLocation){
    header("Location: ".$NewLocation);
    exit;
}

function login_attempt($Username, $Password){
    global $connection;
    $Query = "SELECT * FROM registration WHERE username='$Username' AND password='$Password'";
    $result = $connection->query($Query);
    if($admin=$result->fetch_array()){
        return $admin;
    }else{
        return null;
    }
}

function Confirm_Login(){
    if(!isset($_SESSION['User_id'])){
//        return true;
        $_SESSION["ErrorMessage"] = "Access denied, Please Login First!";
        Redirect_to("Login.php");
    }
}
//function Confirm_Login(){
//    if(!Login()){
//        Redirect_to("Login.php");
//    }
//}
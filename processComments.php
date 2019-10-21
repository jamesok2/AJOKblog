<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
Confirm_Login();

if(isset($_GET['approve'])){
    $approveId = $_GET['approve'];
    $Admin = $_SESSION['Username'];
    $connection;
    $approveQuery = "UPDATE comments SET status = 'ON', approvedby = '$Admin' WHERE id = '$approveId'";
    $result = $connection->query($approveQuery);
    if ($result){
        $_SESSION["SuccessMessage"] = "Comment Approved Successfully";
        Redirect_to("comments.php");
    }else{
        $_SESSION["ErrorMessage"] = "Something went wrong, Please try again";
        Redirect_to("comments.php");
    }

}elseif(isset($_GET['reject'])) {
    $rejectId = $_GET['reject'];
    $connection;
    $rejectQuery = "UPDATE comments SET status = 'OFF' WHERE id = '$rejectId'";
    $result = $connection->query($rejectQuery);
    if ($result){
        $_SESSION["SuccessMessage"] = "Comment Successfully Reverted to Un-approved State";
        Redirect_to("comments.php");
    }else{
        $_SESSION["ErrorMessage"] = "Something went wrong, Please try again";
        Redirect_to("comments.php");
    }

}elseif(isset($_GET['delete'])){
    $deleteId = $_GET['delete'];
    $connection;
    $rejectQuery = "DELETE FROM comments WHERE id = '$deleteId'";
    $result = $connection->query($rejectQuery);
    if ($result){
        $_SESSION["DeletesMessage"] = "Comment Deleted Successfully";
        Redirect_to("comments.php");
    }else{
        $_SESSION["SuccessMessage"] = "Something went wrong, Please try again";
        Redirect_to("comments.php");
    }

}elseif(isset($_GET['categoryId'])) {
    $deleteId = $_GET['categoryId'];
    $connection;
    $categoryQuery = "DELETE FROM category WHERE id = '$deleteId'";
    $result = $connection->query($categoryQuery);
    if ($result) {
        $_SESSION["DeletesMessage"] = "Category Deleted Successfully";
        Redirect_to("categories.php");
    } else {
        $_SESSION["SuccessMessage"] = "Something went wrong, Please try again";
        Redirect_to("categories.php");
    }

}elseif(isset($_GET['adminId'])) {
    $deleteId = $_GET['adminId'];
    $connection;
    $adminQuery = "DELETE FROM registration WHERE id = '$deleteId'";
    $result = $connection->query($adminQuery);
    if ($result) {
        $_SESSION["DeletesMessage"] = "Admin Deleted Successfully";
        Redirect_to("admins.php");
    } else {
        $_SESSION["SuccessMessage"] = "Something went wrong, Please try again";
        Redirect_to("admins.php");
    }

}




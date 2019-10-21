<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");

if(isset($_POST['Submit'])){
    $Username = mysqli_real_escape_string($connection, $_POST['Username']);
    $Password = mysqli_real_escape_string($connection, $_POST['Password']);

    date_default_timezone_set("Africa/Dar_es_salaam");
    $CurrentTime = time();
    $DateTime = strftime("%B %d, %Y %H:%M:%S", $CurrentTime);

    $Admin = "James Ok";

    if(empty($Username) || empty($Password)){
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("login.php");

    }else{

        $found_account = login_attempt($Username, $Password);
        if($found_account){
            $_SESSION['User_id']=$found_account['id'];
            $_SESSION['Username']=$found_account['username'];

            $_SESSION["SuccessMessage"] = "Welcome {$_SESSION['Username']}";
            Redirect_to("dashboard.php");
        }else{
            $_SESSION["ErrorMessage"] = "Invalid Username / Password";
            Redirect_to("login.php");
        }

    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/open-iconic/font/css/open-iconic-bootstrap.css"> <!-- this is for open-icons -->
<!--    <link rel="stylesheet" href="font-awesome/css/all.css">-->
    
    <script src="assets/bootstrap/js/jquery-3.4.1.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- The custom css should be after in order to have first priority incase you want to overwrite bootstrap styles -->
    <link rel="stylesheet" href="assets/mystyle/admin.css">
</head>

<style>
    /*link to " google material design icons." Alternatively include this ih head '<link rel="stylesheet" href = " put path here" '*/
    @import url('assets/material-design-icons/iconfont/dist/material-design-icons.css');
    /* This is for font awesome (fas fa-)*/
    @import url('assets/font-awesome/css/all.css');

    /*custom css*/
    .FieldInfo{
        color: rgb(251, 174, 44);
        font-family: Bitter, Bitter, Georgia, "Times New Roman", Times, serif;
        font-size: 1.2em;
    }
    body{
        background-color: #ffffff;
    }
</style>

<body>
<!--    <span class="oi oi-account-login" title="account-login" aria-hidden="true"></span>-->
<div style="height: 60px; background: #27AAE1">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="blog.php">
            <img class="rounded-circle" src="images/ajokcomputers.png" width="40" height="40">&nbsp;AJOKcomputers</a>


        </div>
    </nav>

<p></p>
<div class="container-fluid"><!-- The whole page -->

    <div class="row"> <!-- The whole page as a row-->


        <div class="col-sm-4 offset-4"><!-- The main area -->
            <br><br>
            <div>
                <?php
                echo Message();
                echo SuccessMessage();
                echo DeleteMessage();
                ?>
            </div>
            <h2>Provide Your Login Credentials</h2>

           <div>

               <form action="login.php" method="post">
                   <fieldset>
                       <div class="form-group">
                           <label for="Username"><span class="FieldInfo">User Name:</span> </label>
                           <div class="input-group input-group-lg">
                               <span class="input-group-prepend input-group-text ">
                                   <span class=" text-primary"><i class="fal fa-envelope"></i></span>
                               </span>
                               <input class="form-control" type="text" name="Username" id="username" placeholder="Enter Your Username">
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="Password"><span class="FieldInfo">Password:</span> </label>
                           <div class="input-group input-group-lg">
                               <span class="input-group-prepend input-group-text text-primary">
                                   <span><i class="fal fa-lock-alt"></i></span>
                               </span>
                               <input class="form-control" type="password" name="Password" id="password" placeholder="Enter Your password">
                           </div>
                       </div>
                       <input class="btn btn-info" type="submit" name="Submit" value="Add New Admin">

                   </fieldset>

               </form>
           </div>


        </div><!-- The second column (Main content area) closing tag -->

    </div><!-- The whole page as a row Closing-->

</div><!-- The whole page Ending Here (container-fluid)-->

</body>
</html>
<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
Confirm_Login();

if(isset($_POST['Submit'])){
    $Username = mysqli_real_escape_string($connection, $_POST['Username']);
    $Password = mysqli_real_escape_string($connection, $_POST['Password']);
    $ConfirmPassword = mysqli_real_escape_string($connection, $_POST['ConfirmPassword']);

    date_default_timezone_set("Africa/Dar_es_salaam");
    $CurrentTime = time();
    $DateTime = strftime("%B %d, %Y %H:%M:%S", $CurrentTime);

    $Admin = $_SESSION['Username'];

    if(empty($Username) || empty($Password) || empty($ConfirmPassword)){
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("admins.php");

    }elseif(strlen($Password) < 4){
        $_SESSION["ErrorMessage"] = "Password Must Contain At least four Characters";
        Redirect_to("admins.php");

    }elseif($Password !== $ConfirmPassword){
        $_SESSION["ErrorMessage"] = "Sorry, Passwords Does not match";
        Redirect_to("admins.php");

    }else{
        global $connection;
        $insertQuery = "INSERT INTO registration(datetime, username, password, addedby)
        VALUES('$DateTime','$Username','$Password','$Admin')";

        $execute = $connection->query($insertQuery);

        if($execute){
            $_SESSION["SuccessMessage"] = "Admin Added Successful!";
            Redirect_to("admins.php");
        }else{
            $_SESSION["ErrorMessage"] = "Admin Not Added, Please contact the Administrator";
            Redirect_to("admins.php");
        }
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Admins</title>
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
</style>

<body>
<!--    <span class="oi oi-account-login" title="account-login" aria-hidden="true"></span>-->
<div style="height: 60px; background: #27AAE1">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="blog.php">
            <img class="rounded-circle" src="images/ajokcomputers.png" width="40" height="40">&nbsp;AJOKcomputers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">SERVICES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="blog.php" target="_blank">BLOG</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ABOUT US</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">CONTACT US</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FEATURE</a>
                </li>
            </ul>
            <form action="blog.php" class="form-inline flex-nowrap bg-light mx-0 mx-lg-auto rounded">
                <!--            <div class="form-group">-->
                <input type="text" class="form-control mr-sm-2" placeholder="Search" name="Search" aria-label="Search">
                <!--            </div>-->
                <button class="btn btn-outline-success my-2 my-sm-0" name="SearchButton">Go</button>
            </form>
        </div>
    </nav></div>

<p></p>
<div class="container-fluid"><!-- The whole page -->

    <div class="row"> <!-- The whole page as a row-->

        <div class="col-sm-2"><!-- The first column for Left-sidebar -->

            <ul id = "side_Menu" class="nav nav-pills flex-column">
                <li><a class="nav-link" href="dashboard.php">
                        <i class="material-icons">dashboard</i><span class="icon-text" aria-hidden="true">&nbsp;Dashboard</span></a> </li>
<!--                        <span class="oi oi-grid-three-up" title="grid-three-up" aria-hidden="true"></span>&nbsp;Dashboard</a> </li>-->
                <li><a class="nav-link" href="newpost.php">
                        &nbsp;<span class="oi oi-list-rich" title="list-rich" aria-hidden="true"></span>&nbsp;&nbsp;Add New Post</a> </li>
                <li><a class="nav-link" href="categories.php">
                        <i class="material-icons">category</i><span class="icon-text" aria-hidden="true">&nbsp;Categories</span></a> </li>
<!--                        <span class="oi oi-list-rich" title="list-rich" aria-hidden="true"></span>&nbsp;Categories</a> </li>-->
                <li><a class="nav-link active" href="admins.php">
                        <i class="material-icons">supervisor_account</i><span class="icon-text" aria-hidden="true">&nbsp;Manage Admins</span></a> </li>
<!--                        <span class="oi oi-person" title="person" aria-hidden="true"></span>&nbsp;Manage Admins</a> </li>-->
                <li><a class="nav-link" href="comments.php">
                        <i class="material-icons">comment</i><span class="icon-text" aria-hidden="true">&nbsp;Comments</span></a> </li>
<!--                        <span class="oi oi-comment-square" title="comment-square" aria-hidden="true"></span>&nbsp;Comments</a> </li>-->
                <li><a class="nav-link" href="#">
                        &nbsp;<span class="oi oi-chat" title="chat" aria-hidden="true"></span>&nbsp;&nbsp;Live Blog</a> </li>
                <li><a class="nav-link" href="logout.php">
                        &nbsp;<span class="oi oi-account-logout" title="account-logout" aria-hidden="true"></span>&nbsp;&nbsp;Logout</a> </li>
            </ul>
        </div><!-- Left-sidebar closing -->

        <div class="col-sm-10"><!-- The second column yielding the main content (right of the sidebar) -->
            <h1>Manage Admins</h1>
            <div>
                <?php
                echo Message();
                echo SuccessMessage();
                echo DeleteMessage();
                ?>
            </div>
           <div>
               <form action="admins.php" method="post">
                   <fieldset>
                       <div class="form-group">
                           <label for="Username"><span class="FieldInfo">User Name:</span> </label>
                           <input class="form-control" type="text" name="Username" id="username" placeholder="Write the Username">
                       </div>
                       <div class="form-group">
                           <label for="Password"><span class="FieldInfo">Password:</span> </label>
                           <input class="form-control" type="password" name="Password" id="password" placeholder="create a password">
                       </div>
                       <div class="form-group">
                           <label for="ConfirmPassword"><span class="FieldInfo">Confirm Passowrd:</span> </label>
                           <input class="form-control" type="password" name="ConfirmPassword" id="confirmPassword" placeholder="Retype the same Password">
                       </div>
                       <input class="btn btn-primary" type="submit" name="Submit" value="Add New Admin">

                   </fieldset>

               </form>
           </div>

            <div class="table-responsive"><!--Displaying available categories -->
                <table class="table table-striped table-hover">
                    <tr class="table-dark">
                        <th>Sr. No.</th>
                        <th>Date & Time</th>
                        <th>Username</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    global $connection;
                    $viewQuery = "SELECT * FROM registration ORDER BY datetime DESC";
                    $execute = $connection->query($viewQuery);

                    $SrNo = 0;
                    while ($row = $execute->fetch_array()){
                        $Id = $row["id"];
                        $DateTime = $row["datetime"];
                        $Username = $row['username'];
                        $Admin = $row["addedby"];
                        $SrNo++;
                        ?>
                    <tr>
                        <td><?php echo $SrNo; ?></td>
                        <td><?php echo $DateTime; ?></td>
                        <td><?php echo $Username; ?></td>
                        <td><?php echo $Admin; ?></td>
                        <td>
                            <a href="processComments.php?adminId=<?php echo $Id; ?>">
                                <span class="btn btn-outline-danger">Delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </div><!-- Displaying available category end here -->

        </div><!-- The second column (Main content area) closing tag -->

    </div><!-- The whole page as a row Closing-->

</div><!-- The whole page Ending Here (container-fluid)-->
<div id="footer">
    <hr><p>&copy; 2019 All rights reserved</p>
    <p>
        This is the official blog of AJOKcomputers Solutions. Created by James Ok!<br>&trade;AJOKcomputers.com
    </p>
</div>
</body>
</html>
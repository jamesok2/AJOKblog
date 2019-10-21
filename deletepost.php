<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
Confirm_Login();

if(isset($_POST['Submit'])){
    $Title = mysqli_real_escape_string($connection, $_POST['Title']);
    $Category = mysqli_real_escape_string($connection, $_POST['Category']);
    $Post = mysqli_real_escape_string($connection, $_POST['Post']);
    $Image = $_FILES["Image"]["name"]; //name is like keyword; take a name from the file

    /**
     * Upload images to the upload folder
     */
    $Target = "upload/".basename($_FILES["Image"]["name"]);

    date_default_timezone_set("Africa/Dar_es_salaam");
    $CurrentTime = time();
    $DateTime = strftime("%B %d, %Y %H:%M:%S", $CurrentTime);

    $Admin = "James Ok";

    global $connection;
    $deleteId = $_GET['Delete'];
    $deleteQuery = "DELETE FROM admin_panel WHERE id = '$deleteId'";

    $execute = $connection->query($deleteQuery);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

    if($execute){
        $_SESSION["SuccessMessage"] = "Post Deleted Successful!";
        Redirect_to("dashboard.php");
    }else{
        $_SESSION["ErrorMessage"] = "Delete Failed, Please Try Again";
        Redirect_to("dashboard.php");
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Post</title>
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
<div class="container-fluid"><!-- The whole page -->

    <div class="row"> <!-- The whole page as a row-->

        <div class="col-sm-2"><!-- The first column for Left-sidebar -->

            <ul id = "side_Menu" class="nav nav-pills flex-column">
                <li><a class="nav-link" href="Dashboard.php">
                        <i class="material-icons">dashboard</i><span class="icon-text" aria-hidden="true">&nbsp;Dashboard</span></a> </li>
<!--                        <span class="oi oi-grid-three-up" title="grid-three-up" aria-hidden="true"></span>&nbsp;Dashboard</a> </li>-->
                <li><a class="nav-link active" href="newpost.php">
                        &nbsp;<span class="oi oi-list-rich" title="list-rich" aria-hidden="true"></span>&nbsp;&nbsp;Add New Post</a> </li>
                <li><a class="nav-link " href="categories.php">
                        <i class="material-icons">category</i><span class="icon-text" aria-hidden="true">&nbsp;Categories</span></a> </li>
<!--                        <span class="oi oi-list-rich" title="list-rich" aria-hidden="true"></span>&nbsp;Categories</a> </li>-->
                <li><a class="nav-link" href="#">
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
            <h1>Delete Post</h1>
            <div>
                <?php
                echo Message();
                echo SuccessMessage();
                echo DeleteMessage();
                ?>
            </div>
           <div>

               <?php
               $connection;
               $deleteParameter = $_GET['Delete'];
               $sqlQuery = "SELECT * FROM admin_panel WHERE id = '$deleteParameter'";
               $result = $connection->query($sqlQuery);
               while($row = $result->fetch_array()){
                   $Titledelete = $row['title'];
                   $Categorydelete = $row['category'];
                   $Imagedelete = $row['image'];
                   $Postdelete = $row['post'];
               }
               ?>
               <form action="deletepost.php?Delete=<?php echo $deleteParameter; ?>" method="post" enctype="multipart/form-data">
                   <fieldset>
                       <div class="form-group">
                           <label for="title"><span class="FieldInfo">Title:</span> </label>
                           <input disabled class="form-control" type="text" name="Title" id="title" value="<?php echo $Titledelete; ?>">
                       </div>
                       <div class="form-group">
                           <label for="categoryselect"><span class="FieldInfo">Choose Category:</span> </label>
                           <select disabled class="form-control" id="categoryselect" name="Category">
                               <?php
                               global $connection;
                               $viewQuery = "SELECT * FROM category ORDER BY datetime DESC";
                               $execute = $connection->query($viewQuery);

                               echo "<option> $Categorydelete </option>";
                               while ($row = $execute->fetch_array()){
                                   $Id = $row["id"];
                                   $CategoryName = $row['name'];
                                   ?>
                                   <option><?php echo $CategoryName; ?></option>
                               <?php
                               }
                               ?>
                           </select>
                       </div>
                       <div>
                           <label for="currentImage"><span class="FieldInfo">Current Image</span> </label>
                           <img src="upload/<?php echo $Imagedelete; ?>" width="160"; height = "60";>
                       </div>
                       <div class="form-group">
                           <label for="imageselect"><span class="FieldInfo">Select New Image:</span> </label><br>
                           <input disabled type="file" class="form-control" name="Image" id="imageselect" >
                       </div>
                       <div class="form-group">
                           <label for="postarea"><span class="FieldInfo">Post:</span> </label>
                           <textarea disabled class="form-control" name="Post" id="postarea"><?php echo $Postdelete; ?></textarea>
                       </div>

                       <input class="btn btn-primary" type="submit" name="Submit" value="Delete Post">

                   </fieldset>

               </form>
           </div>

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
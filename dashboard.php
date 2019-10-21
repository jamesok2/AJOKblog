<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
Confirm_Login();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
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
            <p></p>

            <ul id = "side_Menu" class="nav nav-pills flex-column">
                <li><a class="nav-link active" href="dashboard.php">
                        <i class="material-icons">dashboard</i><span class="icon-text" aria-hidden="true">&nbsp;Dashboard</span></a> </li>
<!--                        <span class="oi oi-grid-three-up" title="grid-three-up" aria-hidden="true"></span>&nbsp;Dashboard</a> </li>-->
                <li><a class="nav-link" href="newpost.php">
                        &nbsp;<span class="oi oi-list-rich" title="list-rich" aria-hidden="true"></span>&nbsp;&nbsp;Add New Post</a> </li>
                <li><a class="nav-link" href="categories.php">
                        <i class="material-icons">category</i><span class="icon-text" aria-hidden="true">&nbsp;Categories</span></a> </li>
<!--                        <span class="oi oi-list-rich" title="list-rich" aria-hidden="true"></span>&nbsp;Categories</a> </li>-->
                <li><a class="nav-link" href="admins.php">
                        <i class="material-icons">supervisor_account</i><span class="icon-text" aria-hidden="true">&nbsp;Manage Admins</span></a> </li>
<!--                        <span class="oi oi-person" title="person" aria-hidden="true"></span>&nbsp;Manage Admins</a> </li>-->
                <li><a class="nav-link" href="comments.php">
                        <i class="material-icons">comment</i><span class="icon-text" aria-hidden="true">&nbsp;Comments</span>
                        <?php
                               /** Counting Total Unapproved Comments*/
                               $totalApproved = "SELECT * FROM comments WHERE status = 'OFF'";
                               $total = mysqli_query($connection, $totalApproved);
                               $countTotal = mysqli_num_rows($total);
                               if($countTotal > 0){
                                   echo "<span class='badge badge-danger'>$countTotal</span>";
                               }
                               ?>

                    </a> </li>
<!--                        <span class="oi oi-comment-square" title="comment-square" aria-hidden="true"></span>&nbsp;Comments</a> </li>-->
                <li><a class="nav-link" href="#">
                        &nbsp;<span class="oi oi-chat" title="chat" aria-hidden="true"></span>&nbsp;&nbsp;Live Blog</a> </li>
                <li><a class="nav-link" href="logout.php">
                        &nbsp;<span class="oi oi-account-logout" title="account-logout" aria-hidden="true"></span>&nbsp;&nbsp;Logout</a> </li>
            </ul>
        </div><!-- Left-sidebar closing -->

        <div class="col-sm-10"><!-- The second column yielding the main content (right of the sidebar) -->
            <div>
                <?php
                echo Message();
                echo SuccessMessage();
                ?>
            </div>
            <h1>Admin Dashboard</h1>
           <div class="table-responsive">
               <table class="table table-striped table-hover">
                   <tr class="table-dark">
                       <th>No.</th>
                       <th>Post Title.</th>
                       <th>Date & Time</th>
                       <th>Author</th>
                       <th>Category</th>
                       <th>Banner</th>
                       <th>Comments</th>
                       <th>Action</th>
                       <th>Details</th>
                   </tr>

                   <?php
                   global $connection;
                   $viewQuery = "SELECT * FROM admin_panel ORDER BY datetime DESC ";
                   $run = mysqli_query($connection, $viewQuery);
                   //$result = $connection->query($viewQuery);
                   $srNo = 0;
                   while ($row = $run->fetch_array()){
                       $Id = $row['id'];
                       $DateTime = $row['datetime'];
                       $Title = $row['title'];
                       $Category= $row['category'];
                       $Admin = $row['author'];
                       $Image = $row['image'];
                       $Post = $row['post'];
                       $srNo++;
                       ?>
                       <tr>
                           <td><?php echo $srNo; ?></td>
                           <td>
                               <?php
                               if(strlen($Title)> 30){$Title = substr($Title,0,30)."...";}
                               echo $Title;
                               ?>
                           </td>
                           <td><?php echo $DateTime; ?></td>
                           <td><?php echo $Admin; ?></td>
                           <td>
                               <?php
                               if(strlen($Category)> 10){$Category = substr($Category,0,10)."...";}
                               echo $Category;
                               ?>
                           </td>
                           <td><img src="upload/<?php echo $Image; ?>" width="160"; height = "60";></td>
                           <td>
                               <?php
                               /** Counting Unapproved Comments*/
                               $unapprovedQuery = "SELECT * FROM comments WHERE admin_panel_id = $Id AND status = 'OFF'";
                               $result = mysqli_query($connection, $unapprovedQuery);
                               $counter = mysqli_num_rows($result);
                               if($counter > 0){
                                   echo "<span class='badge badge-danger float-left'>$counter</span>";
                               }

                               /** Counting approved Comments*/
                               $selectQuery = "SELECT * FROM comments WHERE admin_panel_id = $Id AND status = 'ON'";
                               $results = mysqli_query($connection, $selectQuery);
                               $count = mysqli_num_rows($results);
                               if($count > 0){
                                   echo "<span class='badge badge-success float-right'>$count</span>";
                               }
                               ?>
                           </td>
                           <td>
                               <a href="editpost.php?Edit=<?php echo $Id; ?>"><span class="btn btn-outline-warning">Edit</span></a>
                               <a href="deletepost.php?Delete=<?php echo $Id; ?>"><span class="btn btn-outline-danger">Delete</span></a>
                           </td>
                           <td><a href="fullpost.php?id=<?php echo $Id ?>" target="_blank">
                               <span class="btn btn-info">Live Preview</span></a>
                           </td>
                           
                       </tr>
                   <?php
                   }
                   ?>
               </table>
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
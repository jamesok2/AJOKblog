<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");

if(isset($_POST['Submit'])){
$Name = mysqli_real_escape_string($connection, $_POST['Name']);
$Email = mysqli_real_escape_string($connection, $_POST['Email']);
$Comment = mysqli_real_escape_string($connection, $_POST['Comment']);

date_default_timezone_set("Africa/Dar_es_salaam");
$CurrentTime = time();
$DateTime = strftime("%B %d, %Y %H:%M:%S", $CurrentTime);
$PostId = $_GET['id'];

if(empty($Name) || empty($Email) || empty($Comment)){
    $_SESSION["ErrorMessage"] = "All Fields are required";


}elseif(strlen($Comment) > 500){
    $_SESSION["ErrorMessage"] = "Only 500 characters are allowed";

}else{
    global $connection;
    $urlPostId = $_GET['id'];
    $insertQuery = "INSERT INTO comments (datetime, name, email, comment, approvedby, status, admin_panel_id)
                  VALUES('$DateTime','$Name','$Email','$Comment','Pending','OFF', '$urlPostId')";

    $execute = $connection->query($insertQuery);

    if($execute){
        $_SESSION["SuccessMessage"] = "Comments Submitted Successful!";
        Redirect_to("fullpost.php?id={$PostId}");
    }else{
        $_SESSION["ErrorMessage"] = "Submission Failed, Please Try Again";
        Redirect_to("fullpost.php?id={$PostId}");
        }
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Full Blog Post</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/open-iconic/font/css/open-iconic-bootstrap.css">
    <script src="assets/bootstrap/js/jquery-3.4.1.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/mystyle/public.css">
</head>
<style>
    .FieldInfo{
        color: rgb(251, 174, 44);
        font-family: Bitter, Bitter, Georgia, "Times New Roman", Times, serif;
        font-size: 1.2em;
    }
    .commentBlock{
        background-color: #F6F7F9;
    }
    .comment-info{
        color: #365899;
        font-family: sans-serif;
        font-weight: bold;
        padding-top: 10px;
    }
</style>

<body>
<div style="height: 10px; background: #27AAE1"></div>
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
                <a class="nav-link" href="blog.php">BLOG</a>
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
</nav>
<br>

<div class="container-fluid">
    <div class="blog-header">
        <h1>AJOKcomputers Blog</h1>
        <p class="lead">This is the test site built by AJOKcomputers. it is just to test the skills</p>
        <div>
            <?php
            echo Message();
            echo SuccessMessage();
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8"> <!--blog main area-->
            <?php
            $blogPostId = $_GET['id'];
            global $connection;
            if(isset($_GET["SearchButton"])){
                $Search = $_GET["Search"];
                $viewQuery = "SELECT * FROM admin_panel WHERE
                datetime LIKE '%$Search%' OR title LIKE '%$Search%'
                OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
            }else{

                $viewQuery = "SELECT * FROM  admin_panel WHERE id = '$blogPostId' ORDER BY datetime DESC";
            }

            $result = $connection -> query($viewQuery);
            while ($row = $result->fetch_array()){
                $PostId = $row["id"];
                $DateTime = $row["datetime"];
                $Title = $row["title"];
                $Category = $row["category"];
                $Admin = $row["author"];
                $Image = $row["image"];
                $Post = $row["post"];
                ?>
                <div class="blogpost img-thumbnail">
                    <img class="img-fluid rounded" width="900" height="400" src="upload/<?php echo $Image; ?>">

                <div class="figure-caption">
                    <h1 id="heading"><?php echo htmlentities($Title);?></h1>
                    <p>Category: <?php echo htmlentities($Category);?>; Published On
                    <?php echo htmlentities($DateTime); ?></p>
                    <p class="post"><?php
                        echo nl2br($Post); ?></p>
                </div>

                </div>
                &nbsp;
            <?php
            }
            ?>
            <br>
            <span class="FieldInfo">Comments</span>
            <?php
            $connection;
            $CommentsPostId = $_GET["id"];
            $ExtractQuery = "SELECT * FROM comments WHERE admin_panel_id = '$CommentsPostId' AND status='ON'";
            $extractResult = $connection->query($ExtractQuery);
            while($rows = $extractResult->fetch_array()){
                $CommentDate = $rows["datetime"];
                $CommenterName = $rows["name"];
                $Comments = $rows["comment"];
                ?>
                <div class="commentBlock">
                    <img style="margin-top: 10px" class="float-left" src="assets/open-iconic/svg/person.svg" alt="Image" width="100" height="70">
                        <p class="comment-info"><?php echo $CommenterName; ?></p>
                        <p><?php echo $CommentDate; ?></p>
                        <p style="margin-left: 15px"><?php echo $Comments; ?></p>
                    <hr>
                </div>

            <?php
            }
            ?>
            <br>
            <span class="FieldInfo" style="font-weight: bold">Share your Thoughts about this Post</span>
            <!-- comments form -->
            <div>
                <form action="fullpost.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label for="Name"><span class="FieldInfo">Name:</span> </label>
                            <input class="form-control" type="text" name="Name" id="Name" placeholder="Fill Your Name">
                        </div>

                        <div class="form-group">
                            <label for="Email"><span class="FieldInfo">Email:</span> </label>
                            <input class="form-control" type="email" name="Email" id="Email" placeholder="Enter Your Email">
                        </div>

                        <div class="form-group">
                            <label for="Comment"><span class="FieldInfo">Comments:</span> </label>
                            <textarea class="form-control" name="Comment" id="Comment"></textarea>
                        </div>

                        <input class="btn btn-primary" type="submit" name="Submit" value="Submit Comments">

                    </fieldset>

                </form>
            </div>

        </div><!--blog main area ending-->

        <div class="col-sm-offset-1 col-sm-3"> <!--right pane-->
            <?php
            require("include/sidebar.php");
            ?>
        </div><!--right pane ending-->

    </div><!--row ending-->

</div><!--container ending-->
<div id="footer">
    <hr><p>&copy; 2019 All rights reserved</p>
    <p>
        This is the official blog of AJOKcomputers Solutions. Created by James Ok!<br>&trade;AJOKcomputers.com
    </p>
</div>

</body>
</html>
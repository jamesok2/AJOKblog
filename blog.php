<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blog Page</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/open-iconic/font/css/open-iconic-bootstrap.css">
    <script src="assets/bootstrap/js/jquery-3.4.1.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/mystyle/public.css">
</head>
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
    </div>

    <div class="row">
        <div class="col-sm-8"> <!--blog main area-->
            <?php
            global $connection;
            if(isset($_GET["SearchButton"])){
                $Search = $_GET["Search"];
                $viewQuery = "SELECT * FROM admin_panel WHERE
                datetime LIKE '%$Search%' OR title LIKE '%$Search%'
                OR category LIKE '%$Search%' OR post LIKE '%$Search%'";

            }elseif(isset($_GET['Category'])){
                $Category = $_GET["Category"];
                $viewQuery = "SELECT * FROM admin_panel WHERE category='$Category' ORDER BY datetime DESC";

            } elseif (isset($_GET["Page"])){
                //This is for Pagination
                $Page = $_GET["Page"];
                if ($Page <= 0){
                    $ShowPostFrom = 0;
                }else{$ShowPostFrom = ($Page * 3) - 3;}

                //LIMIT parameters: StartinPoint, Number of Posts to display
                $viewQuery = "SELECT * FROM  admin_panel ORDER BY datetime DESC LIMIT $ShowPostFrom,3";
            }else{

                $viewQuery = "SELECT * FROM  admin_panel ORDER BY datetime DESC LIMIT 0,3";
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
                    <h1 id="heading"><a href="fullpost.php?id=<?php echo $PostId; ?>">
                            <?php echo htmlentities($Title);?></a></h1>

                    <p>Category: <?php echo htmlentities($Category);?>; Published On
                    <?php echo htmlentities($DateTime);

                    //displaying the number of comments
                    /** Counting approved Comments*/
                    $selectQuery = "SELECT * FROM comments WHERE admin_panel_id = $PostId AND status = 'ON'";
                    $results = mysqli_query($connection, $selectQuery);
                    $count = mysqli_num_rows($results);
                    if($count > 0){
                        echo "<span class='badge badge-success float-right'>Comments: {$count}</span>";
                    }
                    ?>
                    </p>
                    <p class="post"><?php
                        if(strlen($Post) > 300){$Post = substr($Post,0,300) . "...";}
                        echo nl2br($Post); ?></p>
                </div>
                    <a href="fullpost.php?id=<?php echo $PostId; ?>"><span class="btn btn-info float-right">
                            Read More &raquo;
                        </span> </a>
                </div>
                &nbsp;
            <?php
            }//closing the while loop
            ?>
<!--            Code for pagination-->
            <nav>
                <ul class="pagination float-left">

                    <?php if(@$Page > 1){ ?>
                    <li class="page-item">
                        <a class="page-link" href="blog.php?Page=<?php echo $Page-1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <?php
                    }

                    $connection;
                    $paginationQuery = "SELECT * FROM admin_panel";
                    $result = mysqli_query($connection, $paginationQuery);
                    $rowCount = mysqli_num_rows($result);
                    $PostPagination = ceil($rowCount/3);

                    for ($i = 1; $i <= $PostPagination; $i++) {

                        ?>

                        <?php
                        if ($i == @$Page) {
                            ?>
                            <li class="page-item active"><a class="page-link"
                                                            href="blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class="page-item"><a class="page-link"
                                                     href="blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php
                        }
                    }//ending the for loop

                    if(isset($_GET['Page']) && (@$Page < $PostPagination)){
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="blog.php?Page=<?php echo $Page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                    <?php }?>
                </ul>
            </nav>


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
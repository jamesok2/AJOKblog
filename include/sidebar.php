<h2>About AJOKcomputers</h2>
<img src="images/ajokcomputers2.jpg" class="img-fluid imageicon">

<div class="card ">
    <div class="card-header bg-primary">
        <h2 class="card-title text-light">Categories</h2>
    </div>
    <div class="card-body">
        <?php
        global $connection;
        $viewQuery = "SELECT * FROM category ORDER BY datetime DESC";
        $result = $connection->query($viewQuery);
        while($rows = $result->fetch_array()){
            $Id = $rows['id'];
            $categoryName = $rows['name'];
            ?>
            <a href="blog.php?Category=<?php echo $categoryName; ?>">
                <span id="heading"><?php echo $categoryName?></span><br></a>
            <?php
        }
        ?>
    </div>
    <div class="card-footer">

    </div>
</div><br><br>


<div class="card ">
    <div class="card-header bg-primary">
        <h2 class="card-title text-light">Recent Posts</h2>
    </div>
    <div class="card-body background">
        <?php
        $connection;
        $viewQuery = "SELECT * FROM admin_panel ORDER BY datetime DESC LIMIT 0, 5";
        $result = $connection->query($viewQuery);
        while($rows = $result->fetch_array()){
            $Id=$rows['id'];
            $Title = $rows['title'];
            $DateTime = $rows['datetime'];
            $Image = $rows['image'];
            ?>
            <div>
                <img class="float-left" src="upload/<?php echo $Image; ?>" width="70" height="70">
                <a href="fullpost.php?id=<?php echo $Id; ?>">
                    <p id="heading" style="margin-left: 90px;"><?php echo htmlentities($Title);?></p>
                </a>
                <p class="description" style="margin-left: 90px;"><?php echo htmlentities($DateTime);?></p>
                <hr>
            </div>

            <?php
        }
        ?>
    </div>
    <div class="card-footer">

    </div>
</div>
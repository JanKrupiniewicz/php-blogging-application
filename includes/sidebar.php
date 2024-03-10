<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input type="text" name="search" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default" name="submit" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form> <!-- search form -->
        <!-- /.input-group -->
    </div>
    <?php 
        if(isset($_SESSION['user_role'])) {
            ?>
            <div class="well text-center">
                <h4>Welcome Back</h4>
                <h3><?= $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] ?></h3>
            </div>
            <div class="well">
                <span class="input-group-btn">
                    <a href="includes\logout.php" class="btn btn-primary btn-lg btn-block">Logout</a>
                </span>
            </div>
            <?php
            
        } else {
            ?>
            <div class="well">
                <span class="input-group-btn">
                    <a href="registration.php" class="btn btn-primary btn-lg btn-block">Register Now</a>
                </span>
            </div>

            <!-- Login -->
            <div class="well">
                <h4> Login </h4>
                <form action="includes/login.php" method="post">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Enter Username">
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" name="login" type="submit">Submit</button>
                        </span>
                    </div>
                </form>
                <!-- /.input-group -->
            </div>
            <?php
        }
    ?>
    
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php 
                    $query= "SELECT * FROM categories";
                    $select_all_categories = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($select_all_categories)) {
                        $category_title = $row['Title'];
                        $category_id = $row['categoryID'];
                        echo "<li> <a href='category.php?cat_id=$category_id'> {$category_title} </a> </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- Side Widget Well -->
    <?php include "widget.php" ?>
</div>
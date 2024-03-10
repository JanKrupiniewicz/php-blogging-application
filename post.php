<?php include 'includes/db.php'?>
<?php include 'includes/header.php' ?>
<body>

    <!-- Navigation -->
    <?php include 'includes/navigation.php' ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <!-- First Blog Post -->

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if(isset($_GET['p_id'])) {
                    $get_post_id = $_GET['p_id'];
                } else {
                    header("Location: index.php");
                }

                $view_query = "UPDATE posts SET post_views_count = post_views_count + 1";
                $view_query .= " WHERE postID = $get_post_id";
                $add_view_query = mysqli_query($connection, $view_query);

                $query = "SELECT * FROM posts WHERE postID = $get_post_id";
                $select_post_query = mysqli_query($connection, $query);
                $post = mysqli_fetch_assoc($select_post_query);
                $post_title = $post['post_title'];
                $post_author = $post['post_author'];
                $post_date = $post['post_date'];
                $post_image = $post['post_image'];
                $post_content = $post['post_content'];

                ?>

                <h2>
                <?php echo $post_title ?>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?= $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>
                
                <!-- Blog Comments -->
                <?php 
                    $nameErr = $emailErr = $contentErr = "";
                    createComment($nameErr, $emailErr, $contentErr);
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="comment_author"> Nickname </label>
                            <input type="text" class="form-control" name="comment_author">
                            <span class="error"><?php echo $nameErr;?></span>
                        </div>

                        <div class="form-group">
                            <label for="comment_email"> Email </label>
                            <input type="email" class="form-control" name="comment_email">
                            <span class="error"><?php echo $emailErr;?></span>
                        </div>

                        <div class="form-group">
                            <label for="comment"> Your Comment </label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                            <span class="error"><?php echo $contentErr;?></span>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <hr>

                <!-- Posted Comments -->
                <?php
                    $query = "SELECT * FROM comments WHERE comment_post_id = {$get_post_id} ";
                    $query .= "AND comment_status = 'approved' ";
                    $query .= "ORDER BY comment_id DESC";
                    $select_comments_query = mysqli_query($connection, $query);
                    if(!$select_comments_query) {
                        die("QUERY FAILED" . mysqli_error($connection));
                    }
                    while($row = mysqli_fetch_assoc($select_comments_query)) {
                        $comment_date = $row['comment_date'];
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];
                        ?>
                    
                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?= $comment_author ?>
                                    <small><?= $comment_date ?></small>
                                </h4>
                                <?= $comment_content ?>
                            </div>
                        </div>

                <?php } ?>

            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'?>            
        </div>
        <!-- /.row -->
        <hr>
<?php include 'includes/footer.php' ?>
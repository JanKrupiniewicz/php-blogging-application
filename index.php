<?php 
include 'includes/db.php';
include 'includes/header.php';
?>

<body>

    <!-- Navigation -->
    <?php include 'includes/navigation.php' ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="page-header">
                <h1 class="page-header">
                        The World Travel Blog
                        <small>Explore. Dream. Discover.</small>
                </h1>
                <img src="images/warsaw.jpg" class="img-fluid" style='max-width: 100%; height: auto;' alt="Responsive image">
            </div>

            <?php include 'includes/login_err_modal.php'; ?>

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                $page = "";
                $page_counter = 5;
                if(isset($_GET['page'])) {
                    $page = $_GET['page'];
                } 

                if($page == "" || $page == 1) {
                    $page_display = 0;
                } else {
                    $page_display = $page * $page_counter - $page_counter;
                }


                $query = "SELECT * FROM posts";
                $query .= " WHERE post_status = 'Published'";
                $select_all_query = mysqli_query($connection, $query);
                $posts_number = mysqli_num_rows($select_all_query);
                $posts_number = ceil($posts_number / $page_counter);

                if (mysqli_num_rows($select_all_query) == 0) {
                    echo "<h1 class='text-center' > No posts available. </h1>";
                } else {
                    $query = "SELECT * FROM posts";
                    $query .= " WHERE post_status = 'Published' LIMIT $page_display, $page_counter";
                    $select_limit_query = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_assoc($select_limit_query)) {
                        $post_id = $row['postID'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        ?>
                        <h2>
                            <a href="post.php?p_id=<?= $post_id ?>"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="author_posts.php?author=<?php echo $post_author?>&p_id=<?php echo $post_id?>"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                        <hr>
                        <a href="post.php?p_id=<?= $post_id ?>">
                            <img class="img-responsive" src="images/<?= $post_image ?>" alt="">
                        </a>
                        <hr>
                        <p><?php echo substr(strip_tags($post_content), 0, 100); ?></p>
                        <a class="btn btn-primary" href="post.php?p_id=<?= $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>

                <?php } } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'?>            

        </div>
        <!-- /.row -->

        <hr>   
        <ul class="pager">
            <?php 
                for($i = 1; $i <= $posts_number; $i++) {
                    if ($i == $page) {
                        echo "<li><a class='active_link' href='index.php?page={$i}'> {$i} </a></li>";
                    } else {
                        echo "<li><a href='index.php?page={$i}'> {$i} </a></li>";
                    }
                    
                    if($i % 10 == 0) {
                        echo '<br>';
                    }
                }
            ?>
        </ul>

<?php include 'includes/footer.php' ?>
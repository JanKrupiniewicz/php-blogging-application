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
            <h1 class="page-header">
                The World Travel Blog
                <small>Explore. Dream. Discover.</small>
            </h1>

            <div class="col-md-8">
                <form action="" method="post" enctype="multipart/form-data">

                    <?php
                    if(isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        $query = "SELECT * FROM users WHERE username = '{$username}'";
                        $select_user_profile_query = mysqli_query($connection, $query);
                        while($row = mysqli_fetch_assoc($select_user_profile_query)) {
                            $user_id   = $row['user_id'];
                            $username = $row['username'];
                            $user_password = $row['user_password'];
                            $user_firstname = $row['user_firstname'];
                            $user_lastname = $row['user_lastname'];
                            $user_email = $row['user_email'];
                            $user_role = $row['user_role'];
                            $user_image = $row['user_image'];
                        }
                    }
                    editUser($user_id, $user_password);
                    ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?php
                                if (!empty($user_image)) {
                                    echo "<img src='images/$user_image' alt='user image' style='width: 100%;' class='img-thumbnail'>";
                                } else {
                                    echo "<p>No image available</p>";
                                }     
                            ?>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <label for="author"> Firstname </label>
                                <input type="text" value="<?=$user_firstname?>" class="form-control" name="user_firstname">
                            </div>

                            <div class="form-group"> 
                                <label for="status"> Lastname </label>
                                <input type="text" value="<?=$user_lastname?>" class="form-control" name="user_lastname">
                            </div>

                            <div class="form-group"> 
                                <label for="image"> User Image </label>
                                <input type="file" name="image">
                            </div>
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label for="tags"> Username </label>
                        <input type="text" value="<?=$username?>" class="form-control" name="username">
                    </div>

                    <div class="form-group"> 
                        <label for="tags"> Email </label>
                        <input type="email" value="<?=$user_email?>" class="form-control" name="user_email">
                    </div>

                    <div class="form-group"> 
                        <label for="tags"> Password </label>
                        <input type="password" class="form-control" name="user_password">
                    </div>

                    <div class="form-group"> 
                        <input class="btn btn-primary" type="submit" name="edit_user" value="Update Profile">
                    </div>
                </form>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'?>            

        </div>
    <hr>   
<?php include 'includes/footer.php' ?>
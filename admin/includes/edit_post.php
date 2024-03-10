<?php 
    if(isset($_GET['p_id'])) {
        $get_post_id = $_GET['p_id'];
    }
    $query = "SELECT * FROM posts WHERE postID = {$get_post_id}";
    $select_posts_by_id = mysqli_query($connection, $query);

    $change_post = mysqli_fetch_assoc($select_posts_by_id);
    $post_id = $change_post['postID'];
    $post_title = $change_post['post_title'];
    $post_author = $change_post['post_author'];
    $post_category_id = $change_post['post_category_ID'];
    $post_date = $change_post['post_date'];
    $post_image = $change_post['post_image'];
    $post_tags = $change_post['post_tags'];
    $post_comment_count = $change_post['post_comment_count'];
    $post_status = $change_post['post_status'];
    $post_content = $change_post['post_content'];

    if(isset($_POST['update_post'])) {
        updatePost($post_id);
        echo "<p class='bg-info text-white'> Post Updated Succesfully <a href='../post.php?p_id=$get_post_id'> View Post </a> </p>";
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group"> 
        <label for="title"> Post Title </label>
        <input type="text" value="<?= $post_title ?>" class="form-control" name="title">
    </div>

    <div class="form-group"> 
        <select name="post_category" id="">
            <option value="<?php echo $post_category_id?>"> -- Choose Post Category -- </option>
            <?php 
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);
                confirmQuery($select_categories);

                while($row = mysqli_fetch_assoc($select_categories)) {
                    $category_id = $row['categoryID'];
                    $category_title = $row['Title'];
                    echo "<option value='$category_id'>$category_title</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group"> 
        <label for="author"> Post Author </label>
        <input type="text" value="<?= $post_author ?>" class="form-control" name="author">
    </div>

    <div class="form-group"> 
        <?php 
            $updated_status = checkPostStatus($get_post_id);
            if ($updated_status == 'Draft') {
                ?>
                    <label for="status"> Post Status </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Draft" name="status" checked>
                        <label class="form-check-label" for="Draft">Draft</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Published" name="status">
                        <label class="form-check-label" for="Published">Published</label>
                    </div>
                <?php
            } else {
                ?>
                    <label for="status"> Post Status </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Draft" name="status">
                        <label class="form-check-label" for="Draft">Draft</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Published" name="status" checked>
                        <label class="form-check-label" for="Published">Published</label>
                    </div>
                <?php
            }
        ?>
    </div>

    <div class="form-group"> 
        <img src="../images/<?=$post_image?>" width=100>
    </div>
    
    <div class="form-group"> 
        <label for="image"> Post Image </label>
        <input type="file" name="image">
    </div>

    <div class="form-group"> 
        <label for="tags"> Post Tags </label>
        <input type="text" value="<?= $post_tags ?>" class="form-control" name="tags">
    </div>

    <div class="form-group"> 
        <label for="content"> Post Content </label>
        <textarea class="form-control"name="content" id="summernote" cols="30" rows="10"><?= $post_content ?></textarea>
    </div>

    <div class="form-group"> 
        <input class="btn btn-primary btn-block" type="submit" name="update_post" value="Publish Changes">
        <input class="btn btn-outline-primary btn-block" type="reset" value="Clear Changes">
    </div>
</form>

<button type="button" class="btn btn-secondary btn-lg btn-block" onclick="location.href='posts.php'">
    Come Back
</button>

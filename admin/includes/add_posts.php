<?php
    if(isset($_POST['create_post'])) {
        createPost();
        echo "Post Created Succesfully! <a href='posts.php'>View Posts</a>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group"> 
        <label for="title"> Post Title </label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group"> 
        <select name="category" id="">
            <option value=""> -- Choose Post Category -- </option>
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
        <input type="text" class="form-control" name="author">
    </div>

    <div class="form-group"> 
        <select name="status">
            <option value="Draft"> -- Choose Post Status -- </option>
            <option value="Published">Published</option>
            <option value="Draft">Draft</option>
        </select>
    </div>

    <div class="form-group"> 
        <label for="image"> Post Image </label>
        <input type="file" name="image">
    </div>

    <div class="form-group"> 
        <label for="tags"> Post Tags </label>
        <input type="text" class="form-control" name="tags">
    </div>

    <div class="form-group"> 
        <label for="content"> Post Content </label>
        <textarea class="form-control" name="content" id="summernote" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group"> 
        <input class="btn btn-primary btn-block" type="submit" name="create_post" value="Publish Post">
        <input class="btn btn-outline-primary btn-block" type="reset" value="Clear Changes">
    </div>
</form>

<button type="button" class="btn btn-secondary btn-lg btn-block" onclick="location.href='posts.php'">
    Come Back
</button>
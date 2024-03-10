<form action="" method="post"> 
    <div class="form-group"> 
        <label for="cat_title"> Update Category </label>
        <?php 
            if(isset($_GET['update'])) {
                $category_id_get = $_GET['update'];
                $query = "SELECT * FROM categories WHERE categoryID = $category_id_get";
                $select_categories_id = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_categories_id)) {
                    $category_id = $row['categoryID'];
                    $category_title = $row['Title'];
                    ?>
                    <input value="<?php if(isset($category_title)) echo $category_title; ?>" type="text" class="form-control" name="cat_title_u">    
                    <?php
                }
            }

            if(isset($_POST['submitU'])) {
                $category_title = $_POST['cat_title_u'];
                $query = "UPDATE categories SET Title = '{$category_title}' ";
                $query .= " WHERE categoryID = {$category_ID}";
                $update_query = mysqli_query($connection, $query);
                if(!$update_query) {
                    die('QUERY FAILED' . mysqli_error($connection));
                }
                header("Location: categories.php");
                exit;
            }
        ?>
    </div>
    <div class="form-group"> 
        <input class="btn btn-primary" type="submit" name="submitU" value="Update Category">
    </div>
</form>
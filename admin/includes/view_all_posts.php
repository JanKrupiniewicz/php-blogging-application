<?php 
    include "delete_modal.php";

    if(isset($_POST['checkBoxArray'])) {
        foreach($_POST['checkBoxArray'] as $postID) {
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options) {
                case 'Published':
                case 'Draft':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE postID = '{$postID}'";
                    $update_posts = mysqli_query($connection, $query);
                    confirmQuery($update_posts);
                    break;
                case 'Clone':
                    $query = "SELECT * FROM posts WHERE postID = '{$postID}'";
                    $select_posts = mysqli_query($connection, $query);
            
                    $clone_post = mysqli_fetch_assoc($select_posts);
                    $post_title = $clone_post['post_title'];
                    $post_author = $clone_post['post_author'];
                    $post_category_id = $clone_post['post_category_ID'];
                    $post_date = $clone_post['post_date'];
                    $post_image = $clone_post['post_image'];
                    $post_tags = $clone_post['post_tags'];
                    $post_comment_count = $clone_post['post_comment_count'];
                    $post_status = $clone_post['post_status'];
                    $post_content = $clone_post['post_content'];

                    $query = "INSERT INTO posts(post_category_ID, post_title, post_author, post_date, post_image, post_content, post_tags, post_status)";
                    $query .= " VALUES($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', '$post_status')";
                    $clone_posts = mysqli_query($connection, $query);
                    confirmQuery($clone_posts);
                    break;
                case 'Delete':
                    $query = "DELETE FROM posts WHERE postID = '{$postID}'";
                    $update_posts = mysqli_query($connection, $query);
                    confirmQuery($update_posts);
                    break;
                default:
                    break;
            }
        }
    }
?>

<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="moreOptions">
            <div class="col-xs-4">
                <select class="form-control" name="bulk_options" id="">
                    <option value="">Select Option</option>
                    <option value="Published">Publish</option>
                    <option value="Clone">Clone</option>
                    <option value="Draft">Draft</option>
                    <option value="Delete">Delete</option>
                </select>
            </div>
            <div class="col-xs-4">
                <input type="submit" name="submit" class="btn btn-info" value="Apply">
                <a class="btn btn-primary" href="posts.php?source=add_post" role="button">Add New</a>
            </div>
        </div>
        <thead>
            <tr>
                <th><input class='checkBox' id="selectAllBoxes" type="checkbox"></th>
                <th> ID </th>
                <th> Author </th>
                <th> Title </th>
                <th> Category </th>
                <th> Status </th>
                <th> Image </th>
                <th> Tags </th>
                <th> Comments </th>
                <th> Date </th>
                <th> Views </th>
                <th> Reset Views </th>
                <th> Edit </th>
                <th> Delete </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $query = "SELECT * FROM posts ORDER BY post_date DESC";
                $select_posts = mysqli_query($connection, $query);
            
                while($row = mysqli_fetch_assoc($select_posts)) {
                    $post_id = $row['postID'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_category_id = $row['post_category_ID'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_status = $row['post_status'];
                    $post_views_count = $row['post_views_count'];

                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $select_all_comments_query = mysqli_query($connection, $query);
                    $post_comment_count = mysqli_num_rows($select_all_comments_query);

                    echo "<tr>";
                    echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='$post_id'></td>";
                    echo "<td> $post_id </td>";
                    echo "<td> $post_author </td>";
                    echo "<td><a href='../post.php?p_id={$post_id}'> $post_title </td>";
                
                    $query = "SELECT * FROM categories WHERE categoryID = $post_category_id";
                    $select_categories = mysqli_query($connection, $query);
                    $get_category = mysqli_fetch_assoc($select_categories);
                    if (isset($get_category['Title'])) {
                        $category_title = $get_category['Title'];
                    } else {
                        $category_title = 'No Valid Category';
                    }
                    
                    echo "<td> $category_title </td>";
                    echo "<td> $post_status </td>";
                    echo "<td> <img width='100' src='../images/{$post_image}'></td>";
                    echo "<td> $post_tags </td>";
                    echo "<td><a href='posts.php?source=view_comments&p_id={$post_id}'> $post_comment_count </a></td>";
                    echo "<td> $post_date </td>";
                    echo "<td> $post_views_count </td>";
                    echo "<td><a href='posts.php?reset_view={$post_id}'> Reset </a></td>";
                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'> Edit </a></td>";
                    echo "<td><a onClick=\"javascript: return confirm('Your post will be deleted permanently.');\" href='posts.php?delete={$post_id}'> Delete </a></td>";
                    echo "</tr>";
                }
            ?>
            <?php 
            deletePost();
            resetPostView();
            ?> 
        </tbody>
    </table>
</form>
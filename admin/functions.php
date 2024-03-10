<?php
function createUser() {
    global $connection;
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $options = ['cost' => 10];
    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, $options);

    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($user_image_temp, "../images/$user_image");

    $query = "INSERT INTO users (user_firstname, user_lastname, user_role, username, user_email, user_password, user_image)";
    $query .= " VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$hashed_password}', '{$user_image}')";

    $create_user_query = mysqli_query($connection, $query);
    confirmQuery($create_user_query);
}

function createPost() {
    global $connection;
    $post_title = $_POST['title'];
    $post_category_id = $_POST['category'];
    $post_status = $_POST['status'];
    $post_author = $_POST['author'];

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = $_POST['tags'];
    $post_content = $_POST['content'];
    $post_date = date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/$post_image");
    $query = "INSERT INTO posts (post_category_ID, post_title, post_author, 
    post_date, post_image, post_content, post_tags, post_status)";
    $query .= " VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', now(), '{$post_image}', 
        '{$post_content}', '{$post_tags}', '{$post_status}')";

    $create_post_query = mysqli_query($connection, $query);
    confirmQuery($create_post_query);
}

function updatePost($post_id) {
    global $connection;
    $updated_author = $_POST['author'];
    $updated_title = $_POST['title'];
    $updated_category_id = $_POST['post_category'];
    $updated_status = $_POST['status'];
    $updated_tags = $_POST['tags'];
    $updated_content = $_POST['content'];

    $updated_image = $_FILES['image']['name'];
    $updated_image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($updated_image_tmp, "../images/$updated_image");

    if(empty($updated_image)) {
        $image_query = "SELECT * FROM posts WHERE postID = '$post_id' ";
        $select_image = mysqli_query($connection, $image_query);
        $image_post = mysqli_fetch_array($select_image);
        $updated_image = $image_post['post_image'];
    }

    $query = "UPDATE posts SET ";
    $query .= "post_author = '$updated_author', ";
    $query .= "post_title = '$updated_title', ";
    $query .= "post_category_ID = '$updated_category_id', ";
    $query .= "post_status = '$updated_status', ";
    $query .= "post_date = now(), ";
    $query .= "post_tags = '$updated_tags', ";
    $query .= "post_content = '$updated_content', ";
    $query .= "post_image = '$updated_image' ";
    $query .= "WHERE postID  = $post_id";

    $update_post = mysqli_query($connection, $query);
    confirmQuery($update_post);
}

function checkPostStatus($post_id) {
    global $connection;
    $query = "SELECT * FROM posts WHERE postID = {$post_id}";
    $select_posts_by_id = mysqli_query($connection, $query);
    $change_post = mysqli_fetch_assoc($select_posts_by_id);
    return $change_post['post_status'];
}

function commentsActions() {
    global $connection;
    if(isset($_GET['delete'])) {
        $comment_id = $_GET['delete'];
        $query = "DELETE FROM comments WHERE comment_id = {$comment_id}";
        $delete_query = mysqli_query($connection, $query);
        confirmQuery($delete_query);
        header("Location: comments.php");
        exit;
    }

    if(isset($_GET['unapprove'])) {
        $comment_id = $_GET['unapprove'];
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$comment_id}";
        $unapprove_query = mysqli_query($connection, $query);
        confirmQuery($unapprove_query);
        header("Location: comments.php");
        exit;
    }

    if(isset($_GET['approve'])) {
        $comment_id = $_GET['approve'];
        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$comment_id}";
        $approve_query = mysqli_query($connection, $query);
        confirmQuery($approve_query);
        header("Location: comments.php");
        exit;
    }
}

function deletePost() {
    global $connection;
    if(isset($_GET['delete'])) {
        $post_id = $_GET['delete'];

        $delete_related_comments = "DELETE FROM comments WHERE comment_post_id = {$post_id}";
        $delete_related_comments_query = mysqli_query($connection, $delete_related_comments);
        confirmQuery($delete_related_comments_query);

        $post_id = mysqli_real_escape_string($connection, $post_id);
        $query = "DELETE FROM posts WHERE postID = {$post_id}";
        $delete_query = mysqli_query($connection, $query);
        confirmQuery($delete_query);

        header("Location: posts.php");
    }
}
function resetPostView() {
    global $connection;
    if(isset($_GET['reset_view'])) {
        $post_id = $_GET['reset_view'];
        $post_id = mysqli_real_escape_string($connection, $post_id);
        $query = "UPDATE posts SET post_views_count = 0 WHERE postID = {$post_id}";
        $reset_query = mysqli_query($connection, $query);
        confirmQuery($reset_query);
        header("Location: posts.php");
    }
}

function changeToAdmin() {
    global $connection;
    if(isset($_GET['change_to_admin']) && $_SESSION['user_role'] == 'admin') {
        $user_id = mysqli_real_escape_string($connection, $_GET['change_to_admin']);
        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$user_id}";
        $change_to_admin_query = mysqli_query($connection, $query);
        confirmQuery($change_to_admin_query);
        header("Location: users.php");
        exit;
    }

}
function deleteUsers() {
    global $connection;
    if(isset($_GET['delete']) && $_SESSION['user_role'] == 'admin') {
        $user_id  = mysqli_real_escape_string($connection, $_GET['delete']);
        $query = "DELETE FROM users WHERE user_id  = {$user_id}";
        $delete_query = mysqli_query($connection, $query);
        confirmQuery($delete_query);
        header("Location: users.php");
        exit;
    }
}

function changeToSub() {
    global $connection;
    if(isset($_GET['change_to_sub']) && $_SESSION['user_role'] == 'admin') {
        $user_id = mysqli_real_escape_string($connection, $_GET['change_to_sub']);
        $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$user_id}";
        $change_to_sub_query = mysqli_query($connection, $query);
        confirmQuery($change_to_sub_query);
        header("Location: users.php");
        exit;
    }
}

function dislayUserRole($user_role) {
    if($user_role == 'admin') {
        echo "<option value='admin'> Admin </option>";
        echo "<option value='subscriber'> Subscriber </option>";
    } else {
        echo "<option value='subscriber'> Subscriber </option>";
        echo "<option value='admin'> Admin </option>";
    } 
}

function editUser($user_id, $user_password) {
    global $connection;
    $updated_user_firstname = $_POST['user_firstname'];
    $updated_user_lastname = $_POST['user_lastname'];
    $updated_user_role = $_POST['user_role'];
    $updated_username = $_POST['username'];
    $updated_user_email = $_POST['user_email'];
    $updated_user_password = $_POST['user_password'];

    $options = ['cost' => 10];
    $hashed_password = password_hash($updated_user_password, PASSWORD_BCRYPT, $options);

    $updated_image = $_FILES['image']['name'];
    $updated_image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($updated_image_temp, "../images/$updated_image");

    if(empty($updated_user_password)) {
        $hashed_password = $user_password;
    }

    if(empty($updated_image)) {
        $image_query = "SELECT * FROM users WHERE user_id = '$user_id' ";
        $select_image = mysqli_query($connection, $image_query);
        $users_image = mysqli_fetch_array($select_image);
        $updated_image = $users_image['user_image'];
    }

    $update_query = "UPDATE users SET ";
    $update_query .= "username = '$updated_username', ";
    $update_query .= "user_password = '$hashed_password', ";
    $update_query .= "user_firstname = '$updated_user_firstname', ";
    $update_query .= "user_lastname = '$updated_user_lastname', ";
    $update_query .= "user_email = '$updated_user_email', ";
    $update_query .= "user_role = '$updated_user_role', ";
    $update_query .= "user_image = '$updated_image' ";
    $update_query .= "WHERE user_id = $user_id";

    $update_user = mysqli_query($connection, $update_query);
    confirmQuery($update_user);
    header("Location: ./users.php");
    exit;
}

function checkNumberPosts() {
    global $connection;
    $query = "SELECT * FROM posts WHERE post_status = 'Published'";
    $select_published_posts = mysqli_query($connection, $query);
    $published_post_counts = mysqli_num_rows($select_published_posts);
    return $published_post_counts;
}

function checkNumberDraftPosts() {
    global $connection;
    $query = "SELECT * FROM posts WHERE post_status = 'Draft'";
    $select_draft_posts = mysqli_query($connection, $query);
    $draft_post_counts = mysqli_num_rows($select_draft_posts);
    return $draft_post_counts;
}

function checkNumberAdmins() {
    global $connection;
    $query = "SELECT * FROM users WHERE user_role = 'admin'";
    $select_admins = mysqli_query($connection, $query);
    $admins_counts = mysqli_num_rows($select_admins);
    return $admins_counts;
}

function checkNumberSubs() {
    global $connection;
    $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
    $select_subs = mysqli_query($connection, $query);
    $subs_counts = mysqli_num_rows($select_subs);
    return $subs_counts;
}

function checkNumberUnComments() {
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
    $select_un_comments = mysqli_query($connection, $query);
    $un_comments_counts = mysqli_num_rows($select_un_comments);
    return $un_comments_counts;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function countRecords($type_of_record) {
    global $connection;
    $query = "SELECT * FROM {$type_of_record}";
    $select_records = mysqli_query($connection, $query);
    $records_counts = mysqli_num_rows($select_records);
    confirmQuery($records_counts);
    return $records_counts;
}

function users_online() {
    global $connection;
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 60;
    $time_out = $time - $time_out_in_seconds;

    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($send_query);

    if($count == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
    } else {
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    $users_online = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
    return mysqli_num_rows($users_online);
}

function confirmQuery($result) {
    global $connection;
    if(!$result) {
        die("QUERY FAILED " . mysqli_error($connection));
    }
}

function insert_categories() {
    global $connection;
    if(isset($_POST['submitC'])) {
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories(Title) ";
            $query .= "VALUE('{$cat_title}') ";
            $create_category_query = mysqli_query($connection, $query);
            if(!$create_category_query) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
        }
    }
}
function findAllCategories() {
    global $connection;
    $query = "SELECT * FROM categories";
    $select_all_categories = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_all_categories)) {
        $category_id = $row['categoryID'];
        $category_title = $row['Title'];
        echo "<tr>";
        echo  "<td> {$category_id} </td>";
        echo "<td> {$category_title} </td>";
        echo "<td><a href='categories.php?delete={$category_id}'> Delete </a></td>";
        echo "<td><a href='categories.php?update={$category_id}'> Update </a></td>";
        echo "</tr>";
    }
}
function deleteCategories() {
    global $connection;
    if(isset($_GET['delete'])) {
        $get_category_id = $_GET['delete'];
        $query = "DELETE FROM categories";
        $query .= " WHERE categoryID = {$get_category_id}";
        mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

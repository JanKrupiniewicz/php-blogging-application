<?php
    if(isset($_GET['usr_id'])) {
        $user_id  = $_GET['usr_id'];
    }

    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $elect_user_by_id = mysqli_query($connection, $query);
    $change_user = mysqli_fetch_assoc($elect_user_by_id);

    $user_firstname = $change_user['user_firstname'];
    $user_lastname = $change_user['user_lastname'];
    $user_role = $change_user['user_role'];
    $username = $change_user['username'];
    $user_email = $change_user['user_email'];
    $user_password = $change_user['user_password'];

    if(isset($_POST['edit_user'])) {
        editUser($user_id, $user_password);
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group"> 
        <label for="author"> Firstname </label>
        <input type="text" value="<?=$user_firstname?>" class="form-control" name="user_firstname">
    </div>

    <div class="form-group"> 
        <label for="status"> Lastname </label>
        <input type="text" value="<?=$user_lastname?>" class="form-control" name="user_lastname">
    </div>

    <div class="form-group"> 
        <select name="user_role" id="">
            <?php 
                if($user_role == 'admin') {
                    echo "<option value='admin'> Admin </option>";
                    echo "<option value='subscriber'> Subscriber </option>";
                } else {
                    echo "<option value='subscriber'> Subscriber </option>";
                    echo "<option value='admin'> Admin </option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group"> 
        <label for="image"> User Image </label>
        <input type="file" name="image">
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
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
        <input class="btn btn-outline-primary" type="reset" value="Clear Changes">
    </div>
</form>
<?php
    if(isset($_POST['create_user'])) {
        createUser();
        echo "User Created Succesfully! <a href='users.php'>View Users</a>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group"> 
        <label for="author"> Firstname </label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group"> 
        <label for="status"> Lastname </label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group"> 
        <select name="user_role" id="">
            <option value="subscriber"> -- Choose User Role -- </option>
            <option value="admin"> Admin </option>
            <option value="subscriber"> Subscriber </option>
        </select>
    </div>

    <div class="form-group"> 
        <label for="image"> User Image </label>
        <input type="file" name="image">
    </div>

    <div class="form-group"> 
        <label for="tags"> Username </label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group"> 
        <label for="tags"> Email </label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group"> 
        <label for="tags"> Password </label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group"> 
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>
</form>
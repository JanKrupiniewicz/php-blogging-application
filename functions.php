<?php
function editUser($user_id, $user_password) {
    global $connection;
    if(isset($_POST['edit_user'])) {
        $updated_user_firstname = $_POST['user_firstname'];
        $updated_user_lastname = $_POST['user_lastname'];
        $updated_username = $_POST['username'];
        $updated_user_email = $_POST['user_email'];
        $updated_user_password = $_POST['user_password'];
    
        $options = ['cost' => 10];
        $hashed_password = password_hash($updated_user_password, PASSWORD_BCRYPT, $options);
    
        $updated_image = $_FILES['image']['name'];
        $updated_image_temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($updated_image_temp, "images/$updated_image");
    
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
        $update_query .= "user_image = '$updated_image' ";
        $update_query .= "WHERE user_id = $user_id";
    
        mysqli_query($connection, $update_query);
        header("Location: user_profile.php");
        exit;
    }   
}

function submitMail() {
    if (isset($_POST['submit'])) {
        $mail_to = 'jkrupiniewicz@gmail.com';
        $subject = wordwrap($_POST['subject'], 70);
        $txt = $_POST['user_comment'];
        $email = $_POST['email'];

        if (empty($email) || empty($subject) || empty($txt)) {
            echo "All fields are required.";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email address.";
            } else {
                $headers = "From: $email" . "\r\n" .
                "Reply-To: $email" . "\r\n" .
                "X-Mailer: PHP/" . phpversion();

                if (mail($mail_to, $subject, $txt, $headers)) {
                    header("Location: contact.php?mail=success");
                    exit;
                } else {
                    header("Location: contact.php?mail=fail");
                    exit;
                }
            }
        }
    }
}

function createComment(&$nameErr, &$emailErr, &$contentErr) {
  global $connection;
  $invalid_input = false;
  if(isset($_POST['create_comment'])) {
    $post_id = $_GET['p_id'];
    if (empty($_POST["comment_author"])) {
        $nameErr = "Name is required";
        $invalid_input = true;
    } else {
        $author = test_input($_POST["comment_author"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $author)) {
            $nameErr = "Only letters and white space allowed";
            $invalid_input = true;
        }
    }

    if (empty($_POST["comment_email"])) {
        $emailErr = "Email is required";
        $invalid_input = true;
    } else {
        $email = test_input($_POST["comment_email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $invalid_input = true;
        }
    }

    if (empty($_POST["comment_content"])) {
        $contentErr = "Content is required";
        $invalid_input = true;
    } else {
        $content = test_input($_POST["comment_content"]);
    }

    if(!$invalid_input) {
        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
        $query .= " VALUES ($post_id, '$author', '$email', '$content', 'unapproved', now())";
        $insert_comment_query = mysqli_query($connection, $query);
        if(!$insert_comment_query) {
            die("QUERY FAILED" . mysqli_error($connection));
        }
    }
  }
}

function checkRegStatus(&$message) {
  if (isset($_GET['reg'])) {
    if ($_GET['reg'] == 'success') {
        $message = "Your Registration has been submitted.";
    } else {
        $message = "Fields cannot be empty!";
    }
  }
}

function submitRegistration() {
  global $connection;
  if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    if (!empty($username) && !empty($email) && !empty($password)) {
        $options = ['cost' => 10];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);

        $query = "INSERT INTO users(username, user_email, user_password, user_role)";
        $query .= " VALUES('$username', '$email', '$hashed_password', 'subscriber')";

        $register_user_query = mysqli_query($connection, $query);
        if (!$register_user_query) {
            die("QUERY FAILED" . mysqli_error($connection));
        }
        header("Location: registration.php?reg=success");
    } else {
        header("Location: registration.php?reg=fail");
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
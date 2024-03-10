<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php
    submitMail();
    if(isset($_GET['mail'])) {
        if($_GET['mail'] == 'success') {
            echo "<h4 class='text-center'>Email sent successfully.</h4>";
        } else {
            echo "<h4 class='text-center'>Failed to send email. Please try again later.</h4>";
        }
    }
?>

<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                    <h1>Contact</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email ... ">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject ...">
                            </div>
                            <div class="form-group"> 
                                <textarea class="form-control" name="user_comment" id="user_comment" rows='10'></textarea>
                            </div>
                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form> <br>
                        <span class="input-group-btn">
                            <a href="index.php" class="btn btn-primary btn-lg btn-block">Home Page</a>
                        </span>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
    <hr>
</div>

<?php include "includes/footer.php";?>

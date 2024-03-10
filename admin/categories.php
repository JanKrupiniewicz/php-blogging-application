<?php include 'includes/admin_header.php'?>

<div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin Site
                            <small>Author</small>
                        </h1>
                        
                        <div class="col-xs-6"> 
                            <?php insert_categories(); ?> 

                            <form action="" method="post"> 
                                <div class="form-group"> 
                                    <label for="cat_title"> Add Category </label>
                                    <input type="text" class="form-control" name="cat_title">
                                </div>
                                <div class="form-group"> 
                                    <input class="btn btn-primary" type="submit" name="submitC" value="Add Category">
                                </div>
                            </form>
                            
                            <?php // update and include query
                                if(isset($_GET['update'])) {
                                    $category_ID = $_GET['update'];
                                    include "includes/update_categories.php";
                                }
                            ?>
                        </div>

                        <div class="col-xs-6"> 
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> ID </th>
                                        <th> Category Title </th>
                                        <th> Delete </th>
                                        <th> Update </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php findAllCategories(); ?>
                                    <?php deleteCategories(); ?>               
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

<?php include "includes/admin_footer.php" ?>
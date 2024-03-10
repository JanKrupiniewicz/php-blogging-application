<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th> ID </th>
            <th> Author </th>
            <th> Comment </th>
            <th> Email </th>
            <th> Status </th>
            <th> Response To </th>
            <th> Date </th>
            <th> Approve </th>
            <th> Unapprove </th>
            <th> Delete </th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $query = "SELECT * FROM comments";
            $query .= " ORDER BY comment_date DESC";
            $select_comments = mysqli_query($connection, $query);
        
            while($row = mysqli_fetch_assoc($select_comments)) {
                $comment_id  = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $comment_author = $row['comment_author'];
                $comment_email = $row['comment_email'];
                $comment_content = $row['comment_content'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];

                echo "<tr>";
                echo "<td> $comment_id </td>";
                echo "<td> $comment_author </td>";
                echo "<td> $comment_content </td>";
                echo "<td> $comment_email </td>";
                echo "<td> $comment_status </td>";

                $query = "SELECT * FROM posts WHERE postID = $comment_post_id";
                $select_post = mysqli_query($connection, $query);
                $get_post = mysqli_fetch_assoc($select_post);
                $comment_post_title = $get_post['post_title'];

                echo "<td> <a href='../post.php?p_id=$comment_post_id'> $comment_post_title </a></td>";
                echo "<td> $comment_date </td>";
                echo "<td><a href='comments.php?approve=$comment_id'> Approve </a></td>";
                echo "<td><a href='comments.php?unapprove=$comment_id'> Unapprove </a></td>";
                echo "<td><a href='comments.php?delete=$comment_id'> Delete </a></td>";
                echo "</tr>";
            }
        ?>
        <?php commentsActions(); ?> 
    </tbody>
</table>
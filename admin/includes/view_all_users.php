<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th> ID </th>
            <th> Username </th>
            <th> Firstname </th>
            <th> Lastname </th>
            <th> Email </th>
            <th> Role </th>
            <th> Make Admin </th>
            <th> Make Subscriber </th>
            <th> Edit </th>
            <th> Delete </th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $query = "SELECT * FROM users";
            $query .= " ORDER BY user_firstname DESC";
            $select_comments = mysqli_query($connection, $query);
        
            while($row = mysqli_fetch_assoc($select_comments)) {
                $user_id   = $row['user_id'];
                $username = $row['username'];
                $user_password = $row['user_password'];
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];
                $user_email = $row['user_email'];
                $user_role = $row['user_role'];

                echo "<tr>";
                echo "<td> $user_id </td>";
                echo "<td> $username </td>";
                echo "<td> $user_firstname </td>";
                echo "<td> $user_lastname </td>";
                echo "<td> $user_email </td>";
                echo "<td> $user_role </td>";

                echo "<td><a href='users.php?change_to_admin=$user_id'> Make Admin </td>";
                echo "<td><a href='users.php?change_to_sub=$user_id'> Make Subscriber </td>";
                echo "<td><a href='users.php?source=edit_user&usr_id=$user_id'> Edit </td>";
                echo "<td><a href='users.php?delete=$user_id'> Delete </td>";
                echo "</tr>";
            }
        ?>

        <?php 
            changeToAdmin();
            changeToSub();
            deleteUsers();
        ?> 
    </tbody>
</table>
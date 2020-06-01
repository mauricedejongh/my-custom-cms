<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Author</th>
      <th>Comments</th>
      <th>Email</th>
      <th>Status</th>
      <th>In response to</th>
      <th>Date</th>
      <th>Approve</th>
      <th>Unapprove</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php

    $query = "SELECT * FROM comments";
    $select_comments = mysqli_query($connection, $query);

    if (!$select_comments) {
      die("No query was found" . mysqli_error());
    } else {
      while ($row = mysqli_fetch_assoc($select_comments)) {
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row['comment_email'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];
        ?>

        <tr>
          <td><?php echo $comment_id ?></td>
          <td><?php echo $comment_author ?></td>
          <td><?php echo $comment_content ?></td>
          <td><?php echo $comment_email; ?></td>
          <td><?php echo $comment_status; ?></td>
          <?php
            $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
            $select_post_id_query = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_post_id_query)) {
              $post_id = $row['post_id'];
              $post_title = $row['post_title'];

              echo "<td><a href='../post.php?post_id=$post_id'>$post_title</a></td>";
            }

           ?>

          <td><?php echo $comment_date; ?></td>

          <td><a href="comments.php?approve=<?php echo $comment_id; ?>">Approve</a></td>
          <td><a href="comments.php?unapprove=<?php echo $comment_id; ?>">Unapprove</a></td>
          <td><a href="comments.php?delete=<?php echo $comment_id; ?>">Delete</a></td>
        </tr>

      <?php }
    }
     ?>
  </tbody>
</table>

<?php

if (isset($_GET['approve'])) {
  $the_comment_id = $_GET['approve'];

  $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id}";
  $approve_comment_query = mysqli_query($connection, $query);
  confirm_query($approve_comment_query);

  header("Location: comments.php");
}


if (isset($_GET['unapprove'])) {
  $the_comment_id = $_GET['unapprove'];

  $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id}";
  $unapprove_comment_query = mysqli_query($connection, $query);
  confirm_query($unapprove_comment_query);

  header("Location: comments.php");
}


if (isset($_GET['delete'])) {
  $the_comment_id = $_GET['delete'];

  $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
  $delete_query = mysqli_query($connection, $query);
  confirm_query($delete_query);

  header("Location: comments.php");
}

 ?>

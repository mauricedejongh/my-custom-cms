<?php

// Retrieve id values of posts when clicking checkbox and submitting
// If publish is selected, make a query to set all posts to publish for every post that is $select_categories_id

if (isset($_POST['checkBoxArray'])) {
  $checkBoxArray = $_POST['checkBoxArray'];
  $bulk_options = $_POST['bulk_options'];

  forEach($checkBoxArray as $id) {

    switch ($bulk_options) {
      case 'publish':
      $query = "UPDATE posts SET post_status = 'publish' WHERE post_id = $id ";
      break;
      case 'draft';
      $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = $id ";
      break;
      case 'delete';
      $query = "DELETE FROM posts WHERE post_id = $id ";
      break;
      case 'clone';
      $query = "SELECT * FROM posts WHERE post_id = $id ";
      $select_posts = mysqli_query($connection, $query);
      confirm_query($select_posts);

      while ($row = mysqli_fetch_assoc($select_posts)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
      }

      $query = "INSERT INTO posts(post_author, post_title, post_category_id, post_status, post_image, post_content, post_tags, post_comment_count, post_date) ";
      $query .= "VALUES('{$post_author}', '{$post_title}', $post_category_id, '{$post_status}', '{$post_image}', '{$post_content}', '{$post_tags}', $post_comment_count, '{$post_date}')";
    }

    $update_posts = mysqli_query($connection, $query);

    confirm_query($update_posts);

  };
}

?>

<form action="" id="bulkform" method="post">

  <div id="bulkOptionsContainer" class="col-xs-4">
    <select class="form-control" name="bulk_options">
      <option value="">Select Options</option>
      <option value="publish">Publish</option>
      <option value="draft">Draft</option>
      <option value="delete">Delete</option>
      <option value="clone">Clone</option>
    </select>
  </div>

  <div class="col-xs-4">
    <input type="submit" name="submit" class="btn btn-success" value="Apply">
    <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
  </div>

  <table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th><input type="checkbox" id="selectboxes"></th>
      <th>Id</th>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Comments</th>
      <th>Date</th>
      <th>View post</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php

    $query = "SELECT * FROM posts ORDER BY post_id DESC";
    $select_posts = mysqli_query($connection, $query);

    if (!$select_posts) {
      die("No query was found" . mysqli_error());
    } else {
      while ($row = mysqli_fetch_assoc($select_posts)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date']; ?>

        <tr>
          <td><input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
          <td><?php echo $post_id ?></td>
          <td><?php echo $post_author ?></td>
          <td><?php echo $post_title ?></td>

          <?php
            $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
            $select_categories_id = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_categories_id)) {
              $cat_id = $row['cat_id'];
              $cat_title = $row['cat_title'];
            }
           ?>

          <td><?php echo $cat_title; ?></td>



          <td><?php echo $post_status; ?></td>
          <td><img width="100" src="../images/<?php echo $post_image; ?>"></td>
          <td><?php echo $post_tags; ?></td>
          <td><?php echo $post_comment_count; ?></td>
          <td><?php echo $post_date; ?></td>
          <td><a href="../post.php?post_id=<?php echo $post_id; ?>">View Post</a></td>
          <td><a href="posts.php?source=edit_post&p_id=<?php echo $post_id; ?>">Edit</a></td>
          <td><a onClick="return confirm('Are you sure you want to delete?')" href="posts.php?delete=<?php echo $post_id; ?>">Delete</a></td>
        </tr>

      <?php }
    }
     ?>
  </tbody>
</table>

</form>

<?php

if (isset($_GET['delete'])) {
  $post_id = $_GET['delete'];

  $query = "DELETE FROM posts WHERE post_id = {$post_id}";

  $delete_query = mysqli_query($connection, $query);
  header("Location: posts.php");
}

 ?>

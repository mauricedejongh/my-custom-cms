<?php
  if (isset($_POST['create_post'])) {

    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_author = $_POST['post_author'];
    $post_status = $_POST['post_status'];

    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if (!$post_title) {
      echo "Please enter a post title";
    }

    $query = "INSERT INTO posts(post_title, post_category_id, post_author, post_status, post_image, post_tags, post_content, post_date ) ";
    $query .= "VALUES('{$post_title}', '{$post_category_id}', '{$post_author}', '{$post_status}', '{$post_image}', '{$post_tags}', '{$post_content}', now() ) ";

    $create_post_query = mysqli_query($connection, $query);

    confirm_query($create_post_query);

    // Get the last created ID
    $p_id = mysqli_insert_id($connection);

    echo "<p class='bg-success'>Post Created. <a href='../post.php?post_id={$p_id}'>View Post</a> or
    <a href='posts.php'>View More Posts</a></p>";
  }
?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="post_title">Post Title</label>
    <input type="text" class="form-control" name="post_title">
  </div>

  <div class="form-group">
    <label for="post_category_id">Post Category Id</label>
    <select name="post_category_id" class="form-control" id="post_category_id">
      <?php
       $query = "SELECT * FROM categories";
       $select_all_categories = mysqli_query($connection, $query);

       confirm_query($select_all_categories);

       while ($row = mysqli_fetch_assoc($select_all_categories )) {
         $cat_id = $row['cat_id'];
         $cat_title = $row['cat_title'];
         echo "<option value='{$cat_id}'>{$cat_title}</option>";
       }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="post_author">Post Author</label>
    <input type="text" class="form-control" name="post_author">
  </div>

  <div class="form-group">
    <label for="post_status">Post Status</label>
    <select class="form-control" name="post_status">
      <option value="draft">Select Options</option>
      <option value="publish">Publish</option>
      <option value="draft">Draft</option>
    </select>
  </div>

  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" name="post_image">
  </div>

  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags">
  </div>

  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
  </div>
</form>

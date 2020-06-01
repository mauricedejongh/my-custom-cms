<?php

  if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
  }

  // SELECT FROM POSTS
  $query = "SELECT * FROM posts WHERE post_id = $p_id";
  $select_posts_query = mysqli_query($connection, $query);

  if (!$select_posts_query) {
    die("No query was found" . mysqli_error());
  } else {
    while ($row = mysqli_fetch_assoc($select_posts_query)) {
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
  }


  // UPDATE POST
  if (isset($_POST['update_post'])) {
    $post_author = $_POST['post_author'];
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];

    // Move image from temp location to real location
    move_uploaded_file($post_image_temp, '../images/$post_image');

    if (empty($post_image)) {
      $query = "SELECT * FROM posts WHERE post_id = $p_id";
      $select_image = mysqli_query($connection, $query);

      while ($row = mysqli_fetch_assoc($select_image)) {
        $post_image = $row['post_image'];
      }
    }

    $query = "UPDATE posts SET ";
    $query .= "post_author = '{$post_author}', ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_date = now(), ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_image = '{$post_image}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_tags = '{$post_tags}' ";
    $query .= "WHERE post_id = $p_id ";

    $update_post = mysqli_query($connection, $query);

    confirm_query($update_post);

    echo "<p class='bg-success'>Post Updated. <a href='../post.php?post_id={$p_id}'>View Post</a> or
    <a href='posts.php'>Edit More Posts</a></p>";
  }
?>

 <form action="" method="post" enctype="multipart/form-data">
   <div class="form-group">
     <label for="post_title">Post Title</label>
     <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
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
     <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">
   </div>

   <div class="form-group">
     <label for="post_status">Post Status</label>
     <select name="post_status" class="form-control" id="post_status">
       <option value="<?php echo $post_status; ?>"><?php echo ucfirst($post_status); ?></option>
       <?php
         if ($post_status === 'publish') {
           echo "<option value='draft'>Draft</option>";
         } else {
           echo "<option value='publish'>Publish</option>";
         }
       ?>
     </select>

   </div>

   <div class="form-group">
     <img src="../images/<?php echo $post_image; ?>" width="100" alt="">
   </div>

   <div class="form-group">
     <label for="post_image">Post Image</label>
     <input type="file" name="post_image">
   </div>

   <div class="form-group">
     <label for="post_tags">Post Tags</label>
     <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
   </div>

   <div class="form-group">
     <label for="post_content">Post Content</label>
     <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content; ?></textarea>
   </div>

   <div class="form-group">
     <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
   </div>
 </form>

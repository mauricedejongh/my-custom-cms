
<?php include "includes/header.php"; ?>

  <!-- Navigation -->
  <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <?php

                if (isset($_GET['post_id'])) {
                  $post_id = $_GET['post_id'];
                }

                $query = "SELECT * FROM posts WHERE post_id = $post_id";
                $result = mysqli_query($connection, $query);

                if (!$result) {
                  die("No query was found" . mysqli_error());
                } else {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_image = $row['post_image'];
                    $post_date = $row['post_date'];
                    $post_content = $row['post_content'];
                  }
                }
                ?>

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $post_title; ?>
                </h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="author.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                    <?php
                      if (isset($_SESSION['user_role'])) {
                        if (isset($_GET['post_id'])) {
                          $post_id = $_GET['post_id'];
                          echo "<a href='admin/posts.php?source=edit_post&p_id={$post_id}' style='float: right; display: inline-block;'>Edit Post</a>";
                        }

                      }
                    ?>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead">
                  <?php echo $post_content; ?>
                </p>

                <hr>

                <!-- Blog Comments -->

                <?php

                if (isset($_POST['create_comment'])) {
                  $comment_author = $_POST['comment_author'];
                  $comment_email = $_POST['comment_email'];
                  $comment_content = $_POST['comment_content'];

                  if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                    $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                    $query .= "VALUES($post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";

                    $create_comment_query = mysqli_query($connection, $query);

                    if (!$create_comment_query) {
                      die("QUERY FAILED: " . mysqli_error($create_comment_query));
                    }

                  } else {
                    echo "<p class='bg-danger'>The fields cannot be empty</p>";
                  }
                }

                $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                $query .= "WHERE post_id = $post_id ";
                $update_comment_count = mysqli_query($connection, $query);

                 ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                      <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                      </div>
                      <div class="form-group">
                        <label for="comment">Your comments</label>
                        <textarea class="form-control" rows="3" name="comment_content"></textarea>
                      </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php

                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
                $query .= "AND comment_status = 'approved' ";
                $query .= "ORDER BY comment_id DESC";

                $select_comment_query = mysqli_query($connection, $query);
                if (!$select_comment_query) {
                  die("Query Failed" . mysqli_error());
                }

                while ($row = mysqli_fetch_assoc($select_comment_query)) {
                  $comment_date = $row['comment_date'];
                  $comment_content = $row['comment_content'];
                  $comment_author = $row['comment_author'];
                  ?>

                  <!-- Comment -->
                  <div class="media">
                      <a class="pull-left" href="#">
                          <img class="media-object" src="http://placehold.it/64x64" alt="">
                      </a>
                      <div class="media-body">
                          <h4 class="media-heading"><?php echo $comment_author; ?>
                              <small><?php echo $comment_date; ?></small>
                          </h4>
                          <?php echo $comment_content; ?>
                      </div>
                  </div>

                <?php } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php"; ?>

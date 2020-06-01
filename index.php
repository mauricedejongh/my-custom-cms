<?php include "includes/header.php"; ?>

  <!-- Navigation -->
  <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    All posts
                </h1>

                <?php
                // PAGINATION
                // Limit offset: it request the queried number, starting by the offset number. 10, 5 meansL request 10, starting with 5.

                $per_page = 5;

                if (isset($_GET['page'])) {
                  $page = $_GET['page'];
                  if ($page === 1 || $page === "") {
                    $result_page_offset = 0;
                  } else {
                    $result_page_offset = ($page * $per_page) - $per_page;
                  }
                } else {
                  $result_page_offset = 0;
                }

                $query =  "SELECT * FROM posts WHERE post_status = 'publish' LIMIT $result_page_offset, $per_page";
                $get_limit_query = mysqli_query($connection, $query);

                function get_all_posts_count() {
                  global $connection;
                  $query =  "SELECT * FROM posts WHERE post_status = 'publish' ";
                  $get_all_posts_query = mysqli_query($connection, $query);
                  return mysqli_num_rows($get_all_posts_query);
                }

                $page_number = ceil(get_all_posts_count() / $per_page);

                while ($row = mysqli_fetch_assoc($get_limit_query)) {
                  $post_id = $row["post_id"];
                  $post_title = $row["post_title"];
                  $post_author = $row["post_author"];
                  $post_date = $row["post_date"];
                  $post_image = $row["post_image"];
                  $post_content = $row["post_content"];
                  ?>

                  <!-- Posts -->
                  <h2>
                      <a href="post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                  </h2>
                  <p class="lead">
                      by <a href="author.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                  </p>
                  <p><span class="glyphicon glyphicon-time"></span>
                    <?php echo $post_date; ?></p>
                  <hr>
                  <a href="post.php?post_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                  <hr>
                  <p><?php echo substr($post_content, 0, 150); ?></p>
                  <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <?php } ?>

                <?php
                  if ($page_number === 0) {
                    echo "<p>There are no posts</p>";
                  }

                ?>

                <hr>

                <!-- Pager -->
                <ul class="pager">
                  <?php

                    for ($i = 1; $i <= $page_number; $i++) {
                      if ($i == $page) {
                        echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                      } else {
                        echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                      }
                    }

                   ?>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<!-- Footer -->
<?php include "includes/footer.php"; ?>

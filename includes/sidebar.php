<div class="col-md-4">

    <!-- User login -->
    <div class="well">
        <h4>User login</h4>
        <form action="includes/login.php" method="post">
          <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Enter Username">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Enter Password">
          </div>
          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="login" value="Login">
            <a href="registration.php" class="btn btn-success">New account</a>
          </div>
        </form><!--search form-->
        <!-- /.input-group -->
    </div>

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
          <div class="input-group">
              <input name="search" type="text" class="form-control">
              <span class="input-group-btn">
                  <button name="submit" class="btn btn-default" type="submit">
                      <span class="glyphicon glyphicon-search"></span>
              </button>
              </span>
          </div>
        </form><!--search form-->
        <!-- /.input-group -->
    </div>

    <?php

    // Have a username and password field
    // Query which checks if the username and password match a user in the DB
    // If username and password exist, then redirect the user to the admin
    // If username and password do not exist, redirect the user to the homepage


    ?>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
          <?php
          $query = "SELECT * FROM categories LIMIT 3";
          $select_categories_sidebar = mysqli_query($connection, $query);

          if (!$select_categories_sidebar) {
            die("No categories found" . mysqli_error());
          }
          ?>

          <div class="col-lg-12">
              <ul class="list-unstyled">
                  <?php
                    while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                      $cat_id = $row["cat_id"];
                      $cat_title = $row["cat_title"];
                      echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                    }
                   ?>
              </ul>
          </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>

</div>

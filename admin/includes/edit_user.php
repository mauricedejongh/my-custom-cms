<?php

    if (isset($_GET['user_id'])) {
      $the_user_id = $_GET['user_id'];
    }

    $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
    $select_user_query = mysqli_query($connection, $query);

    if (!$select_user_query) {
      die("No query was found" . mysqli_error());
    } else {
      $row = mysqli_fetch_assoc($select_user_query);
      $user_firstname = $row['user_firstname'];
      $user_lastname = $row['user_lastname'];
      $username = $row['username'];
      $user_role = $row['user_role'];
      $user_image = $row['user_image'];
      $user_email = $row['user_email'];
      ?>

      <?php
        if (isset($_POST['update_user'])) {

          $user_firstname = $_POST['user_firstname'];
          $user_lastname = $_POST['user_lastname'];
          $user_role = $_POST['user_role'];

          $user_image = $_FILES['user_image']['name'];
          $user_image_temp = $_FILES['user_image']['tmp_name'];

          move_uploaded_file($user_image_temp, "../images/$user_image");

          if (empty($user_image)) {
            $query = "SELECT * FROM users WHERE user_id = $the_user_id";
            $select_image = mysqli_query($connection, $query);

            $row = mysqli_fetch_assoc($select_image);
            $user_image = $row['user_image'];
          }

          $username = $_POST['username'];
          $user_email = $_POST['user_email'];
          $user_password = $_POST['user_password'];

          $query = "SELECT randSalt FROM users";
          $select_randsalt_query = mysqli_query($connection, $query);
          confirm_query($select_randsalt_query);
          $row = mysqli_fetch_assoc($select_randsalt_query);
          $salt = $row['randSalt'];
          $hashed_password = crypt($user_password, $salt);

          $query = "UPDATE users SET ";
          $query .= "user_firstname = '{$user_firstname}', ";
          $query .= "user_lastname = '{$user_lastname}', ";
          $query .= "user_role = '{$user_role}', ";
          $query .= "user_image = '{$user_image}', ";
          $query .= "username = '{$username}', ";
          $query .= "user_email = '{$user_email}', ";
          $query .= "user_password = '{$hashed_password}' ";
          $query .= "WHERE user_id = {$the_user_id} ";

          $edit_user_query = mysqli_query($connection, $query);

          confirm_query($edit_user_query);
        }
      ?>

        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="user_firstname">Firstname</label>
            <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
          </div>

          <div class="form-group">
            <label for="user_lastname">Lastname</label>
            <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
          </div>

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
          </div>

          <div class="form-group">
            <label for="user_role">User role</label>
            <select name="user_role" class="form-control" id="user_role">
              <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
              <?php
                if ($user_role === 'admin') {
                  echo "<option value='subscriber'>subscriber</option>";
                } else {
                  echo "<option value='admin'>admin</option>";
                }
              ?>
            </select>
          </div>

          <div class="form-group">
            <img src="../images/<?php echo $user_image; ?>" width="100" alt="">
          </div>

          <div class="form-group">
            <label for="user_image">User image</label>
            <input type="file" class="form-control" name="user_image">
          </div>

          <div class="form-group">
            <label for="user_email">Email</label>
            <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
          </div>

          <div class="form-group">
            <label for="user_password">Password</label>
            <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
          </div>

          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="update_user" value="Update User">
          </div>
        </form>


    <?php } ?>

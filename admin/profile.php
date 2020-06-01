<?php include "includes/admin_header.php"; ?>
<?php
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_profile = mysqli_query($connection, $query);

    $row = mysqli_fetch_assoc($select_user_profile);
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $username = $row['username'];
    $user_role = $row['user_role'];
    $user_image = $row['user_image'];
    $user_email = $row['user_email'];
    $user_password = $row['user_password'];
    $user_password = $row['user_password'];
  }
  }
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
      $query = "SELECT * FROM users WHERE username = '{$username}' ";
      $select_image = mysqli_query($connection, $query);

      while ($row = mysqli_fetch_assoc($select_image)) {
        $user_image = $row['user_image'];
      }
    }

    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];


    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "user_image = '{$user_image}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password = '{$user_password}' ";
    $query .= "WHERE username = '{$username}' ";

    $edit_user_query = mysqli_query($connection, $query);

    confirm_query($edit_user_query);
  }
?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome
                            <small><?php echo ucfirst($username); ?></small>
                        </h1>
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
                            <input class="btn btn-primary" type="submit" name="update_user" value="Update Profile">
                          </div>
                        </form>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>

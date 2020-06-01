<?php
  if (isset($_POST['create_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];

    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    move_uploaded_file($user_image_temp, "../images/$user_image");

    $username = $_POST['username'];
    $user_email = $_POST['user_email'];

    $user_password = $_POST['user_password'];
    $query = "SELECT randSalt FROM users";
    $select_randSalt_query = mysqli_query($connection, $query);
    confirm_query($select_randSalt_query);
    $row = mysqli_fetch_assoc($select_randSalt_query);
    $salt = $row['randSalt'];
    $user_password = crypt($user_password, $salt);

    $query = "INSERT INTO users(user_firstname, user_lastname, user_role, user_image, username, user_email, user_password) ";
    $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$user_image}', '{$username}', '{$user_email}', '{$user_password}') ";

    $create_user_query = mysqli_query($connection, $query);

    confirm_query($create_user_query);

    echo "User Created: " . " " . "<a href='users.php'>View Users</a>";
  }
?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="user_firstname">Firstname</label>
    <input type="text" class="form-control" name="user_firstname">
  </div>

  <div class="form-group">
    <label for="user_lastname">Lastname</label>
    <input type="text" class="form-control" name="user_lastname">
  </div>

  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username">
  </div>

  <div class="form-group">
    <label for="user_role">User role</label>
    <select name="user_role" class="form-control" id="user_role">
      <option value="subscriber">Select options</option>
      <option value="admin">Admin</option>
      <option value="subscriber">Subscriber</option>
    </select>
  </div>

  <div class="form-group">
    <label for="user_image">User image</label>
    <input type="file" class="form-control" name="user_image">
  </div>

  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" class="form-control" name="user_email">
  </div>

  <div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" class="form-control" name="user_password">
  </div>

  <!-- <div class="form-group">
    <label for="user_image">User Image</label>
    <input type="file" name="user_image">
  </div> -->

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
  </div>
</form>

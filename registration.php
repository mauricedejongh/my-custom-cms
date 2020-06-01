<?php  include "includes/header.php"; ?>

    <!-- Navigation -->

    <?php  include "includes/navigation.php"; ?>


    <?php
      if (isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);

        if (!empty($username) && !empty($email) && !empty($password)) {
          // Encrypt password with blowfish
          $query = "SELECT randSalt from users";
          $create_randSalt_query = mysqli_query($connection, $query);

          if (!$create_randSalt_query) {
            die("QUERY FAILED: " . mysqli_error($connection));
          }

          $row = mysqli_fetch_assoc($create_randSalt_query);
          $salt = $row['randSalt'];
          $password = crypt($password, $salt);

          $query = "INSERT INTO users(username, user_email, user_password, user_role) ";
          $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber') ";

          $register_user_query = mysqli_query($connection, $query);

          if (!$register_user_query) {
            die("QUERY FAILED: " . mysqli_error($connection));
          }

          $message = "<h6 class='bg-success'>Your registration has been submitted. " . " " . "<a href='index.php'>Go to home to login</p></a></h6>";
        } else {
          $message = "<h6 class='bg-danger'>Please fill in all the fields</h6>";
        }
      } else {
        $message = "";
      }
    ?>

    <!-- Page Content -->
    <div class="container">
      <section id="login">
          <div class="container">
              <div class="row">
                  <div class="col-xs-6 col-xs-offset-3">
                      <div class="form-wrap">
                        <h1>Register</h1>

                        <?php echo $message; ?>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                             <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                             <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                      </div>
                  </div> <!-- /.col-xs-12 -->
              </div> <!-- /.row -->
          </div> <!-- /.container -->
      </section>

        <hr>

<?php include "includes/footer.php";?>

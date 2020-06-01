<?php

function confirm_query($result) {
  global $connection;

  if (!$result) {
    die("QUERY FAILED: " . mysqli_error($connection));
  }
}

function insert_categories() {
  global $connection;

  if (isset($_POST['submit'])) {
    $cat_title = $_POST['cat_title'];

    if ($cat_title === "" || empty($cat_title)) {
      echo "This field should not be empty";
    } else {
      $query = "INSERT INTO categories(cat_title)";
      $query .= "VALUE('{$cat_title}')";

      $create_category_query = mysqli_query($connection, $query);

      if (!$create_category_query) {
        die("Query Failed" . mysqli_error());
      }
    }
  }
}

function find_all_categories() {
  global $connection;

  // Find all categories query
  $query = "SELECT * FROM categories";
  $result = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

    echo "<tr>";
    echo "<td>{$cat_id}</td>";
    echo "<td>{$cat_title}</td>";
    echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
    echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
    echo "</tr>";
  }
}

function delete_categories() {
  global $connection;

  if (isset($_GET['delete'])) {
    $cat_id_delete = $_GET['delete'];

    $query = "DELETE FROM categories WHERE cat_id = {$cat_id_delete}";
    $delete_query = mysqli_query($connection, $query);
    // Refresh the page after deleting
    header("Location: categories.php");
  }
}








 ?>

<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Mismatch - Where opposites attract!</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  
<?php

  require_once('appvars.php');
  require_once('connectvars.php');

  // Generate the navigation menu
  if (isset($_SESSION['username'])) {

    echo('<h2 class="login"> Вы вошли в приложение как '. $_SESSION['username'].'.</h2>');
    echo '<h3>Mismatch - Where opposites attract!</h3>';
    echo '&#10084; <a href="viewprofile.php">Просмотр профиля</a><br />';
    echo '&#10084; <a href="editprofile.php">Редактирование профиля</a><br />';  
    echo '&#10084; <a href="logout.php">Выход из приложения('.$_SESSION['username'] .') </a><br />';
  
  }else {
    echo('<h2 class="login"> Вы вошли в приложение как Гость.</h2>');
    echo '<h3>Mismatch - Where opposites attract!</h3>';
    echo '&#10084; <a href="login.php">Вход в приложение</a><br />';
    echo '&#10084; <a href="signup.php">Создание учетной записи</a><br />';
  }


  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

  // Retrieve the user data from MySQL
  $query = "SELECT user_id, first_name, picture FROM mismatch_user WHERE first_name IS NOT NULL ORDER BY join_date DESC LIMIT 5";
  $data = mysqli_query($dbc, $query);

  // Loop through the array of user data, formatting it as HTML
  echo '<h4>Latest members:</h4>';
  echo '<table>';
  while ($row = mysqli_fetch_array($data)) {
    if (is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) {
      echo '<tr><td><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['first_name'] . '" /></td>';
    }
    else {
      echo '<tr><td><img src="' . MM_UPLOADPATH . 'nopic.jpg' . '" alt="' . $row['first_name'] . '" /></td>';
    }
    echo '<td>' . $row['first_name'] . '</td></tr>';
  }
  echo '</table>';

  mysqli_close($dbc);
?>

</body> 
</html>

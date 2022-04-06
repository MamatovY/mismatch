<?php 
require_once('connectvars.php');
$error_msg="";
session_start();


if (!isset($_SESSION['user_id']) ) {
  
  if(isset($_POST['submit'])){
  
      $dbc=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      $user_username=mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password=mysqli_real_escape_string($dbc, trim($_POST['password']));


      if (!empty($user_username)&&!empty($user_password)) {
  
          $query = "SELECT user_id, username FROM mismatch_user
          WHERE username = '$user_username' AND password = SHA('$user_password')";

      $data = mysqli_query($dbc,$query);    


          if (mysqli_num_rows($data)== 1) {
  
              $row=mysqli_fetch_array($data);
              $_SESSION['user_id']=$row['user_id'];
              $_SESSION['username']=$row['username'];
              setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));    // Присваеваем куки который истечет через 30дней
              setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // Присваеваем куки который истечет через 30дней
              $home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
              header('Location: '.$home_url);

          }else {
              $error_msg='Извините, для того чтобы войти в приложение, вы должны ввести правильное имя и пароль.';

          }
      }else {
              $error_msg='Извините, для того чтобы войти в приложение, вы должны ввести правильное имя и пароль.';
          }
  }
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Несоответствия. Вход в приложение</title>
      <link type="text/css" rel="stylesheet" href="style.css">
  </head>

  <body>
  <h3>Несоответствия. Вход в приложение</h3>    

<?php
if (empty($_SESSION['user_id'])) {
  //Если пользователь не вошел выводится пустая $error_msg а если пользователь не правильно вел данные то присваевается значение
  echo '<p class="error">'. $error_msg. '</p>';

 ?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset>
  <legend>
  Вход в приложение.
  </legend>
  <label for="username">Имя пользователя</label>
  <input type="text" name="username" id="username" value=" <?php if (!empty($username)) echo $user_username; ?>" /><br />
  
  <label for="password">Пароль:</label>
  <input type="password" name="password" id="password" />
</fieldset>

<input type="submit" name="submit" value="Войти" />

</form>


<?php
}else {
  echo('<p class="login"> Вы вошли в приложение как '. $_SESSION['username'].'.</p>');
}
?>
  </body>
</html>
<?php
if (isset($_SESSION['username'])) {
    echo('<h2 class="login"> Вы вошли в приложение как '. $_SESSION['username'].'.</h2>');
    echo '&#10084; <a href="viewprofile.php">Просмотр профиля</a><br />';
    echo '&#10084; <a href="editprofile.php">Редактирование профиля</a><br />';  
    echo '&#10084; <a href="logout.php">Выход из приложения('.$_SESSION['username'] .') </a><br />';
  
  }else {
    echo('<h2 class="login"> Вы вошли в приложение как Гость.</h2>');
    echo '&#10084; <a href="login.php">Вход в приложение</a><br />';
    echo '&#10084; <a href="signup.php">Создание учетной записи</a><br />';
  }
  echo '<hr />';
?>
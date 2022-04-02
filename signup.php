<?php
require_once('appvars.php');
require_once('connectvars.php');

$dbc=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset($_POST['submit'])) {
    $username=mysqli_real_escape_string($dbc,trim($_POST['username']));
    $password1=mysqli_real_escape_string($dbc,trim($_POST['password1']));
    $password2=mysqli_real_escape_string($dbc,trim($_POST['password2']));

    if (!empty($username)&&!empty($password1)&&!empty($password2)&&$password1==$password2) {

        $query="SELECT * FROM mismatch_user WHERE username='$username'";
        $data=mysqli_query($dbc,$query);

        if (mysqli_num_rows($data)==0) {
            $query= "INSERT INTO mismatch_user(username,password,join_date) VALUES ('$username',SHA('$password1'),NOW())";
            mysqli_query($dbc,$query);
            echo "Вы зарегестрировались";
            echo "$username<br />$password1<br />$password2";
            mysqli_close($dbc);
            exit();


        }else {
            echo '<p class="error">Вы должны ввести все данные для создания учетной записи,</p>';
        }
    }else {
        echo '<p class="error">Вы должны ввести все данные для создания учетной записи, в том числе пароль дважды.</p>';
    }
}
mysqli_close($dbc);
?>



<p>
    Введите, пожалуйста, ваше имя и пароль для создания учетной записи в приложении&quot;Несоответствия&quot;\.
</p>

<form action="<?echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset>
    <legend>Входные данные</legend>
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" id="username" value="<?if (!empty($username)) { echo $username;} ?>"><br />
        <label for="password1">Пароль</label>
        <input type="password" name="password1" id="password1"><br />
        <label for="password2">Повторите пароль:</label>
        <input type="password" id="password2" name="password2" ><br />
</fieldset>
        <input type="submit" value="Создать" name="submit" />
</form>







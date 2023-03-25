<?php
  $host = "localhost";
  $user = "u52856";
  $pass = "4305513";
  $name = "u52856";

  $induction = mysqli_connect($host, $user, $pass, $name);

  $result1 = mysqli_query($induction, "SELECT * FROM `application`");
  $result2 = mysqli_query($induction, "SELECT * FROM `abilities`");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
  <title>Database u52856</title>
</head>
<body>
  <table>
    <caption>Данные из таблицы application</caption>
    <tr> 
      <th>&nbsp;</th>
      <th>Имя</th>
      <th>Почта</th>
      <th>Год</th>
      <th>Пол</th>
      <th>Преобладающая рука</th>
      <th>Биография</th>
    </tr>
    <?php
    while ($form = mysqli_fetch_assoc($result1)) {
      echo "
        <tr>
          <td>"; echo $form['application_id']; echo "</td>
          <td>"; echo $form['name']; echo "</td>
          <td>"; echo $form['email']; echo "</td>
          <td>"; echo $form['year']; echo "</td>
          <td>"; echo $form['gender']; echo "</td>
          <td>"; echo $form['hand']; echo "</td>
          <td>"; echo $form['biography']; echo "</td>
        </tr>
      ";
    }
  ?>
  </table>
  <table>
    <caption>Данные из таблицы abilities</caption>
    <tr> 
      <th>&nbsp;</th>
      <th>Идентификатор отправителя</th>
      <th>Суперсила</th>
    </tr>
    <?php
    while ($form = mysqli_fetch_assoc($result2)) {
      echo "
        <tr>
          <td>"; echo $form['abilities_id']; echo "</td>
          <td>"; echo $form['application_id']; echo "</td>
          <td>"; $form['superpower_id'] == 1 ? print "бессмертие" : ($form['superpower_id'] == 2 ? print "прохождение сквозь стены" : print "левитация") ; echo "</td>
        </tr>
      ";
    }
    ?>
  </table>
  <form action="" method="POST">
     <input name="myActionName" type="submit" value="Очистить данные" />
  </form>
</body>
</html>
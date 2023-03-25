<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
  <title>Form</title>
</head>
<body>
  <form action="" method="POST">
    <div class="form-head">
        <h1>Форма</h1>
    </div>
    <div class="form-content">
      <div class="form-item">
        <div class="group1">
          <input class="line" name="name">
          <label class="labelText" for="name">Имя</label>
        </div>
        <div class="group2">
          <input class="line" name="email">
          <label class="labelText" for="name">Email</label>
        </div>
      </div>
      <div class="form-item">
        <div class="date">
          <span>Год рождения:</span>
          <select name="year">
            <?php 
              for ($i = 2022; $i >= 1922; $i--) {
                printf('<option value="%d">%d год</option>', $i, $i);
              }
            ?>
          </select>
        </div>
      </div>
      <div class="form-item">
        <p>Пол:</p>
        <ul>
          <li>
            <input type="radio" id="radioFemale" name="gender" value="female" checked>
            <label for="radioFemale">Женщина</label>
          </li>
          <li>
            <input type="radio" id="radioMale" name="gender" value="male">
            <label for="radioMaale">Мужчина</label>
          </li>
        </ul>
      </div>
      <div class="form-item">
        <p>Правша или левша:</p>
        <ul>
          <li>
            <input type="radio" id="radioRight" name="hand" value="right" checked>
            <label for="radioRight">Правша</label>
          </li>
          <li>
            <input type="radio" id="radioLeft" name="hand" value="left">
            <label for="radioLeft">Левша</label>
          </li>
        </ul>
      </div>
      <div class="form-item">
        <p>Выберите сверхспособности:</p>
        <ul>
          <li>
            <input type="checkbox" id="god" name="abilities[]" value=1>
            <label for="god">Бессмертие</label>
          </li>
          <li>
            <input type="checkbox" id="noclip" name="abilities[]" value=2>
            <label for="noclip">Прохождение сквозь стены</label>
          </li>
          <li>
            <input type="checkbox" id="levitation" name="abilities[]" value=3>
            <label for="levitation">Левитация</label>
          </li>
        </ul> 
      </div>
      <div class="form-item">
        <p class="big-text">Расскажите о себе:</p>
        <p class="small-text">(макс. 128 символов, кириллица)</p>
        <textarea name="biography" cols=24 rows=4 maxlength=128 spellcheck="false"></textarea>
      </div>
    </div>  
    <div class="send">
      <div class="contract">
        <input type="checkbox" id="checkboxContract" name="checkboxContract">
        <label for="checkboxContract">С контрактом ознакомлен</label>
      </div>
      <input class="btn" type="submit" name="submit" value="Отправить" />
    </div>
  </form>
  <div class="href">
    <a href="BD/"><img src="https://cdn-icons-png.flaticon.com/512/1602/1602309.png" alt="db" width="20px" height="20px"></a>
  </div>
</body> 
</html>
<?php

header('Content-Type: text/html; charset=UTF-8');

$user = 'u52856';
$pass = '4305513';
$db = new PDO('mysql:host=localhost;dbname=u52856', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages['gucci'] = '<div class="good">Спасибо, результаты сохранены</div>';
    if (!empty($_COOKIE['password'])) {
      $messages['login'] = sprintf('<div class="login">Логин: <strong>%s</strong><br>
        Пароль: <strong>%s</strong><br>Войдите в аккаунт с этими данными,<br>чтобы изменить введёные значения формы</div>',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['password']));
    }
    setcookie('login', '', 100000);
    setcookie('password', '', 100000);
  }

  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['name_value']));
  $values['email'] = empty($_COOKIE['email_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['email_value']));
  $values['year'] = empty($_COOKIE['year_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['year_value']));
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['gender_value']));
  $values['hand'] = empty($_COOKIE['hand_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['hand_value']));
  $values['abilities'] = empty($_COOKIE['abilities_value']) ? [] : array_map('strip_tags', unserialize($_COOKIE['abilities_value']));
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['biography_value']));
  $values['checkboxContract'] = empty($_COOKIE['checkboxContract_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['checkboxContract_value']));
  
  if (count(array_filter($errors)) === 0 && !empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
      $_SESSION['token'] = bin2hex(random_bytes(32));
      $login = $_SESSION['login'];
      try {
          $stmt = $db->prepare("SELECT application_id FROM users WHERE login = ?");
          $stmt->execute([$login]);
          $app_id = $stmt->fetchColumn();
          
          $stmt = $db->prepare("SELECT name, email, year, gender, hand, biography FROM application WHERE application_id = ?");
          $stmt->execute([$app_id]);
          $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          $stmt = $db->prepare("SELECT superpower_id FROM abilities WHERE application_id = ?");
          $stmt->execute([$app_id]);
          $abilities = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
          
          if (!empty($dates['name'])) {
              $values['name'] = htmlspecialchars(strip_tags($dates[0]['name']));
          }
          if (!empty($dates['email'])) {
              $values['email'] = htmlspecialchars(strip_tags($dates[0]['email']));
          }
          if (!empty($dates['year'])) {
              $values['year'] = htmlspecialchars(strip_tags($dates[0]['year']));
          }
          if (!empty($dates['gender'])) {
              $values['gender'] = htmlspecialchars(strip_tags($dates[0]['gender']));
          }
          if (!empty($dates['hand'])) {
              $values['hand'] = htmlspecialchars(strip_tags($dates[0]['hand']));
          }
          if (!empty($abilities)) {
              $values['abilities'] =  array_map('strip_tags', $abilities);
          }
          if (!empty($dates[0]['biography'])) {
              $values['biography'] = htmlspecialchars(strip_tags($dates[0]['biography']));
          }
      } catch (PDOException $e) {
          print('Error : ' . $e->getMessage());
          exit();
      }
      printf('<div id="header"><p>Вход с логином %s; uid: %d</p><a href=logout.php>Выйти</a></div>', $_SESSION['login'], $_SESSION['uid']);
  }
  include('form.php');
} else {
    $errors = FALSE;
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $gender = $_POST['gender'];
    $hand = $_POST['hand'];
    if(isset($_POST["abilities"])) {
        $abilities = $_POST["abilities"];
        $filtred_abilities = array_filter($abilities,
            function($value) {
                return($value == 1 || $value == 2 || $value == 3);
            }
            );
    }
    $biography = $_POST['biography'];
    $checkboxContract = isset($_POST['checkboxContract']);
    
    if (empty($name)) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('name_value', $name, time() + 30 * 24 * 60 * 60);
    }
    
    if (empty($email)) {
        setcookie('email_error1', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setcookie('email_error2', '1', time() + 24 * 60 * 60);
        setcookie('email_value', $email, time() + 30 * 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('email_value', $email, time() + 30 * 24 * 60 * 60);
    }
    
    if (!is_numeric($year)) {
        setcookie('year_error1', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if ((2023 - $year) < 14) {
        setcookie('year_error2', '1', time() + 24 * 60 * 60);
        setcookie('year_value', $year, time() + 30 * 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('year_value', $year, time() + 30 * 24 * 60 * 60);
    }
    
    if (empty($gender)) {
        setcookie('gender_error1', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if ($gender != 'male' && $gender != 'female') {
        setcookie('gender_error2', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('gender_value', $gender, time() + 30 * 24 * 60 * 60);
    }
    
    if (empty($hand)) {
        setcookie('hand_error1', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if ($hand != 'right' && $hand != 'left') {
        setcookie('hand_error2', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('hand_value', $hand, time() + 30 * 24 * 60 * 60);
    }
    
    if (empty($abilities)) {
        setcookie('abilities_error1', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if (count($filtred_abilities) != count($abilities)) {
        setcookie('abilities_error2', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('abilities_value', serialize($abilities), time() + 30 * 24 * 60 * 60);
    }
    
    if (empty($biography)) {
        setcookie('biography_error1', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if (!preg_match('/^[\p{Cyrillic}\d\s,.!?-]+$/u', $biography)) {
        setcookie('biography_error2', '1', time() + 24 * 60 * 60);
        setcookie('biography_value', $biography, time() + 30 * 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('biography_value', $biography, time() + 30 * 24 * 60 * 60);
    }
    
    if ($checkboxContract == '') {
        setcookie('checkboxContract_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('checkboxContract_value', $checkboxContract, time() + 30 * 24 * 60 * 60);
    }
    
    if ($errors) {
        header('Location: index.php');
        exit();
    } else {
        setcookie('name_error', '', 100000);
        setcookie('email_error1', '', 100000);
        setcookie('email_error2', '', 100000);
        setcookie('year_error1', '', 100000);
        setcookie('year_error2', '', 100000);
        setcookie('gender_error1', '', 100000);
        setcookie('gender_error2', '', 100000);
        setcookie('hand_error1', '', 100000);
        setcookie('hand_error2', '', 100000);
        setcookie('abilities_error1', '', 100000);
        setcookie('abilities_error2', '', 100000);
        setcookie('biography_error1', '', 100000);
        setcookie('biography_error2', '', 100000);
        setcookie('checkboxContract_error', '', 100000);
    }
    
    if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
        if (!empty($_POST['token']) && hash_equals($_POST['token'], $_SESSION['token'])) {
            $login = $_SESSION['login'];
            try {
                $stmt = $db->prepare("SELECT application_id FROM users WHERE login = ?");
                $stmt->execute([$login]);
                $app_id = $stmt->fetchColumn();
                
                $stmt = $db->prepare("UPDATE application SET name = ?, email = ?, year = ?, gender = ?, hand = ?, biography = ?
          WHERE application_id = ?");
                $stmt->execute([$name, $email, $year, $gender, $hand, $biography, $app_id]);
                
                $stmt = $db->prepare("SELECT superpower_id FROM abilities WHERE application_id = ?");
                $stmt->execute([$app_id]);
                $abil = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
                
                if (array_diff($abil, $abilities)) {
                    $stmt = $db->prepare("DELETE FROM abilities WHERE application_id = ?");
                    $stmt->execute([$app_id]);
                    
                    $stmt = $db->prepare("INSERT INTO abilities (application_id, superpower_id) VALUES (?, ?)");
                    foreach ($abilities as $superpower_id) {
                        $stmt->execute([$app_id, $superpower_id]);
                    }
                }
                
            } catch (PDOException $e) {
                print('Error : ' . $e->getMessage());
                exit();
            }
        } else {
            die('Ошибка CSRF: недопустимый токен');
        }
    }
    else {
        $login = 'user' . rand(1, 1000);
        $password = rand(1000, 9999);
        setcookie('login', $login);
        setcookie('password', $password);
        try {
            $stmt = $db->prepare("INSERT INTO application (name, email, year, gender, hand, biography) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $year, $gender, $hand, $biography]);
            $application_id = $db->lastInsertId();
            $stmt = $db->prepare("INSERT INTO abilities (application_id, superpower_id) VALUES (?, ?)");
            foreach ($abilities as $superpower_id) {
                $stmt->execute([$application_id, $superpower_id]);
            }
            $stmt = $db->prepare("INSERT INTO users (application_id, login, password) VALUES (?, ?, ?)");
            $stmt->execute([$application_id, $login, md5($password)]);
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
    }
    
    setcookie('save', '1');
    header('Location: ./');
}
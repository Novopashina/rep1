<?php 

    header('Content-Type: text/html; charset=UTF-8');

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        include('truncate.php');
    exit();
    }

    $host = "localhost";
    $user = "u52856";
    $pass = "4305513";
    $name = "u52856";

    $induction = mysqli_connect($host, $user, $pass, $name);

    $result1 = mysqli_query($induction, "SELECT * FROM `application`");
    $result2 = mysqli_query($induction, "SELECT * FROM `abilities`");

    if (isset($_POST['myActionName'])) {
        $query1 = "TRUNCATE TABLE application";
        $query2 = "TRUNCATE TABLE abilities";
        if ($induction == false) {
            print "Ошибка подключения";
        }
        if (mysqli_multi_query($induction, $query1) && mysqli_multi_query($induction, $query2)) {
            print "record deleted Successfully";
        } else {
            print "Error:" . mysqli_error($induction);
        }
    }

    header('Location: ?deleted=1');
?>
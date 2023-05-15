<?php

$stmt = $db->prepare("SELECT count(application_id) from abilities where superpower_id = 1;");
$stmt->execute();
$first = $stmt->fetchColumn();
$stmt = $db->prepare("SELECT count(application_id) from abilities where superpower_id = 2;");
$stmt->execute();
$second = $stmt->fetchColumn();
$stmt = $db->prepare("SELECT count(application_id) from abilities where superpower_id = 3;");
$stmt->execute();
$third = $stmt->fetchColumn();
echo "
    <table>
        <tr> 
            <th>Суперсила</th>
            <th>Количество</th>
        </tr>
        <tr>
            <td>Бессмертие</td>
            <td>"; echo (empty($first) ? '0' : $first); echo "</td>
        </tr>
        <tr>
            <td>Прохождение сквозь стены</td>
            <td>"; echo (empty($second) ? '0' : $second); echo "</td>
        </tr>
        <tr>
            <td>Левитация</td>
            <td>"; echo (empty($third) ? '0' : $third); echo "</td>
        </tr>
    </table>
";
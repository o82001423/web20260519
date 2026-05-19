<?php
 $dsn="mysql:host=localhost;charset=utf8;dbname=school";
 $pdo=new PDO($dsn,'root','');

 echo "<pre>";
    print_r($_POST);
    echo "</pre>";

$sql="INSERT INTO `members`(`account`,`password`,`email`,`tel`,`birthday`)
                VALUES('{$_POST['account']}',
                        '{$_POST['password']}',
                        '{$_POST['email']}',
                        '{$_POST['tel']}',
                        '{$_POST['birthday']}'
                )";
$pdo->exec($sql);
header("Location:login.php");
exit;
?>
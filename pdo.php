<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>01-pdo</title>
</head>
<style>

</style>
<body>
    <h1>pdo連線</h1>
    <?php 
    $dsn="mysql:host=localhost;charset=utf8;dbname=school01";
    $pdo=new PDO($dsn,'root','');
    $sql="SELECT * FROM `dept`";
    $depts=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<pre>";
    print_r($depts);
    echo "</pre>";

    echo "<hr>";
   
    $sql_insert="INSERT INTO `dept`(`code`,`name`) VALUES('601','中餐科')";
    $pdo->exec($sql_insert);
    echo $sql_insert;
    echo "<hr>";
    $depts=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
   
    echo "<pre>";
    print_r($depts);
    echo "</pre>";
    echo "<hr>";

    echo"<H2>更新資料</H2>";
    $sql_update="UPDATE `dept`set `code`='602',`name`='西餐科'where `id`='8'";
    $pdo->exec($sql_update);
    echo $sql_update;
    echo "<hr>";
    $depts=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($depts);
    echo "</pre>";
    echo "<hr>";

    echo"<H2>刪除資料</H2>";
    $sql_delete="DELETE FROM `dept`WHERE `id`='9'";
    $pdo->exec($sql_delete);
    echo $sql_delete;
    echo "<hr>";
    $depts=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($depts);
    echo "</pre>";
    echo "<hr>";
     ?>
</body>
</html>
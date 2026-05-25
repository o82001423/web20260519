<h2>科別</h2>
<style>
#subjects-table {
    width: 30%;
    border-collapse: collapse;
}
#subjects-table th, #subjects-table td {
    border: 1px solid #ddd;
    padding: 8px 16px;
    text-align:center;
}
#subjects-table td:nth-child(1) {
    text-align-last: justify;
    width:200px;
}
</style>
<?php
    include_once "db_conn.php";

    $sql= "SELECT `dept`.`name`as '科別',
        `dept`.`id`as `dept_id`,
    count(`students`.`id`)as '人數'
    from `students`
    RIGHT JOIN `dept` on `dept`.`id`=`students`.`dept`
     GROUP BY `dept`.`id`;";
     $subjects=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
     echo "<table id='subjects-table'>";
     echo "<tr><th>科別</th><th>人數</th></tr>";
    foreach($subjects as $sub){
        echo "<tr><td>";
        echo "<a href='?inc=subject_students&dept={$sub['dept_id']}'>";
        echo $sub['科別'];
        echo "</a>";
        echo"</td><td>";
        echo $sub['人數'];
        echo"</td></tr>";
        }
    echo "</table>";
?>



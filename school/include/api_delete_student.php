<?php include "./school/include/db_conn.php";
$num=$_POST['school_num'];

$class_code=$pdo->query("SELECT `class_code` FROM `class_student` WHERE `school_num`='{$num}'")->fetchColumn();

$sql_students="DELETE FROM `students` WHERE `school_num`='{$num}'";
$sql_class_student="DELETE FROM `class_student` WHERE `school_num`='{$num}'";
$sql_socres="DELETE FROM `student_scores` WHERE `school_num`='{$num}'";

$pdo->exec($sql_students);
$pdo->exec($sql_class_student); 
$pdo->exec($sql_socres);

header("location:../admin.php?inc=class_students&code={$class_code}");



?>
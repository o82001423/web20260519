<?php
include_once "db_conn.php";

/* echo "<pre>";
print_r($_POST['name']);
echo "</pre>"; */

$sql_student="INSERT INTO `students`(`school_num`, 
                         `name`, 
                         `birthday`, 
                         `uni_id`, 
                         `addr`, 
                         `parents`, 
                         `tel`, 
                         `dept`, 
                         `graduate_at`, 
                         `status_code`) 
                VALUES ('{$_POST['school_num']}',
                        '{$_POST['name']}',
                        '{$_POST['birthday']}',
                        '{$_POST['uni_id']}',
                        '{$_POST['addr']}',
                        '{$_POST['parents']}',
                        '{$_POST['tel']}',
                        '{$_POST['dept']}',
                        '{$_POST['graduate_at']}',
                        '{$_POST['status_code']}')";
$sql_class="INSERT INTO `class_student`( 
                            `school_num`, 
                            `class_code`, 
                            `seat_num`, 
                            `year`) 
                    VALUES ('{$_POST['school_num']}',
                            '{$_POST['class_code']}',
                            '{$_POST['seat_num']}',
                            '2000')";

$pdo->exec($sql_student);
$pdo->exec($sql_class);

header("location:../admin.php?inc=class_students&code={$_POST['class_code']}");
?>
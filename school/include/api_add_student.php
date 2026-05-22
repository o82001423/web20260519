<?php
require_once __DIR__ . '/db_conn.php';

function post($key, $default = '') {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

$required = [
        'school_num','name','birthday','uni_id','addr','parents','tel','dept','graduate_at','status_code','class_code','seat_num'
];
$missing = [];
foreach ($required as $k) {
        if (!isset($_POST[$k]) || $_POST[$k] === '') {
                $missing[] = $k;
        }
}
if (!empty($missing)) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'error' => 'missing_fields', 'fields' => $missing]);
        exit;
}

if (!isset($pdo) || !$pdo) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'error' => 'db_connection']);
        exit;
}

try {
        $pdo->beginTransaction();

        $stmtStudent = $pdo->prepare("INSERT INTO `students`(
                `school_num`,`name`,`birthday`,`uni_id`,`addr`,`parents`,`tel`,`dept`,`graduate_at`,`status_code`
        ) VALUES (
                :school_num,:name,:birthday,:uni_id,:addr,:parents,:tel,:dept,:graduate_at,:status_code
        )");

        $paramsStudent = [
                ':school_num' => post('school_num'),
                ':name' => post('name'),
                ':birthday' => post('birthday'),
                ':uni_id' => post('uni_id'),
                ':addr' => post('addr'),
                ':parents' => post('parents'),
                ':tel' => post('tel'),
                ':dept' => post('dept'),
                ':graduate_at' => post('graduate_at'),
                ':status_code' => post('status_code')
        ];
        $stmtStudent->execute($paramsStudent);

        $stmtClass = $pdo->prepare("INSERT INTO `class_student`(`school_num`,`class_code`,`seat_num`,`year`) VALUES (:school_num,:class_code,:seat_num,:year)");
        $paramsClass = [
                ':school_num' => post('school_num'),
                ':class_code' => post('class_code'),
                ':seat_num' => post('seat_num'),
                ':year' => date('Y')
        ];
        $stmtClass->execute($paramsClass);

        $pdo->commit();

        $redirect = '../admin.php?inc=class_students&code=' . urlencode(post('class_code'));
        header('Location: ' . $redirect);
        exit;

} catch (Exception $e) {
        if ($pdo->inTransaction()) {
                $pdo->rollBack();
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'error' => 'db_error', 'message' => $e->getMessage()]);
        exit;
}
?>
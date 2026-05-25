<?php
// 🌟 修正 1：因為此 API 在 include/ 資料夾內，必須退回上一層 (../) 才能抓到正確的連線檔！
include_once "db_conn.php";

// 🌟 修正 2：在 $key 前面加上 string，告訴編輯器這是字串，消滅 P1132 警告！
function post(string $key, string $default = ''): string {
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

// 🌟 修正 3：多一層防禦，確保安全連上總部傳來的 $pdo
if (!isset($pdo) || !$pdo) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'error' => 'db_connection', 'message' => 'API找不到 $pdo 物件，請檢查 include 路徑。']);
    exit;
}

try {
    $pdo->beginTransaction();

    // 寫入學生基本資料
    $stmtStudent = $pdo->prepare("INSERT INTO `students`(
            `school_num`,`name`,`birthday`,`uni_id`,`addr`,`parents`,`tel`,`dept`,`graduate_at`,`status_code`
    ) VALUES (
            :school_num,:name,:birthday,:uni_id,:addr,:parents,:tel,:dept,:graduate_at,:status_code
    )");

    $paramsStudent = [
        ':school_num'  => post('school_num'),
        ':name'        => post('name'),
        ':birthday'    => post('birthday'),
        ':uni_id'      => post('uni_id'),
        ':addr'        => post('addr'),
        ':parents'     => post('parents'),
        ':tel'         => post('tel'),
        ':dept'        => post('dept'),
        ':graduate_at' => post('graduate_at'),
        ':status_code' => post('status_code')
    ];
    $stmtStudent->execute($paramsStudent);

    // 寫入班級分配資料
    $stmtClass = $pdo->prepare("INSERT INTO `class_student`(`school_num`,`class_code`,`seat_num`,`year`) VALUES (:school_num,:class_code,:seat_num,:year)");
    $paramsClass = [
        ':school_num' => post('school_num'),
        ':class_code' => post('class_code'),
        ':seat_num'   => post('seat_num'),
        ':year'       => date('Y')
    ];
    $stmtClass->execute($paramsClass);

    $pdo->commit();

    // 🎯 表單處理完畢，順利回彈到後台指定班級列表！
    $redirect = '../admin.php?inc=class_students&code=' . urlencode(post('class_code'));
    header('Location: ' . $redirect);
    exit;

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'error' => 'db_error', 'message' => $e->getMessage()]);
    exit;
}
?>
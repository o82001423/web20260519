<?php
// 1. 絕對路徑引入資料庫連線
include_once "db_conn.php";

// 安全檢查
if (!isset($pdo)) {
    die("資料庫連線失敗！");
}

// 2. 確保有收到要刪除的學號
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['school_num'])) {
    $school_num = $_POST['school_num'];

    try {
        // 3. 啟動交易機制，要刪就連同班級關聯一起刪乾淨
        $pdo->beginTransaction();

        // 刪除班級關聯表資料 (class_student)
        $stmtClass = $pdo->prepare("DELETE FROM `class_student` WHERE `school_num` = ?");
        $stmtClass->execute([$school_num]);

        // 刪除學生基本資料表資料 (students)
        $stmtStudent = $pdo->prepare("DELETE FROM `students` WHERE `school_num` = ?");
        $stmtStudent->execute([$school_num]);

        // 提交變更
        $pdo->commit();

        // 4. 🚀 刪除成功，直接跳轉回後台管理首頁或班級名冊
        header("Location: ../admin.php?inc=class_students");
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        die("刪除失敗，錯誤訊息: " . $e->getMessage());
    }
} else {
    die("非法存取或缺少學號參數！");
}
?>
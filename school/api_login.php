<?php
// 啟動 Session 用於記錄登入狀態
session_start();

$dsn = "mysql:host=localhost;charset=utf8;dbname=school";
$pdo = new PDO($dsn, 'root', '');

try {
    // 1. 檢查是否有收到 POST 資料
    if (isset($_POST['account']) && isset($_POST['password'])) {
        $account = $_POST['account'];
        $password = $_POST['password'];

        // 2. 使用安全預備語法查詢帳號是否存在
        $sql = "SELECT * FROM `members` WHERE `account` = :account";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['account' => $account]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 3. 檢查帳號與密碼是否吻合
        if ($user && $user['password'] == $password) {
            
            // 🎯 登入成功：將狀態存入 Session
            // 💡 修正：把 Key 改為 'login'，完美對接 admin.php 的安全鎖
            $_SESSION['login'] = $user['account'];
            
            // 如果你的 members 資料表有 name 欄位，就存進去；沒有的話就用預設的
            $_SESSION['user_name'] = $user['name'] ?? $user['account'];

            // 💡 修正：成功後直接跳轉進去 admin.php
            // ⚠️ 註：如果你的 api 檔案在 include/ 資料夾內，路徑要寫 '../admin.php' 喔！
            echo "<script>
                    alert('登入成功！歡迎回來，" . $user['account'] . "！');
                    window.location.href = 'admin.php'; 
                  </script>";
            exit;
        } else {
            // 登入失敗：帳號或密碼錯誤
            echo "<script>
                    alert('登入失敗：帳號或密碼輸入錯誤！');
                    history.back();
                  </script>";
            exit;
        }
    } else {
        // 不是正常外來 POST 請求，退回登入頁
        header("Location: login.php");
        exit;
    }

} catch (PDOException $e) {
    echo "系統錯誤：" . $e->getMessage();
}
?>
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
        // 💡 註：因為你先前註冊直接存了明文，這裡先用明文比對 ($user['password'] == $password)
        // 💡 未來如果你註冊改用 password_hash()，這裡就要換成 password_verify($password, $user['password'])
        if ($user && $user['password'] == $password) {
            
            // 登入成功：將狀態存入 Session
            $_SESSION['user'] = $user['account'];

            echo "<script>
                    alert('登入成功！歡迎回來，" . $user['account'] . "！');
                    window.location.href = 'login.php'; // 這裡可以改成登入成功後的後台首頁
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
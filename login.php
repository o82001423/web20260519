<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入</title>
    <style>
        /* 整體底色淺綠色 */
        body {
            background-color: #E8F5E9; 
            font-family: "Microsoft JhengHei", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        

        /* 登入表單外框 */
        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 350px;
            box-sizing: border-box;
        }

        /* 主標題：深橘色 */
        .login-container h2 {
            color: #E65100; 
            text-align: center;
            margin-bottom: 25px;
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        /* 標籤文字：亮橘色 */
        label {
            display: block;
            margin-bottom: 8px;
            color: #F57C00; 
            font-weight: bold;
        }

        /* 輸入欄位：圓角與淺綠邊框 */
        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #A5D6A7; 
            border-radius: 8px; 
            box-sizing: border-box;
            outline: none;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #F57C00; /* 聚焦時變成橘色邊框 */
        }

        /* 登入按鈕：暖黃色 */
        button {
            width: 100%;
            padding: 12px;
            background-color: #FFB300; 
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px; 
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #F57C00; /* 懸停時變橘色 */
        }

        /* 下方切換連結 */
        .switch-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .switch-link a {
            color: #E65100;
            text-decoration: none;
            font-weight: bold;
        }

        .switch-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>會員登入</h2>
    
    <!-- 表單送往 api_login.php -->
    <form id="loginForm" action="api_login.php" method="POST">
        <div class="form-group">
            <label for="account">帳號 (Account)</label>
            <input type="text" id="account" name="account" placeholder="請輸入帳號" required>
        </div>
        
        <div class="form-group">
            <label for="password">密碼 (Password)</label>
            <input type="password" id="password" name="password" placeholder="請輸入密碼" required>
        </div>
        
        <button type="submit">登入系統</button>
    </form>

    <div class="switch-link">
        還沒有帳號嗎？ <a href="register.php">前往註冊</a>
    </div>
</div>

</body>
</html>
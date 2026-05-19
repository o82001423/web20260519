<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員註冊</title>
</head>
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
        /* 表單外框 */
        .register-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        /* 文字以黃色/橘色搭配 */
        h2 {
            color: #E65100; /* 深橘色 */
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #F57C00; /* 亮橘色 */
            font-weight: bold;
        }
        /* 輸入欄位圓角與簡約風 */
        input {
            width: 100%;
            padding: 10px;
            border: 2px solid #A5D6A7; /* 淺綠邊框 */
            border-radius: 8px; /* 圓角 */
            box-sizing: border-box;
            outline: none;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input:focus {
            border-color: #F57C00; /* 聚焦時變成橘色邊框 */
        }
        /* 送出按鈕 */
        button {
            width: 100%;
            padding: 12px;
            background-color: #FFB300; /* 暖黃色 */
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px; /* 圓角 */
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #F57C00; /* 懸停時變橘色 */
        }
    </style>

<body> 


    <div>
    <h2>簡易註冊系統</h2>
    <ul>
        <li>建立一個資料表來存放使用者的帳號、<br>密碼及個人資料</li>
        <li>建立一個網頁表單可以讓使用者輸入<br>自己的帳號、密碼及個人資料</li>
        <li>送出表單後可以將使用<br>者的資料存入資料表</li>
    </ul>
    <h3>資料表設幾</h3>
    <ul>
        <li>id</li>
        <li>account</li>
        <li>password</li>
        <li>tel</li>
        <li>birthday</li>
        <li>email</li>
    </ul>
    <h3>註冊表單設計</h3>
    <ul>
        <li>清晰簡約風</li>
        <li>整體底色淺綠色</li>
        <li>文字以黃色或橘色做搭配</li>
        <li>表單輸入欄位都要有圓角</li>
    </ul>
    </div>
    <div class="register-container">
    <h2>使用者註冊</h2>
    <!-- 表單送往 save_register.php -->
    <form id="registerFrom" action="api_register.php" method="POST">
        <div class="form-group">
            <label for="account">帳號 (Account)</label>
            <input type="text" id="account" name="account"placeholder="請輸入帳號">
        </div>
        <div class="form-group">
            <label for="password">密碼 (Password)</label>
            <input type="password" id="password" name="password" placeholder="請輸入密碼">
        </div>
        <div class="form-group">
            <label for="tel">電話 (Tel)</label>
            <input type="tel" id="tel" name="tel" placeholder="請輸入電話">
        </div>
        <div class="form-group">
            <label for="birthday">生日 (Birthday)</label>
            <input type="date" id="birthday" name="birthday">
        </div>
        <div class="form-group">
            <label for="email">電子郵件 (Email)</label>
            <input type="email" id="email" name="email" placeholder="請輸入Email">
        </div>
        <button type="submit">註冊帳號</button>
    </form>
</div>

    <?php 
    
    ?>

</body>
</html>
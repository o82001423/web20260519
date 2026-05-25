<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>令和新入生・替身覺醒註冊</title>
    
    <link rel="stylesheet" href="header.css">
    
    <style>
        html { font-size: 19.2px; }
        body {
            background-color: #E8F5E9;
            font-family: "Microsoft JhengHei", sans-serif;
            margin: 0;
            padding: 0;
        }
        .page-content {
            margin: 180px auto 40px auto; 
            display: flex;
            justify-content: center;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 380px; /* 稍微加寬一點點，放更多註冊欄位 */
            box-sizing: border-box;
        }
        .form-container h2 {
            color: #E65100;
            text-align: center;
            margin-bottom: 20px;
            margin-top: 0;
        }
        .form-group { margin-bottom: 15px; }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            color: #F57C00;
            font-weight: bold;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            border: 2px solid #A5D6A7;
            border-radius: 8px;
            box-sizing: border-box;
            outline: none;
            font-size: 14px;
        }
        .form-container input:focus { border-color: #F57C00; }
        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #FFB300;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }
        .form-container button:hover { background-color: #F57C00; }
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
    </style>
</head>
<body>

    <header class="jp-university-header">
        <div class="header-top-bar">
            <div class="jp-lang-selector">
                <span>JAPANESE</span> <span>ENGLISH</span> <span style="color:#ff007f;">DIO語 (WRYYY)</span>
            </div>
            <div class="header-sub-nav">
                <a href="#">受験生の方</a>
                <a href="#">在學生の方</a>
                <a href="#">卒業生の方</a>
                <a href="#">研究・產學官連携</a>
            </div>
        </div>

        <div class="header-main-bar">
            <a href="#" class="university-brand">
                <div class="univ-logo-emblem">★</div>
                <div class="univ-title-group">
                    <h1 class="univ-name-kanji">公立杜王町大学</h1>
                    <span class="univ-name-english">Moriah University of Outstanding</span>
                </div>
            </a>
            
            <div class="university-nav-actions">
                <a href="login.php" class="jp-portal-btn btn-jp-login">學力試驗・密碼登入</a>
                <a href="register.php" class="jp-portal-btn btn-jp-register">令和新入生・替身覺醒願書</a>
            </div>
        </div>
    </header>

    <div class="page-content">
        <div class="form-container">
            <h2>新入生帳號註冊</h2>
            
            <form action="api_register.php" method="POST">
                
                <div class="form-group">
                    <label for="account">設定帳號 (Account)</label>
                    <input type="text" id="account" name="account" placeholder="請輸入欲註冊的帳號" required>
                </div>
                
                <div class="form-group">
                    <label for="password">設定密碼 (Password)</label>
                    <input type="password" id="password" name="password" placeholder="請輸入密碼" autocomplete="new-password" required>
                </div>

                <div class="form-group">
                    <label for="re_password">確認密碼 (Confirm Password)</label>
                    <input type="password" id="re_password" name="re_password" placeholder="請再次輸入密碼" autocomplete="new-password" required>
                </div>

                <button type="submit">提交覺醒願書（註冊）</button>
            </form>
            
            <div class="switch-link">
                已經有杜王町大學帳號？ <a href="login.php">直接前往登入</a>
            </div>
        </div>
    </div>

</body>
</html>
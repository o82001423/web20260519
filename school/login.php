<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入</title>
    <link rel="stylesheet" href="header.css">
    <style>
        /* 1. 設定基礎字體大小，避免頁首 rem 計算崩壞 */
        html {
            font-size: 19.2px; 
            transition: filter 0.3s ease, font-size 0.2s ease;
        }

        /* 時停反轉特效 */
        .za-warudo-active {
            filter: invert(1) hue-rotate(180deg) contrast(1.5);
            animation: shake 0.1s infinite;
        }

        @keyframes shake {
            0% { transform: translate(1px, 1px) rotate(0deg); }
            10% { transform: translate(-1px, -2px) rotate(-1deg); }
            20% { transform: translate(-3px, 0px) rotate(1deg); }
            30% { transform: translate(0px, 2px) rotate(0deg); }
            40% { transform: translate(1px, -1px) rotate(1deg); }
            50% { transform: translate(-1px, 2px) rotate(-1deg); }
            60% { transform: translate(-3px, 1px) rotate(0deg); }
            70% { transform: translate(2px, 1px) rotate(-1deg); }
            80% { transform: translate(-1px, -1px) rotate(1deg); }
            90% { transform: translate(2px, 2px) rotate(0deg); }
            100% { transform: translate(1px, -2px) rotate(-1deg); }
        }

        /* 整體底色淺綠色 */
        body {
            background-color: #E8F5E9; 
            font-family: "Microsoft JhengHei", sans-serif;
            display: flex;
            flex-direction: column; /* 👈 改為欄位佈局，讓頁首與內容分離 */
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* 👈 改用 min-height 確保伸縮彈性 */
            margin: 0;
            box-sizing: border-box;
            padding-top: 140px; /* 👈 重要：為上方固定頁首留出空間，不讓登入框被遮擋 */
        }

        /* 修正頁首按鈕縮在一團的問題 */
        .jp-portal-btn {
            white-space: nowrap !important; /* 👈 強制按鈕文字絕不折行，保持霸氣寬度 */
        }
        .university-nav-actions {
            flex-shrink: 0; /* 👈 防止按鈕區域被左邊校名擠壓 */
        }

        /* 登入表單外框 */
        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 350px;
            box-sizing: border-box;
            z-index: 10; /* 確保在背景層上方 */
            font-size: 16px; /* 鎖定登入框內的文字大小，不受頁首歐拉放大影響 */
        }

        /* 主標題：深橘色 */
        .login-container h2 {
            color: #E65100; 
            text-align: center;
            margin-bottom: 25px;
            margin-top: 0;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        /* 標籤文字：亮橘色 */
        .login-container label {
            display: block;
            margin-bottom: 8px;
            color: #F57C00; 
            font-weight: bold;
        }

        /* 輸入欄位：圓角與淺綠邊框 */
        .login-container input {
            width: 100%;
            padding: 12px;
            border: 2px solid #A5D6A7; 
            border-radius: 8px; 
            box-sizing: border-box;
            outline: none;
            font-size: 14px;
            transition: border-color 0.3s;
            background-color: #fff;
            color: #333;
        }

        .login-container input:focus {
            border-color: #F57C00; /* 聚焦時變成橘色邊框 */
        }

        /* 登入按鈕：暖黃色 (排除頁首的按鈕設定) */
        .login-container button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #FFB300; 
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px; 
            cursor: pointer;
            transition: background 0.3s, transform 0.1s;
            margin-top: 10px;
        }

        .login-container button[type="submit"]:hover {
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
<header class="jp-university-header">
        
        <!-- 上層：日式大學內部導覽（在校生、留學生、學部案內） -->
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

        <!-- 下層：校徽、厚重漢字校名、狂暴放大登入註冊鈕 -->
        <div class="header-main-bar">
            <a href="#" class="university-brand">
                <!-- 星形標誌校徽 -->
                <div class="univ-logo-emblem">★</div>
                <div class="univ-title-group">
                    <h1 class="univ-name-kanji">公立杜王町大学</h1>
                    <span class="univ-name-english">Moriah University of Outstanding</span>
                </div>
            </a>
            
            <div class="university-nav-actions">
                <!-- JOJO 系統按鈕 -->
                <button class="jojo-tool-btn" onclick="changeFontSize(1)">歐拉！字體變大</button>
                <button class="jojo-tool-btn" onclick="zaWarudo()">⏱️ 時間停止</button>
                
                <!-- 核心日式大專院校入口（滑鼠移過去暴脹 1.2 倍！） -->
                <a href="login.php" class="jp-portal-btn btn-jp-login">學力試驗・密碼登入</a>
                <a href="register.php" class="jp-portal-btn btn-jp-register">令和新入生・替身覺醒願書</a>
            </div>
        </div>
    </header>

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
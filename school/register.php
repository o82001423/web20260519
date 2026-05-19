<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <!-- 確保手機看網頁時不會縮小，字體大小正常 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入</title>
    
    <!-- 載入你寫好的外部頁首樣式表 (header.css) -->
    <link rel="stylesheet" href="header.css">
    
    <style>
        /* 設定網頁基本字體大小的基準點 */
        html {
            font-size: 19.2px; 
        }
        
        /* 設定整個網頁背景顏色與字體 */
        body {
            background-color: #E8F5E9; /* 淺綠色背景 */
            font-family: "Microsoft JhengHei", sans-serif; /* 微軟正黑體 */
            margin: 0;   /* 清除網頁邊緣預設的空白 */
            padding: 0;  /* 清除網頁內部的預設留白 */
        }

        /* 關鍵：包裹表單的隱形大框框，用來調整表單位置 */
        .page-content {
            /* 頂部留 180px（絕對不會撞到飄在空中的頁首）/ 左右 auto（自動置中）/ 底部留 40px */
            margin: 180px auto 40px auto; 
            display: flex;           /* 啟動彈性排版工具 */
            justify-content: center; /* 讓裡面的表單水平完全居中 */
        }

        /* 登入表單的白色外框 */
        .form-container {
            background-color: #ffffff; /* 純白底色 */
            padding: 30px;             /* 內圍留白，讓裡面的字不會貼邊 */
            border-radius: 15px;       /* 四個角角變圓弧狀 */
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); /* 加上微弱的黑色陰影，看起來立體 */
            width: 350px;              /* 固定寬度 350 像素 */
            box-sizing: border-box;    /* 寬度包含內留白，防止框框被撐大 */
        }

        /* 表單標題（會員登入） */
        .form-container h2 {
            color: #E65100;      /* 深橘色字體 */
            text-align: center;  /* 文字居中 */
            margin-bottom: 20px; /* 跟下方輸入框保持 20px 距離 */
            margin-top: 0;       /* 清除頂部預設間距 */
        }

        /* 每一組輸入區域的間距 */
        .form-group {
            margin-bottom: 15px; /* 每組輸入框之間空 15px，才不會黏在一起 */
        }

        /* 輸入框上面的文字標籤（帳號、密碼） */
        .form-container label {
            display: block;      /* 讓標籤自己單獨佔領一行 */
            margin-bottom: 5px;  /* 跟下方的輸入框保持 5px 距離 */
            color: #F57C00;      /* 亮橘色字體 */
            font-weight: bold;   /* 字體加粗 */
        }

        /* 使用者填寫資料的輸入框 */
        .form-container input {
            width: 100%;         /* 寬度填滿整個白色外框 */
            padding: 10px;       /* 輸入框內部留白，字才不會太擠 */
            border: 2px solid #A5D6A7; /* 預設為淺綠色邊框 */
            border-radius: 8px;  /* 輸入框的角角變圓圓的 */
            box-sizing: border-box; /* 防止寬度被 padding 撐破 */
            outline: none;       /* 點擊時不要出現瀏覽器預設的黑框 */
            font-size: 14px;     /* 字體大小 */
        }

        /* 當使用者點擊輸入框、準備打字時的變化 (Focus 狀態) */
        .form-container input:focus {
            border-color: #F57C00; /* 邊框瞬間變成亮橘色，提示使用者現在在點這格 */
        }

        /* 送出表單的黃色大按鈕 */
        .form-container button {
            width: 100%;         /* 寬度填滿 */
            padding: 12px;       /* 讓按鈕高度變厚、好點擊 */
            background-color: #FFB300; /* 暖黃色背景 */
            border: none;        /* 不要邊框 */
            color: white;        /* 按鈕文字為白色 */
            font-size: 16px;     /* 字體放大 */
            font-weight: bold;   /* 字體加粗 */
            border-radius: 8px;  /* 按鈕角角變圓圓的 */
            cursor: pointer;     /* 滑鼠移上去時，箭頭會變成「小手」圖示 */
        }

        /* 當滑鼠移到按鈕上面時的變化 (Hover 狀態) */
        .form-container button:hover {
            background-color: #F57C00; /* 顏色稍微變深，變成亮橘色 */
        }

        /* 下方切換連結的區塊（還沒有帳號嗎？） */
        .switch-link {
            text-align: center;  /* 文字置中 */
            margin-top: 20px;    /* 跟上方按鈕保持 20px 距離 */
            font-size: 14px;     /* 字體縮小一點 */
            color: #666;         /* 灰色字體 */
        }

        /* 切換連結裡面的超連結（前往註冊） */
        .switch-link a {
            color: #E65100;      /* 深橘色字體 */
            text-decoration: none; /* 拔掉超連結預設的下底線 */
            font-weight: bold;   /* 字體加粗 */
        }
    </style>
</head>
<body>

    <!-- 🚀 頁首區塊（套用 header.css 格式） -->
    <header class="jp-university-header">
        <!-- 頁首最上方的小字條（切換語言跟小選單） -->
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

        <!-- 頁首主要內容（校名與導覽按鈕） -->
        <div class="header-main-bar">
            <!-- 左側：學校 Logo 與名稱 -->
            <a href="#" class="university-brand">
                <div class="univ-logo-emblem">★</div>
                <div class="univ-title-group">
                    <h1 class="univ-name-kanji">公立杜王町大学</h1>
                    <span class="univ-name-english">Moriah University of Outstanding</span>
                </div>
            </a>
            
            <!-- 右側：功能導覽按鈕（只有這兩個，寬度絕對夠，不會再擠爆） -->
            <div class="university-nav-actions">
                <a href="login.php" class="jp-portal-btn btn-jp-login">學力試驗・密碼登入</a>
                <a href="register.php" class="jp-portal-btn btn-jp-register">令和新入生・替身覺醒願書</a>
            </div>
        </div>
    </header>

    <!-- 主內容區：利用 page-content 把表單壓到頁首下方 -->
    <div class="page-content">
        <!-- 表單白色框框 -->
        <div class="form-container">
            <h2>會員登入</h2>
            <!-- 登入表單開始，資料會送往 api_login.php -->
            <form action="api_login.php" method="POST">
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
            <!-- 切換頁面連結 -->
            <div class="switch-link">
                還沒有帳號嗎？ <a href="register.php">前往註冊</a>
            </div>
        </div>
    </div>

</body>
</html>
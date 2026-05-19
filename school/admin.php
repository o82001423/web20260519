<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後臺管理系統</title>
</head>
 <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Microsoft YaHei', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* 頂部導航欄 */
        .navbar {
            background: linear-gradient(135deg, #2e7d32 0%, #388e3c 100%);
            padding: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            height: 70px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }

        .nav-logo span {
            font-size: 28px;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
            list-style: none;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 15px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #ffc107;
        }

        .nav-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-login, .btn-register {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login {
            background-color: #ffc107;
            color: #2e7d32;
        }

        .btn-login:hover {
            background-color: #ffb300;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
        }

        .btn-register {
            background-color: #ff9800;
            color: white;
        }

        .btn-register:hover {
            background-color: #f57c00;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3);
        }

        /* 首頁banner */
        .hero-section {
            background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);
            padding: 80px 20px;
            text-align: center;
            color: #2e7d32;
        }

        .hero-content h1 {
            font-size: 48px;
            margin-bottom: 20px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
        }

        .hero-content p {
            font-size: 20px;
            margin-bottom: 30px;
            color: #558b2f;
        }

        .hero-button {
            display: inline-block;
            padding: 15px 40px;
            background-color: #ff9800;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .hero-button:hover {
            background-color: #f57c00;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(255, 152, 0, 0.3);
        }

        /* 主要內容區域 */
        .main-content {
            width:75%;
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .section-title {
            font-size: 32px;
            color: #2e7d32;
            margin-bottom: 40px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background-color: #ff9800;
            border-radius: 2px;
        }

        /* 信息卡片 */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }
        .cards-container a {
            text-decoration:none;
        }
        .card {
            background-color: #f1f8f5;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 5px solid #ff9800;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .card h3 {
            color: #ff9800;
            font-size: 22px;
            margin-bottom: 12px;
        }

        .card p {
            color: #666;
            line-height: 1.8;
        }

        /* 新聞/公告區域 */
        .news-section {
            background-color: #f9fbe7;
            padding: 40px;
            border-radius: 12px;
            margin-bottom: 60px;
        }

        .news-item {
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .news-item:last-child {
            border-bottom: none;
        }

        .news-title {
            color: #2e7d32;
            font-weight: bold;
            flex: 1;
        }

        .news-date {
            color: #999;
            font-size: 13px;
            margin-left: 20px;
        }

        /* 頁腳 */
        .footer {
            background-color: #2e7d32;
            color: white;
            padding: 40px 20px;
            text-align: center;
            margin-top: 60px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-text {
            margin: 10px 0;
            font-size: 14px;
        }

        .footer-links {
            margin: 20px 0;
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #ffc107;
            text-decoration: none;
            font-size: 13px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* 響應式設計 */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                height: auto;
                padding: 15px 20px;
                gap: 15px;
            }

            .nav-logo {
                font-size: 20px;
            }

            .nav-links {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .nav-buttons {
                width: 100%;
                gap: 10px;
            }

            .btn-login, .btn-register {
                flex: 1;
            }

            .hero-content h1 {
                font-size: 36px;
            }

            .hero-content p {
                font-size: 16px;
            }

            .cards-container {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 24px;
            }
        }
    </style>    
<body>
    <nav class="nav-container">
        <div>
            <a href="./index.html" class="nav-logo">
             公立杜王町大学
            </a>
        <ul class="nav-links">
            <li><a href="http://">班級</a></li>
            <li><a href="http://">學生</a></li>
            <li><a href=""></a>科別</li>
        </ul>
            <div class="nav-buttons">
                <a href="./login.php" class="btn-login">登出</a>
            </div>
        </div>
    </nav>
    <main class="main-content">
        <?php 
        $inc=(isset($_GET['inc']))?$_GET['inc']:'classrooms';
       $file="./include/".$inc.".php";
       if(file_exists($file)){
        include $file;
       }else{
        include "./include/classrooms.php";
       }
        ?>
    </main>
</body>

</html>
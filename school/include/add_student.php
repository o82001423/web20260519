<?php 
include "db_conn.php"; 
// 💡 預防性檢查：確保 $pdo 變數存在，若不存在則建立（請依你實際的 db_conn.php 設定調整）
if (!isset($pdo) && isset($conn)) { $pdo = $conn; } 
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>公立杜王町大學 - 新入生替身能力願書</title>
    <style>
        /* 基礎設定與時停反轉特效 */
        html {
            font-size: 19.2px; 
            transition: filter 0.3s ease, font-size 0.2s ease;
            scroll-padding-top: 150px;
        }

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

        body {
            background: linear-gradient(135deg, #0e001a 0%, #050510 100%);
            color: #ffffff;
            font-family: "MS Mincho", "SimSun", "Microsoft JhengHei", sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* 🚀 雙層固定頁首 */
        .jp-university-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #000000;
            border-bottom: 5px solid #ff007f;
            z-index: 100;
            box-shadow: 0 8px 0px #ffd700;
        }

        .header-top-bar {
            background: #111;
            border-bottom: 1px solid #333;
            padding: 6px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.65rem;
            letter-spacing: 1px;
        }

        .jp-lang-selector span {
            color: #ffd700;
            margin-right: 15px;
            cursor: pointer;
        }

        .header-sub-nav {
            display: flex;
            gap: 20px;
        }

        .header-sub-nav a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.2s;
        }
        .header-sub-nav a:hover {
            color: #00ffcc;
            text-decoration: underline;
        }

        .header-main-bar {
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .university-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
        }

        .univ-logo-emblem {
            width: 45px;
            height: 45px;
            border: 3px solid #ffd700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ff007f;
            font-size: 1.3rem;
            font-weight: bold;
            background: #000;
            text-shadow: 1px 1px 0px #fff;
            box-shadow: 2px 2px 0px #00ffcc;
        }

        .univ-title-group {
            display: flex;
            flex-direction: column;
        }

        .univ-name-kanji {
            font-family: "Impact", "Microsoft JhengHei", sans-serif;
            font-size: 1.4rem;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 4px;
            margin: 0;
            line-height: 1.2;
            text-shadow: 2px 2px 0px #9400d3;
        }

        .univ-name-english {
            font-size: 0.55rem;
            color: #ffd700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
            font-weight: bold;
        }

        .university-nav-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .jojo-tool-btn {
            background: #222;
            color: #ffd700;
            border: 2px dashed #ffd700;
            padding: 6px 12px;
            font-size: 0.65rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }
        .jojo-tool-btn:hover {
            transform: scale(1.1) rotate(-2deg);
            border-style: solid;
            background: #ffd700;
            color: #000;
        }

        /* 背景擬聲詞 */
        .menace-text {
            position: fixed;
            font-size: 8rem;
            font-weight: 900;
            font-style: italic;
            text-shadow: 4px 4px 0px #000;
            user-select: none;
            z-index: 1;
            opacity: 0.1;
            animation: floatGOGO 3s infinite alternate ease-in-out;
        }
        .gogo-left { top: 30%; left: 20px; color: #ff007f; transform: rotate(-15deg); }
        .gogo-right { bottom: 15%; right: 20px; color: #ffd700; transform: rotate(15deg); animation-delay: 0.5s; }

        @keyframes floatGOGO {
            0% { transform: scale(1) translateY(0px); }
            100% { transform: scale(1.1) translateY(-20px); }
        }

        /* 表單外層大容器 */
        .school-wrapper {
            max-width: 850px;
            margin: 0 auto;
            padding: 180px 30px 40px 30px;
            position: relative;
            box-sizing: border-box;
        }

        /* 大標題 Banner */
        .school-gate-banner {
            border: 8px solid #ffffff;
            outline: 4px solid #ffd700;
            background: #000000;
            padding: 35px 20px;
            position: relative;
            z-index: 2;
            box-shadow: 15px 15px 0px #9400d3; 
            text-align: center;
            margin-bottom: 50px;
        }

        .kanji-title {
            font-size: 2.5rem;
            font-weight: 900;
            color: #ffd700;
            letter-spacing: 8px;
            margin: 0;
            text-shadow: 4px 4px 0px #ff007f, 8px 8px 0px #000;
        }

        /* 漫畫風表單方塊 */
        .section-box {
            background: rgba(10, 10, 25, 0.95);
            border: 4px solid #ffd700;
            padding: 40px;
            margin-bottom: 40px;
            z-index: 2;
            position: relative;
            box-shadow: 12px 12px 0px #000;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
        }

        .section-box:hover {
            border-color: #00ffcc;
            box-shadow: 18px 18px 0px #ff007f;
        }

        .section-title {
            font-size: 1.3rem;
            color: #ff007f;
            margin-top: 0;
            margin-bottom: 30px;
            border-bottom: 4px solid #ffffff;
            padding-bottom: 12px;
            letter-spacing: 3px;
            text-shadow: 2px 2px 0px #000;
        }

        /* 表單欄位群組 */
        .form-group {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 900;
            color: #ffd700;
            font-size: 0.9rem;
            letter-spacing: 1px;
            text-shadow: 1px 1px 0px #000;
            min-width: 140px;
            flex-shrink: 0;
            text-align-last: justify;
        }

        /* 輸入框通用樣式 */
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="date"],
        .form-group select {
            flex: 1;
            width: 100%;
            padding: 12px;
            background: #111;
            border: 3px solid #fff;
            color: #fff;
            border-radius: 0px;
            box-sizing: border-box;
            font-size: 0.85rem;
            font-family: inherit;
            box-shadow: 4px 4px 0px #9400d3;
            transition: all 0.2s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #00ffcc;
            background: #000;
            box-shadow: 6px 6px 0px #ff007f;
            transform: translateY(-2px);
        }

        /* 功能按鈕區 */
        .form-actions {
            display: flex;
            gap: 20px;
            margin-top: 40px;
        }

        button {
            flex: 1;
            font-size: 1.1rem;
            font-weight: 900;
            letter-spacing: 4px;
            padding: 15px;
            border: 4px solid #ffffff;
            cursor: pointer;
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.4), box-shadow 0.2s ease;
            font-family: inherit;
        }

        .btn-submit {
            background: #00ffcc;
            color: #000000;
            box-shadow: 6px 6px 0px #ff007f;
        }

        .btn-submit:hover {
            transform: scale(1.03) translateY(-3px);
            background: #ff007f;
            color: #ffffff;
            box-shadow: 12px 12px 0px #ffd700;
            border-color: #000;
        }

        .btn-reset {
            background: #f44336;
            color: #ffffff;
            box-shadow: 6px 6px 0px #000;
        }

        .btn-reset:hover {
            transform: scale(1.03) translateY(-3px);
            background: #b71c1c;
            box-shadow: 10px 10px 0px #ffd700;
            border-color: #000;
        }

        footer {
            background-color: #000;
            text-align: center;
            padding: 30px;
            font-size: 0.8rem;
            color: #555;
            border-top: 4px solid #ff007f;
            letter-spacing: 1px;
            z-index: 10;
            position: relative;
            margin-top: 60px;
        }

        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .form-group label {
                min-width: 100%;
                text-align-last: left;
            }

            .school-wrapper {
                padding-top: 190px;
                padding-left: 15px;
                padding-right: 15px;
            }

            .section-box {
                padding: 20px;
            }

            .kanji-title {
                font-size: 1.6rem;
                letter-spacing: 3px;
            }

            .header-main-bar {
                padding: 10px 15px;
            }

            .header-top-bar {
                display: none;
            }

            .form-actions {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

    <!-- 🚀 頁首 -->
    <header class="jp-university-header">
        <div class="header-top-bar">
            <div class="jp-lang-selector">
                <span>JAPANESE</span> <span>ENGLISH</span> <span style="color:#ff007f;">DIO語 (WRYYY)</span>
            </div>
            <div class="header-sub-nav">
                <a href="#">受験生の方</a>
                <a href="#">在學生の方</a>
                <a href="#">畢業生の方</a>
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
                <button class="jojo-tool-btn" onclick="changeFontSize(1)">歐拉！字體變大</button>
                <button class="jojo-tool-btn" onclick="zaWarudo()">⏱️ 時間停止</button>
            </div>
        </div>
    </header>

    <!-- 背景擬聲詞 -->
    <div class="menace-text gogo-left">ゴゴゴゴ</div>
    <div class="menace-text gogo-right">ゴゴゴゴ</div>

    <div class="school-wrapper">

        <!-- 布告欄 Banner -->
        <div class="school-gate-banner">
            <h1 class="kanji-title">新入生・替身覺醒願書提交</h1>
        </div>

        <!-- 表單主要區塊 -->
        <div class="section-box">
            <h2 class="section-title">【 學生基本屬性與精神力規格鍵入 】</h2>
            
            <form method="POST" action="./include/api_add_student.php">
                
                <!-- 1. 學號 -->
                <div class="form-group">
                    <label for="school_num">學號</label>
                    <?php 
                        $max_student_num = $pdo->query("SELECT MAX(`school_num`) FROM `students`")->fetchColumn();
                        $default_num = $max_student_num ? $max_student_num + 1 : 1;
                    ?>
                    <input type="number" id="school_num" name="school_num" value="<?= $default_num; ?>" required>
                </div>

                <!-- 2. 所屬班級 -->
                <div class="form-group">
                    <label for="class">所屬班級</label>
                    <select id="class" name="class_code" required>
                        <option value="">請選擇分配的班級</option>
                        <?php 
                            $classes = $pdo->query("SELECT * FROM `classes`")->fetchAll();
                            $is_code = isset($_GET['code']) ? $_GET['code'] : '';
                            foreach($classes as $class):
                        ?>
                        <option value="<?= $class['code']; ?>" <?= ($is_code == $class['code']) ? 'selected' : ''; ?> ><?= $class['name']; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>

                <!-- 3. 座號 -->
                <div class="form-group">
                    <label for="seat_num">座號</label>
                    <?php 
                        // 💡 如果網址列一開始帶有 ?code= 參數，就先預抓該班級的最新座號，否則留空等 JS 觸發
                        $default_seat = '';
                        if (!empty($is_code)) {
                            $stmt = $pdo->prepare("SELECT MAX(`seat_num`) FROM `class_student` WHERE `class_code` = ?");
                            $stmt->execute([$is_code]);
                            $max_seat = $stmt->fetchColumn();
                            $default_seat = $max_seat ? $max_seat + 1 : 1;
                        }
                    ?>
                    <input type="number" id="seat_num" name="seat_num" value="<?= $default_seat; ?>" placeholder="請先選擇班級" required>
                </div>

                <!-- 4. 姓名 -->
                <div class="form-group">
                    <label for="name">姓名</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <!-- 5. 生日 -->
                <div class="form-group">
                    <label for="birthday">生日</label>
                    <input type="date" id="birthday" name="birthday">
                </div>

                <!-- 6. 身份證字號 -->
                <div class="form-group">
                    <label for="uni_id">身份證字號</label>
                    <input type="text" id="uni_id" name="uni_id" placeholder="例如：A123456789" required>
                </div>

                <!-- 7. 地址 -->
                <div class="form-group">
                    <label for="addr">地址</label>
                    <input type="text" id="addr" name="addr">
                </div>

                <!-- 8. 父母 -->
                <div class="form-group">
                    <label for="parents">父母</label>
                    <input type="text" id="parents" name="parents">
                </div>

                <!-- 9. 電話 -->
                <div class="form-group">
                    <label for="tel">電話</label>
                    <input type="text" id="tel" name="tel" placeholder="例如：0912345678">
                </div>

                <!-- 10. 科別 -->
                <div class="form-group">
                    <label for="dept">科別</label>
                    <select id="dept" name="dept" required>
                        <option value="">請選擇科別</option>
                        <?php 
                            $depts = $pdo->query("SELECT * FROM `dept`")->fetchAll();
                            foreach($depts as $dept):
                        ?>
                        <option value="<?= $dept['id']; ?>"><?= $dept['name']; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>

                <!-- 11. 畢業國中 -->
                <div class="form-group">
                    <label for="graduate_at">畢業國中</label>
                    <select id="graduate_at" name="graduate_at">
                        <option value="">請選擇畢業國中</option>
                        <?php 
                            $schools = $pdo->query("SELECT * FROM `graduate_school`")->fetchAll();
                            foreach($schools as $school):
                        ?>
                        <option value="<?= $school['id']; ?>"><?= $school['county'].$school['name']; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>

                <!-- 12. 畢業狀態 -->
                <div class="form-group">
                    <label for="status_code">畢業狀態</label>
                    <select id="status_code" name="status_code">
                        <option value="">請選擇畢業狀態</option>
                        <?php 
                            $status = $pdo->query("SELECT * FROM `status`")->fetchAll();
                            foreach($status as $s):
                        ?>
                        <option value="<?= $s['id']; ?>"><?= $s['status']."(".$s['note'].")"; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>

                <!-- 功能按鈕 -->
                <div class="form-actions">
                    <button type="submit" class="btn-submit">覺醒吧！新增學生</button>
                    <button type="reset" class="btn-reset">清除精神力</button>
                </div>
            </form>
        </div>

    </div>

    <footer>
        © 2026 公立杜王町大学・最高支配者 DIO 帝國. WRYYYYYYYYY!! TO BE CONTINUED... ➔
    </footer>

    <!-- ⚡ JavaScript 邏輯優化 -->
    <script>
        // 監聽班級選擇變更，自動抓取最新座號
        document.getElementById('class').addEventListener('change', function() {
            const classCode = this.value;
            
            // 💡 優化：如果使用者選回「請選擇班級」，直接清空並停止發送請求
            if (!classCode) {
                document.getElementById('seat_num').value = '';
                document.getElementById('seat_num').placeholder = '請先選擇班級';
                return;
            }
            
            fetch(`./include/get_max_seat_num.php?code=${encodeURIComponent(classCode)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(data => {
                    document.getElementById('seat_num').value = data.trim();
                })
                .catch(error => {
                    console.error('錯誤:', error);
                    alert('取得座號失敗，請稍後重試');
                });
        });

        // JOJO 特效
        let currentSizeLevel = 0;
        const baseSize = 19.2;

        function changeFontSize(direction) {
            if (direction === 1) {
                currentSizeLevel = (currentSizeLevel + 1) % 4;
            }
            let newSize = baseSize + (currentSizeLevel * 4);
            document.documentElement.style.fontSize = newSize + "px";
        }

        function zaWarudo() {
            const htmlEl = document.documentElement;
            htmlEl.classList.add('za-warudo-active');
            setTimeout(() => {
                htmlEl.classList.remove('za-warudo-active');
            }, 5000);
        }
    </script>
</body>
</html>
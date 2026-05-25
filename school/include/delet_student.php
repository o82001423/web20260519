<style>
        /* 🎨 100% 完整保留你最得意的精美 CSS 樣式 */
        .delete-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            margin: 20px auto;
        }
        .delete-container .warning-icon {
            text-align: center;
            margin-bottom: 20px;
        }
        .delete-container .warning-icon svg {
            width: 60px;
            height: 60px;
            color: #ff9800;
        }
        .delete-container h1 {
            text-align: center;
            color: #d32f2f;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .delete-container .warning-message {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 30px;
            color: #333;
            line-height: 1.6;
        }
        .delete-container .student-info {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
        .delete-container .student-info p {
            margin-bottom: 8px;
            font-size: 16px;
        }
        .delete-container .school-num {
            font-weight: bold;
            color: #d32f2f;
            font-size: 18px;
        }
        .delete-container .student-name {
            color: #333;
        }
        .delete-container .alert-text {
            color: #d32f2f;
            font-weight: bold;
            margin-top: 15px;
            padding: 10px;
            background-color: #ffebee;
            border-left: 4px solid #d32f2f;
            border-radius: 2px;
        }
        .delete-container .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        .delete-container button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-container .btn-confirm {
            background-color: #d32f2f;
            color: white;
        }
        .delete-container .btn-confirm:hover {
            background-color: #b71c1c;
        }
        .delete-container .btn-cancel {
            background-color: #757575;
            color: white;
        }
        .delete-container .btn-cancel:hover {
            background-color: #616161;
        }
    </style>
</head>
<body>
    <div class="delete-container">
        <div class="warning-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
            </svg>
        </div>
        
        <h1>刪除確認</h1>

        <?php 
        // 🛡️ 修正 1：原地定位自救連線，解決 admin.php 沒連線時的 Fatal Error
        if (!isset($pdo)) {
            $conn_file = __DIR__ . DIRECTORY_SEPARATOR . "db_conn.php";
            if (file_exists($conn_file)) {
                include_once $conn_file;
            } else {
                die("<div class='warning-message' style='background:#ffebee; color:#d32f2f; border-color:#d32f2f;'>❌ 系統錯誤：在 include 資料夾內找不到連線檔 db_conn.php！</div>");
            }
        }

        $student = false; 
        
        // 🛡️ 修正 2：改用安全規格的 Prepare 參數化查詢，阻絕惡意 SQL 注入
        if (isset($_GET['num']) && !empty($_GET['num'])) {
            $stmt = $pdo->prepare("SELECT * FROM `students` WHERE `school_num` = ?");
            $stmt->execute([$_GET['num']]);
            $student = $stmt->fetch();
        }
        
        // 🛡️ 修正 3：優雅攔截器。如果查無此人，直接在容器內顯示錯誤並返回，不讓下方 HTML 報錯
        if (!$student) {
            echo "<div class='warning-message' style='background-color: #ffebee; border: 1px solid #f44336; color: #d32f2f;'>❌ 錯誤：找不到該學生的資料，或該學生已被刪除。</div>";
            echo "<div class='button-group'><button type='button' class='btn-cancel' onclick='window.history.back()'>返回上一頁</button></div>";
            echo "</div></body>"; // 補齊容器標籤
            exit; // 安全退場
        }
        ?>

        <div class="warning-message">
            你是否確認要刪除以下學生？一旦確認刪除後，該學生的關聯班級及成績資料也會一併刪除！
        </div>
        
        <div class="student-info">
            <p>
                <span>學號：</span>
                <span class="school-num"><?= htmlspecialchars($student['school_num']) ?></span>
            </p>
            <p>
                <span>姓名：</span>
                <span class="student-name"><?= htmlspecialchars($student['name']) ?></span>
            </p>
        </div>
        
        <div class="alert-text">
            ⚠️ 此操作無法復原
        </div>
        
        <div class="button-group">
            <form method="POST" action="include/api_delete_student.php" style="flex: 1;">
                <input type="hidden" name="school_num" value="<?= htmlspecialchars($student['school_num']) ?>">
                <button type="submit" class="btn-confirm">確認刪除</button>
            </form>
            
            <button class="btn-cancel" onclick="window.history.back()">取消</button>
        </div>
    </div>
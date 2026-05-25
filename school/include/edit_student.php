<?php 
// 1. 修正路徑：使用 __DIR__ 確保引到同資料夾底下的 db_conn.php
include_once "db_conn.php";

// 2. 防禦機制：如果網址沒有帶 ?num= 學號，就退回
if (!isset($_GET['num'])) {
    die("未指定學生學號，無法進行編輯！");
}

// 3. 撈出該名學生原有的資料
$student = $pdo->query("SELECT * FROM `students` WHERE `school_num`='{$_GET['num']}'")->fetch();
// 修正拼字錯誤：class_srudent -> class_student
$class_student = $pdo->query("SELECT * FROM `class_student` WHERE `school_num`='{$_GET['num']}'")->fetch();

if (!$student) {
    die("找不到該學生的資料！");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯學生資料</title>
</head>
<body>
    <h1>編輯學生資料</h1>

<div class="menace-text gogo-left">ゴゴゴゴ</div>
<div class="menace-text gogo-right">ゴゴゴゴ</div>

<div class="school-wrapper">

    <!-- 布告欄 Banner -->
    <div class="school-gate-banner">
        <h1 class="kanji-title">學生資料・替身能力重塑修正</h1>
    </div>

    <!-- 表單主要區塊 -->
    <div class="section-box">
        <h2 class="section-title">【 學生基本屬性與精神力規格變更 】</h2>
        
        <!-- 💡 注意：Action 修改為處理編輯的 API 檔案，並把學號帶過去 -->
        <form method="POST" action="include/api_edit_student.php">
            
            <!-- 1. 學號 (編輯時學號通常是主鍵，設定唯讀 readonly) -->
            <div class="form-group">
                <label for="school_num">學號 (不可修改)</label>
                <input type="number" id="school_num" name="school_num" value="<?= $student['school_num']; ?>" readonly required>
            </div>

            <!-- 2. 所屬班級 -->
            <div class="form-group">
                <label for="class">所屬班級</label>
                <select id="class" name="class_code" required>
                    <option value="">請選擇分配的班級</option>
                    <?php 
                        $classes = $pdo->query("SELECT * FROM `classes`")->fetchAll();
                        // 優先抓這個學生原本的班級代碼
                        $current_class = $class_student['class_code'] ?? '';
                        foreach($classes as $class):
                    ?>
                    <option value="<?= $class['code']; ?>" <?= ($current_class == $class['code']) ? 'selected' : ''; ?> ><?= $class['name']; ?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <!-- 3. 座號 -->
            <div class="form-group">
                <label for="seat_num">座號</label>
                <input type="number" id="seat_num" name="seat_num" value="<?= $class_student['seat_num'] ?? ''; ?>" required>
            </div>

            <!-- 4. 姓名 -->
            <div class="form-group">
                <label for="name">姓名</label>
                <input type="text" id="name" name="name" value="<?= $student['name']; ?>" required>
            </div>

            <!-- 5. 生日 -->
            <div class="form-group">
                <label for="birthday">生日</label>
                <input type="date" id="birthday" name="birthday" value="<?= $student['birthday']; ?>">
            </div>

            <!-- 6. 身份證字號 -->
            <div class="form-group">
                <label for="uni_id">身份證字號</label>
                <input type="text" id="uni_id" name="uni_id" value="<?= $student['uni_id']; ?>" required>
            </div>

            <!-- 7. 地址 -->
            <div class="form-group">
                <label for="addr">地址</label>
                <input type="text" id="addr" name="addr" value="<?= $student['addr']; ?>">
            </div>

            <!-- 8. 父母 -->
            <div class="form-group">
                <label for="parents">父母</label>
                <input type="text" id="parents" name="parents" value="<?= $student['parents']; ?>">
            </div>

            <!-- 9. 電話 -->
            <div class="form-group">
                <label for="tel">電話</label>
                <input type="text" id="tel" name="tel" value="<?= $student['tel']; ?>">
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
                    <option value="<?= $dept['id']; ?>" <?= ($student['dept'] == $dept['id']) ? 'selected' : ''; ?>><?= $dept['name']; ?></option>
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
                    <option value="<?= $school['id']; ?>" <?= ($student['graduate_at'] == $school['id']) ? 'selected' : ''; ?>><?= $school['county'].$school['name']; ?></option>
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
                    <option value="<?= $s['id']; ?>" <?= ($student['status_code'] == $s['id']) ? 'selected' : ''; ?>><?= $s['status']."(".$s['note'].")"; ?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <!-- 功能按鈕 -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">確認修改資料</button>
                <a href="../admin.php" style="padding: 10px; background: #666; color: #fff; text-decoration: none; border-radius: 4px; margin-left: 10px;">返回管理後台</a>
            </div>
        </form>
    </div>

</div>


</body>
</html>
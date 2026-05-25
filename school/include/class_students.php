<style>
/* 🎨 100% 完整保留你原本漂亮的 CSS 樣式，外觀與懸浮特效絕不更動 */
.student-list{ display:flex; flex-wrap:wrap; gap:20px; margin:16px 0; }
.student-card{ width:240px; background:#ffffff; border-radius:16px; padding:16px; box-shadow:0 5px 15px rgba(0,0,0,0.08); position:relative; transition:0.3s; }
.student-card:hover{ transform:translateY(-5px); box-shadow:0 10px 25px rgba(0,0,0,0.15); }
.student-id{ position:absolute; top:15px; right:15px; background:#6c63ff; color:white; padding:5px 12px; border-radius:30px; font-size:14px; }
.student-photo{ text-align:center; margin-bottom:15px; }
.student-photo img{ width:96px; height:96px; border-radius:50%; object-fit:cover; border:5px solid #f2f2f2; }
.student-name{ text-align:center; font-size:22px; font-weight:bold; margin-bottom:16px; }
.student-info{ display:flex; flex-direction:column; gap:6px; }
.info-row{ display:flex; }
.label{ width:76px; color:#666; font-weight:bold; }
.value{ flex:1; color:#333; }
.btn-row{ display:flex; justify-content: space-evenly; padding:4px 16px; }
a.edit-btn { padding: 4px 16px; border: 1px solid #eee; border-radius: 20px; background: lightgreen; text-decoration: none; color: #333; }
a.edit-btn:hover,a.del-btn:hover{ padding:4px 24px; }
a.del-btn { padding: 4px 16px; border: 1px solid #eee; border-radius: 20px; background: lightcoral; text-decoration: none; color: #333; }

/* 🌟 修正：「新增學生」按鈕改為行內區塊，移除原本的 margin 20px 以防在底部歪掉 */
.add-btn{ padding:8px 24px; background:lightskyblue; border:1px solid lightseagreen; border-radius:24px; font-size:20px; cursor: pointer; display: inline-block; }
.add-btn:hover{ box-shadow:3px 3px 15px #666; transform:translateY(-5px); }

/* 🔍 頂端綜合工具列 */
.control-bar { display: flex; flex-wrap: wrap; align-items: center; gap: 20px; background: #f8f9fa; padding: 20px; border-radius: 16px; margin-bottom: 20px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.03); }
.control-group { display: flex; align-items: center; gap: 8px; }
.control-label { font-weight: bold; color: #555; font-size: 15px; }
.control-input { padding: 8px 14px; font-size: 15px; border: 2px solid #6c63ff; border-radius: 8px; background: white; color: #333; font-weight: bold; outline: none; }
.search-btn { padding: 8px 18px; background: #6c63ff; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.2s; }
.search-btn:hover { background: #5147e5; }
.back-list-btn { padding: 8px 16px; background: #555; color: white; text-decoration: none; border-radius: 8px; font-size: 15px; font-weight: bold; transition: 0.3s; display: inline-flex; align-items: center; }
.back-list-btn:hover { background: #333; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }

/* 📑 修正：底部綜合導覽列改為垂直置中排列，並拉開上下間距 */
.pagination-container { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px; margin: 40px 0; padding-bottom: 20px; width: 100%; }
.pagination-row { display: flex; align-items: center; justify-content: center; gap: 12px; }
.page-btn { padding: 10px 20px; border: 1px solid #6c63ff; border-radius: 25px; background: white; color: #6c63ff; text-decoration: none; font-weight: bold; font-size: 15px; transition: 0.3s; }
.page-btn:hover { background: #6c63ff; color: white; box-shadow: 0 4px 12px rgba(108,99,255,0.3); }
.page-info { color: #555; font-size: 15px; font-weight: bold; margin: 0 10px; }
.page-btn.disabled { background: #ececec; border-color: #ccc; color: #aaa; cursor: not-allowed; pointer-events: none; }
</style>

<?php 
// 1. 引入連線檔
if (!isset($pdo)) {
    include_once __DIR__ . "/db_conn.php";
}

// 2. 撈出所有班級供下拉選單使用
try {
    $all_classes = $pdo->query("SELECT `code`, `name` FROM `classes` ORDER BY `code` ASC")->fetchAll();
} catch (Exception $e) {
    $all_classes = $pdo->query("SELECT DISTINCT `class_code` AS `code`, `class_code` AS `name` FROM `class_student` ORDER BY `class_code` ASC")->fetchAll();
}

// 3. 接收篩選、搜尋、排序的網址參數
$class_code = $_GET['code'] ?? '';
if (empty($class_code) && !empty($all_classes)) {
    $class_code = $all_classes[0]['code']; 
}

$search = trim($_GET['search'] ?? ''); 
$sort   = $_GET['sort'] ?? 'num_asc';   

// 🛡️ 防呆安全攔截
if (empty($class_code)) {
    echo "<div style='padding: 20px; background: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 8px; max-width: 500px; margin: 20px auto; text-align: center; font-weight: bold;'>⚠️ 系統提示：目前沒有班級資料。</div>";
    return;
}

// 🔃 解析排序
$order_by = "`students`.`school_num` ASC"; 
if ($sort === 'num_desc')  $order_by = "`students`.`school_num` DESC"; 
if ($sort === 'birth_asc') $order_by = "`birthday` ASC";
if ($sort === 'birth_desc')$order_by = "`birthday` DESC";

// 📊 組合 SQL 查詢條件
$params = [$class_code];
$search_where = "";

if (!empty($search)) {
    $search_where = " AND (`students`.`name` LIKE ? OR `students`.`school_num` LIKE ?) ";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// 📐 A. 計算總人數
$count_sql = "SELECT COUNT(*) 
              FROM `class_student`, `students` 
              WHERE `class_student`.`class_code` = ? AND 
                    `class_student`.`school_num` = `students`.`school_num`" . $search_where;

$count_stmt = $pdo->prepare($count_sql);
$count_stmt->execute($params);
$total_students = $count_stmt->fetchColumn();

// 📊 B. 分頁參數計算
$limit = 8; 
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1; 
$offset = ($page - 1) * $limit; 

$total_pages = ceil($total_students / $limit);
if ($total_pages < 1) $total_pages = 1; 
if ($page > $total_pages) { $page = $total_pages; $offset = ($page - 1) * $limit; }

// 🛡️ C. 撈取最終學生資料
$sql = "select `students`.`school_num`,
               `students`.`name`,
               `dept`.`name` as 'dept_name',
               `addr`,
               `uni_id`,
               `graduate_school`.`name` as 'graduate_school',
               `birthday` 
        from `class_student`,
             `students`,
             `dept`,
             `graduate_school`
       where `class_student`.`class_code` = ? AND 
             `class_student`.`school_num` = `students`.`school_num` AND
             `dept`.`id` = `students`.`dept` AND
             `graduate_school`.`id` = `students`.`graduate_at`" 
        . $search_where . 
        " ORDER BY " . $order_by . 
        " LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$students = $stmt->fetchAll();

$query_string = "&code=" . urlencode($class_code) . "&search=" . urlencode($search) . "&sort=" . urlencode($sort);
?>

<form method="GET" action="admin.php" class="control-bar">
    <input type="hidden" name="inc" value="class_students">

    <div class="control-group">
        <a href="admin.php?inc=classes_list" class="back-list-btn">
            📁 返回班級總表
        </a>
    </div>

    <div class="control-group">
        <span class="control-label">班級：</span>
        <select name="code" class="control-input" onchange="this.form.submit();">
            <?php foreach ($all_classes as $cls): ?>
                <option value="<?= htmlspecialchars($cls['code']) ?>" <?= ($cls['code'] == $class_code) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cls['code']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="control-group">
        <span class="control-label">排序依據：</span>
        <select name="sort" class="control-input" onchange="this.form.submit();">
            <option value="num_asc" <?= ($sort == 'num_asc') ? 'selected' : '' ?>>學號 (小 ➔ 大)</option>
            <option value="num_desc" <?= ($sort == 'num_desc') ? 'selected' : '' ?>>最新學生 (學號大 ➔ 小)</option>
            <option value="birth_asc" <?= ($sort == 'birth_asc') ? 'selected' : '' ?>>生日 (老 ➔ 年輕)</option>
            <option value="birth_desc" <?= ($sort == 'birth_desc') ? 'selected' : '' ?>>生日 (年輕 ➔ 老)</option>
        </select>
    </div>

    <div class="control-group" style="flex: 1; min-width: 200px; justify-content: flex-end;">
        <input type="text" name="search" class="control-input" placeholder="請輸入姓名或學號..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="search-btn">搜尋</button>
    </div>
</form>

<h2><?= htmlspecialchars($class_code); ?> 班級學生列表</h2>

<?php 
if (empty($students)) {
    echo "<p style='text-align:center; color:#999; margin: 40px 0;'>查無符合條件的學生資料。</p>";
} else {
    echo "<div class='student-list'>";
    foreach($students as $student):?>
        <div class="student-card">
            <div class="student-id">
                <?= htmlspecialchars($student['school_num']); ?>
            </div>
            <div class="student-photo">
                <?php if(isset($student['header'])): ?>
                    <img src="img/<?= htmlspecialchars($student['header']); ?>">
                <?php else : ?>
                    <img src="img/<?= (mb_substr($student['uni_id'],1,1) == 1) ? 'header_default_boy.jpg' : 'header_default_girl.jpg'; ?>">
                <?php endif;?>
            </div>
            <div class="student-name">
                <?= htmlspecialchars($student['name']); ?>
            </div>

            <div class="student-info">
                <div class="info-row">
                    <span class="label">生日</span>
                    <span class="value"><?= htmlspecialchars($student['birthday']); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">地址</span>
                    <span class="value"><?= htmlspecialchars(mb_substr($student['addr'],0,3)); ?>...</span>
                </div>
                <div class="info-row">
                    <span class="label">科別</span>
                    <span class="value"><?= htmlspecialchars($student['dept_name']); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">畢業國中</span>
                    <span class="value"><?= htmlspecialchars($student['graduate_school']); ?></span>
                </div>
                
                <div class="btn-row">
                    <a class="edit-btn" href="admin.php?inc=edit_student&num=<?= urlencode($student['school_num']); ?><?= $query_string; ?>&page=<?= $page; ?>">編輯</a>
                    <a class="del-btn" href="admin.php?inc=delet_student&num=<?= urlencode($student['school_num']); ?><?= $query_string; ?>&page=<?= $page; ?>" onclick="return confirm('確定要將該名學生退學除名嗎？');">刪除</a>
                </div>
            </div>
        </div>
    <?php endforeach;?>
    </div>
<?php } ?>

<div class="pagination-container">
    <div class="pagination-row">
        <a class="page-btn <?= ($page <= 1) ? 'disabled' : ''; ?>" 
           href="admin.php?inc=class_students<?= $query_string; ?>&page=<?= $page - 1; ?>">
           上一頁
        </a>

        <span class="page-info">第 <?= $page; ?> / <?= $total_pages; ?> 頁 (篩選出 <?= $total_students; ?> 位學生)</span>

        <a class="page-btn <?= ($page >= $total_pages) ? 'disabled' : ''; ?>" 
           href="admin.php?inc=class_students<?= $query_string; ?>&page=<?= $page + 1; ?>">
           下一頁
        </a>
    </div>

    <a href="admin.php?inc=add_student&code=<?= urlencode($class_code) . $query_string; ?>&page=<?= $page; ?>">
        <button class='add-btn'>＋ 新增學生</button>
    </a>
</div>
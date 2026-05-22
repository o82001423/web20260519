<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>刪除資料</title>
</head>
<body>
   div class="menace-text gogo-left">ゴゴゴゴ</div>
<div class="menace-text gogo-right">ゴゴゴゴ</div>
    <H1>刪除資料</H1>
    <?php 
    $pdo->query("delete from `students` where `school_num` = '{$_GET['num']}'")->fetch();
    ?>
    <div class="warning-message">  
        你是否確認要刪除以下學生？一旦確認刪除後，該學生的關聯班級及成績資料也會一併刪除！</div>
        <div class="student-info">
        <p>
            <span>學號：</span>
            <span class="school-num"><? htmlspecialchars($studet['school_num']?? $_POST['school_num']?? '') ?></span>
        </p>
        <p>
            <span>姓名：</span>
            <span class="name"><? htmlspecialchars($studet['name']?? $_POST['name']?? '') ?></span>
        </p>
        </div>
        <div class="alert-text">⚠️ 此操作無法復原</div>
        <div class="button-group">
            <from mothod="POST" action="./include/api_add_student.php" style="flex:1px;">
                <input type="hidden" name="school_num" value="<?= htmlspecialchars($student['school_num']) ?>">
                <button type="submit" class="confirm-btn">確認刪除</button>
            </from>
           <button class="cancel-btn" onclick="window.history.back()">取消</button>
        </div>
</body>
</html>
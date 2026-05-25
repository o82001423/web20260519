<style>
/* 整個列表 */
.student-list{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    margin:16px 0;
}


/* 卡片 */
.student-card{
    width:240px;
    background:#ffffff;
    border-radius:16px;
    padding:16px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);

    position:relative;

    transition:0.3s;
}


/* 滑鼠效果 */
.student-card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}


/* 學號 */
.student-id{
    position:absolute;
    top:15px;
    right:15px;

    background:#6c63ff;
    color:white;

    padding:5px 12px;
    border-radius:30px;

    font-size:14px;
}


/* 大頭照 */
.student-photo{
    text-align:center;
    margin-bottom:15px;
}

.student-photo img{
    width:96px;
    height:96px;
    border-radius:50%;
    object-fit:cover;
    border:5px solid #f2f2f2;
}


/* 姓名 */
.student-name{
    text-align:center;
    font-size:22px;
    font-weight:bold;
    margin-bottom:16px;
}


/* 資訊區 */
.student-info{
    display:flex;
    flex-direction:column;
    gap:6px;
}


/* 每一列 */
.info-row{
    display:flex;
}


/* 標題 */
.label{
    width:76px;
    color:#666;
    font-weight:bold;
}


/* 值 */
.value{
    flex:1;
    color:#333;
}
.btn-row{
    display:flex;
    justify-content: space-evenly;
    padding:4px 16px;
}
a.edit-btn {
    padding: 4px 16px;
    border: 1px solid #eee;
    border-radius: 20px;
    background: lightgreen;
}
a.edit-btn:hover,a.del-btn:hover{
    padding:4px 24px;
}

a.del-btn {
    padding: 4px 16px;
    border: 1px solid #eee;
    border-radius: 20px;
    background: lightcoral;
}
.add-btn{
    display:inline-block;
    padding:8px 24px;
    background:lightskyblue;
    margin:20px;
    border:1px solid lightseagreen;
    border-radius:24px;
    font-size:20px;
}
.add-btn:hover{
    box-shadow:3px 3px 15px #666;
    transform:translateY(-5px);
}
.page-nav {
    display: block;
    margin: auto;
    width: 80%;
}

.page-nav a {
    text-decoration: none;
    display: inline-block;
    margin: 0px 2px;
    padding: 4px;
    border: 1px solid #ddd;
    border-radius: 6px;
    width: 36px;
    height: 36px;
    text-align: center;
}
</style>

<a href="?inc=add_student" class='add-btn'>新增學生</a>

<?php 
//從class_student 中找到班級學生的學號
include "db_conn.php";
$total_students=$pdo->query("select count(*) from `students`")->fetchColumn();
$div=16;
$pages=ceil($total_students/$div);
$now_page=$_GET['page']??1;
$start=($now_page-1)*$div;

$sql="select 
             `students`.`school_num`,
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
       where `class_student`.`school_num`=`students`.`school_num` AND
             `dept`.`id`=`students`.`dept` AND
             `graduate_school`.`id`=`students`.`graduate_at`
        limit $start,$div";
//$nums=$pdo->query($sql)->fetchAll();


$students=$pdo->query($sql)->fetchAll();
?>

<div class='page-nav'>
<?php 

    if($now_page-1 >0){
        $perv=$now_page-1;
        echo "<a href='?inc=students&page=$perv'> < </a>";
    }

    for($i=1;$i<=$pages;$i++){
        echo "<a href='?inc=students&page=$i'> $i </a>";
    }

    if($now_page+1 <=$pages){
        $next=$now_page+1;
        echo "<a href='?inc=students&page=$next'> > </a>";
    }
    ?>
</div>
<?php
echo "<div class='student-list'>";
foreach($students as $student):?>
    <!-- 單一卡片 -->
    <div class="student-card">
        <!-- 學號 -->
        <div class="student-id">
            <?= $student['school_num']; ?>
        </div>
        <!-- 大頭照 -->
        <div class="student-photo">
            <?php if(isset($student['header'])):;?>
            <img src="img/<?= $student['header']; ?>">
            <?php else :;?>
            <img src="img/<?= (mb_substr($student['uni_id'],1,1)==1)?'header_default_boy.jpg':'header_default_girl.jpg'; ?>">
            <?php endif;?>
        </div>
        <!-- 姓名 -->
        <div class="student-name">
            <?= $student['name'] ?>
        </div>

        <!-- 資料區 -->
        <div class="student-info">
            <div class="info-row">
                <span class="label">生日</span>
                <span class="value"><?= $student['birthday']; ?></span>
            </div>
            <div class="info-row">
                <span class="label">地址</span>
                <span class="value"><?= mb_substr($student['addr'],0,3); ?></span>
            </div>
            <div class="info-row">
                <span class="label">科別</span>
                <span class="value"><?= $student['dept_name']; ?></span>
            </div>
            <div class="info-row">
                <span class="label">畢業國中</span>
                <span class="value"><?= $student['graduate_school']; ?></span>
            </div>
            <div class="btn-row">
                <a class="edit-btn" href="?inc=edit_student&num=<?= $student['school_num']; ?>">編輯</a>
                <a class="del-btn" href="?inc=delete_student&num=<?= $student['school_num']; ?>">刪除</a>
            </div>
        </div>
    </div>

    <?php endforeach;?>
</div>
<div class='page-nav'>
<?php 

    if($now_page-1 >0){
        $perv=$now_page-1;
        echo "<a href='?inc=students&page=$perv'> < </a>";
    }

    for($i=1;$i<=$pages;$i++){
        echo "<a href='?inc=students&page=$i'> $i </a>";
    }

    if($now_page+1 <=$pages){
        $next=$now_page+1;
        echo "<a href='?inc=students&page=$next'> > </a>";
    }
    ?>
</div>



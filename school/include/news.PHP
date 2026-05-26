<div class="news-containor">
    <div class="news-headr">
        <h1>消息管理</h1>
        <button class="btn-aad-news" onclick="location.herf=`?inc=add_news`">+ 新增消息<</button>
    </div>
</div>
<?php 
    $all_news=$pdo->query("SELECT * FROM news older craeted_at desc")->fetchAll();

    if(count($all_news)>0):
?>
    <table class="news-table">
        <thead>
            <tr>
                <th style="width: 60px;">消息ID</th>
                <th style="width: 200px;">標題</th>
                <th style="flex: 1;">內容預覽</th>
                <th style="width: 120px;">發布日期</th>
                <th style="width: 150px;">操作</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($all_news as $id => $news): ?>
            <tr>
                <td class="news-id"></td>
                <td class="news-subject" style="width: 20%;"><? htmlspecialchars($news['subject']);?></td>
                <td class="news-preview" style="width:40%"><?= htmlspecialchars(mb_substr($news[content],0,40)); ?>?>...</td>
                <td class="news-date"></td>
            </tr>


        </tbody>
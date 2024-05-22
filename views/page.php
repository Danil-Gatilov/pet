<?php
/**
 * @var \App\View $view
 * @var \App\models\diary $diary
 */
$page = $page[0];
$view->start();
?>
<body>
<?php $view->component('diaryNavbar', ['diary' => $diary]); ?>
<?php $view->component('header'); ?>
<div style="height: 100vh;">
    <div style="margin-left: 200px; /* ширина навигационной панели */ padding: 20px 7.5vw 20px 7.5vw; display: flex; flex-direction: column; align-items: center">
        <div >
            <h2><?php echo $page['created_at'] ?></h2>
        </div>
        <div style="margin-top: 5vh">
            <p><?php echo $page['text'] ?></p>
        </div>
        <div style="margin-top: 5vh; display: flex;">
            <div>
                <form action="/blog/edit" method="post">
                    <input type="hidden" name="created_at" value="<?php echo $page['created_at'] ?>">
                    <button class="button-link">Редактировать</button>
                </form>
            </div>
            <div style="margin-left: 5vw">
                <form action="/blog/deletePage" method="post">
                    <input type="hidden" name="created_at" value="<?php echo $page['created_at'] ?>">
                    <button class="button-link" style="background-color: red">Удалить</button>
                </form>
            </div>
        </div>
    </div>
    <div style="display: flex; flex-direction: column; align-items: center;">
        <a href="/blog/home" class="button-link" style="background-color: #38ff32">Вернуться домой</a>
    </div>
</div>



</body>

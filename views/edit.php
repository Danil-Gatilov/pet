<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 * @var \App\models\diary $diary
 */
$page = $page[0];
$view->start();
?>

<body style="margin: 0; padding: 0;">
<?php $view->component('diaryNavbar', ['diary' => $diary]); ?>
<?php $view->component('header'); ?>

<div style="margin-left: 200px; /* ширина навигационной панели */padding: 20px;">
    <h2><?php echo $page['updated_at'] ?? $page['created_at']; ?></h2>
    <form action="/blog/patch" method="post">

        <textarea name="text"  style="width: 40%; height: 40vh"><?php echo $page['text'] ?></textarea>
        <input type="hidden" name="created_at" value="<?php echo $page['created_at'] ?>">

        <button style="margin-bottom: 30px" class="btn btn-primary" type="submit">Редактировать</button>
    </form>
</div>
</body>
</html>

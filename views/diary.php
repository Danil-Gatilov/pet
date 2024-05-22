<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 * \@var \App\models\diary $diary
 */

$view->start();
?>

<body style="margin: 0; padding: 0;">
<?php $view->component('diaryNavbar', ['diary' => $diary]); ?>
<?php $view->component('header'); ?>

<div style="margin-left: 200px; /* ширина навигационной панели */padding: 20px;">
    <div>
        <h2><?php echo date('d. m. Y') ?></h2>
        <form action="/blog/diary" method="post">
            <div>
                <label>Как прошёл твой день?</label>
            </div>

            <textarea name="text" style="width: 40%; height: 40vh"></textarea>

            <button style="margin-bottom: 30px" class="btn btn-primary" type="submit">Записать</button>
        </form>
    </div>
    <div>
        <a href="/blog/home" class="button-link" style="background-color: #38ff32">Вернуться домой</a>
    </div>
</div>
</body>
</html>

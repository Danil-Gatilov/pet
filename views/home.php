<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 */
$view->start();
?>
<body style="margin: 0; padding: 0;">
<?php $view->component('navbar'); ?>
<?php $view->component('header'); ?>
<div style="margin-left: 200px; /* ширина навигационной панели */padding: 20px;">
    <h1>
        <?php echo 'Hello' . ' ' . strtok($session->get('nickName'), ' ') ?>
        <br>how are you
    </h1>
    <h5>
        Погода в москве: <?php  echo round($response['main']['temp'] - 273.15) ?> градусов
    </h5>
</div>
</body>
</html>

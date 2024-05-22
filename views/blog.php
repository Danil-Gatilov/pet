<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 * \@var \App\models\diary $diary
 */

$view->start();
?>

<body>
<?php $view->component('header'); ?>
<?php $view->component('navbar'); ?>
<script
        class="amocrm_oauth"
        charset="utf-8"
        data-client-id="c3517529-b797-4c94-9c75-38afa9a494fb"
        data-title="Авторизаваться через amoCRM"
        data-compact="false"
        data-class-name="className"
        data-color="default"
        data-state="state"
        data-error-callback="accessDenied"
        data-mode="popup"
        src="https://www.amocrm.ru/auth/button.min.js"
></script>

</body>



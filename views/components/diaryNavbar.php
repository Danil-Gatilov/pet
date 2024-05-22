<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 * @var \App\models\diary $diary
 */

?>
<!--<div style="width: 20%; height: 100%; background-color: #262626">-->
<div style="float: left; width: 200px; background-color: #f1f1f1; height: 100vh; /* высота вьюпорта */">
    <ul style="margin-top: 10px">
        <?php foreach ($diary->getAll() as $page) { ?>
            <li style="margin: 5px">
                <form action="/blog/page" method="post">
                    <input type="hidden" name="created_at" value="<?php echo $page['created_at'] ?>">
                    <button type="submit" class="submit-link"><?php echo $page['created_at'] ?></button>
                </form>
            </li>
        <?php } ?>
    </ul>
</div>

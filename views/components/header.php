<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 */
?>

<!--<div style="width: 80%; height: 10%; background-color: bisque;  display: flex; justify-content: space-between; align-items: center">-->
<div style="background-color: bisque;
            color: firebrick;
            padding: 20px;
            display: flex; justify-content: space-between; align-items: center">
    <div style="width: 20%">

    </div>
    <div>
        <a href="/blog/diary" style="text-decoration: none; color: #262626">дневник</a>
    </div>
    <div>
        <a href="/blog/blog" style="text-decoration: none; color: #262626">amoCRM</a>
    </div>
    <div>
        <a href="/blog/library" style="text-decoration: none; color: #262626">библиотека</a>
    </div>
    <div style="width: 25%; display: flex; justify-content: right">
        <div style="width: 60%">
            <?php if ($session->has('nickName')) {
            echo $session->get('nickName'); }?>

            <form method="post" action="/blog/logout">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</div>
<?php
/**
 * @var \App\models\Book $books
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моя страница</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        nav {
            float: left;
            width: 200px;
            background-color: #f1f1f1;
            height: 100vh;
            display: flex;
            flex-direction: column; /* Добавлено */
        }

        nav li {
            word-wrap: break-word; /* Перенос текста кнопок на новую строку */
            margin-bottom: 5px; /* Добавлено */
        }

        main {
            margin-left: 200px;
            padding: 20px;
        }

        .button-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-link {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
            padding: 0;
            font: inherit;
            outline: none;
            width: 100%; /* Изменено */
            text-align: left; /* Добавлено */
            display: block; /* Добавлено */
            margin: 0; /* Добавлено */
        }
    </style>
</head>
<body>

<header>
    <h1>Добро пожаловать в библиотеку</h1>
</header>

<nav>
    <ul>
        <?php foreach ($books->getAll() as $book) { ?>
            <li>
                <form action="/blog/read" method="post">
                    <input type="hidden" name="bookName" value="<?php echo $book['bookName'] ?>">
                    <button type="submit" class="submit-link"><?php echo $book['bookName'] ?></button>
                </form>
            </li>
        <?php } ?>
    </ul>
</nav>

<main>
    <div>
        <form enctype="multipart/form-data" action="/blog/library" method="post">
            <h2>Есть что-нибудь новенькое?</h2>
            <div>
                <label>Название книги</label>
                <input type="text" name="bookName">
            </div>
            <div style="margin: 5px 0 5px 0"><input type="file" name="book"></div>
            <button>Загрузить</button>
        </form>
    </div>
    <div>
        <form action="/blog/delete" method="post">
            <h2>Хочешь удалить книгу?</h2>
            <select name="bookName">
                <?php foreach ($books->getAll() as $book) { ?>
                    <option><?php echo $book['bookName'] ?></option>
                <?php } ?>
            </select>
            <button type="submit" style="color: red">Удалить</button>
        </form>
    </div>
    <div style="margin-top: 10px">
        <a href="/blog/home" class="button-link">Вернуться домой</a>
    </div>
</main>

</body>
</html>
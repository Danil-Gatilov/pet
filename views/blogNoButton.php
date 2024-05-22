<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 * @var \App\models\diary $diary
 * @var array $leads
 * @var array $contacts
 * @var array $acc
 * @var array $customFields
 */
error_reporting(E_ERROR);
?>
<!doctype html>
<html lang="en" style="height: 100%; width: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Стили для всплывающего окна */
        .popup {
            display: none; /* Скрыть всплывающее окно по умолчанию */
            position: fixed;
            z-index: 9999;
            left: 50%;
            top: 50%;
            transform: translate(-49.5%, -50%);
            background-color: white;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Стили для темного фона */
        .overlay {
            display: none; /* Скрыть фон по умолчанию */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            cursor: pointer; /* Добавляем указатель при наведении на фон */
        }

        .button-link {
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
        .link {
            display: inline-block;
            padding: 10px 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
<?php $view->component('header') ?>

<h1>
    Привет, <?php echo $acc['name'] ?>
</h1>
<button onclick="openPopup()">создать сделку</button>

<!-- Всплывающее окно -->
<div id="popup" class="popup">
    <h2>Создание сделки</h2>
    <form action="/blog/blog" method="post">
        <label for="name">Имя:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="phone">Номер телефона:</label><br>
        <input type="tel" id="phone" name="phone"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="price">Сумма:</label><br>
        <input type="number" id="price" name="price"><br>
        <label for="company">Название компании:</label><br>
        <input type="text" id="company" name="company"><br><br>
        <input type="submit" value="Создать">
    </form>
</div>

<!-- Темный фон -->
<div id="overlay" class="overlay" onclick="closePopup()"></div>

<script>
    // Функция для открытия всплывающего окна
    function openPopup() {
        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    // Функция для закрытия всплывающего окна
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
</script>
<div style="margin: 4%">
    <table class="table">
        <thead>
        <tr>
            <th colspan="5" scope="row" style="text-align: center;">Мои сделки</th>
        </tr>
        <tr>
            <th style="width: 20%" scope="col">id</th>
            <th style="width: 20%" scope="col">price</th>
            <th style="width: 20%" scope="col">name</th>
            <th style="width: 20%" scope="col">phone</th>
            <th style="width: 20%" scope="col">e-mail</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($leads['_embedded']['leads'] as $lead) { ?>
            <tr>
                <td>
                    <form action="/blog/lead" method="post">
                        <input type="hidden" name="id" value="<?php echo $lead['id'] ?>">
                        <button class="button-link"><?php echo $lead['id'] ?></button>
                    </form>
                </td>
                <td><?php echo $lead['price'] ?></td>
                <td><?php echo $lead['name'] ?></td>
                <?php foreach ($contacts['_embedded']['contacts'] as $contact) {
                    if ($contact['id'] === $lead['_embedded']['contacts'][0]['id']) { ?>
                        <td><?php echo $contact['custom_fields_values'][0]['values'][0]['value']?></td>
                        <td><?php echo $contact['custom_fields_values'][1]['values'][0]['value']?></td>
                    <?php }
                } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</table>
<div>
    <a href="/blog/home" class="link" style="background-color: #38ff32">Вернуться домой</a>
</div>
</body>



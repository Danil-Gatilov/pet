<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 * @var \App\models\diary $diary
 * @var array $lead
 * @var array $company
 * @var array $contact
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

        .popup {
            display: none;
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
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            cursor: pointer;
        }
        a.button {
            display: inline-block;
            padding: 5px 10px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            color: #ffffff;
            background-color: #007bff;
            border: 2px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s, border-color 0.3s, transform 0.3s;
        }

        a.button:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: scale(1.05);
        }

        a.button:active {
            background-color: #004085;
            border-color: #004085;
            transform: scale(0.95);
        }

    </style>
</head>
<body>
<?php $view->component('header')?>
<div style="margin: 7%">
    <table class="table">
        <thead>
        <tr>
            <th colspan="6" scope="row" style="text-align: center;">Сделка</th>
        </tr>
        <tr>
            <th style="width: 16.66%" scope="col">id</th>
            <th style="width: 16.66%" scope="col">name</th>
            <th style="width: 16.66%" scope="col">price</th>
            <th style="width: 16.66%" scope="col">phone</th>
            <th style="width: 16.66%" scope="col">e-mail</th>
            <th style="width: 16.7%" scope="col">company</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php echo $lead['id'] ?></td>
            <td><?php echo $lead['name'] ?></td>
            <td><?php echo $lead['price'] ?></td>
            <td><?php echo $contact['_embedded']['contacts'][0]['custom_fields_values'][0]['values'][0]['value'] ?></td>
            <td><?php echo $contact['_embedded']['contacts'][0]['custom_fields_values'][1]['values'][0]['value'] ?></td>
            <td><?php echo $company['_embedded']['companies'][0]['name'] ?></td>
        </tr>
        </tbody>
    </table>
    <div>
        <form action="/blog/editLead" method="post">
            <input type="hidden" name="id" value="<?php echo $lead['id'] ?>">
            <input type="hidden" name="name" value="<?php echo $lead['name'] ?>">
            <input type="hidden" name="price" value="<?php echo $lead['price'] ?>">
            <input type="hidden" name="phone" value="<?php echo $contact['_embedded']['contacts'][0]['custom_fields_values'][0]['values'][0]['value'] ?>">
            <input type="hidden" name="email" value="<?php echo $contact['_embedded']['contacts'][0]['custom_fields_values'][1]['values'][0]['value'] ?>">
            <input type="hidden" name="company" value="<?php echo $company['_embedded']['companies'][0]['name'] ?>">
            <button style="background-color: chartreuse">Редакитровать</button>
        </form>
        <a href="/blog/blog" class="button">Назад</a>
<!--        <form style="margin-top: 10px">-->
<!--            <button style="background-color: red">Удалить</button>-->
<!--        </form>-->
    </div>
    <!-- Всплывающее окно-->
    <div id="popup" class="popup">
        <h2>Регистрация</h2>
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
            <input type="submit" value="Зарегистрироваться">
        </form>
    </div>

    <div id="overlay" class="overlay" onclick="closePopup()"></div>

    <script>
        function openPopup() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</div>
</table>
</body>



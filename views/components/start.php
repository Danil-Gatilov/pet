<!doctype html>
<html lang="en" style="height: 100%; width: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .submit-link {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
            padding: 0;
            font: inherit;
            outline: none;
            width: 100%;
            text-align: left;
            display: block;
            margin: 0;
        }

        .button-link {
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
    </style>
</head>
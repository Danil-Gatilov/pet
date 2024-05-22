<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 * @var \App\models\diary $diary
 * @var array $lead
 * @var array $company
 * @var array $contact
 */
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
        .button-link {
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
    </style>
</head>
<body>
<?php $view->component('header')?>

<div style="margin: 7%">
    <h1>ID сделки: <?php echo $id?></h1>
    <form action="/blog/patch" method="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input style="width:20vw" type="text" name="name" value="<?php echo $leadName ?>">
        <input type="number" name="price" value="<?php echo $price ?>">
        <div><button style="margin-top: 10px">Подтвердить изменения</button></div>
    </form>
</div>
</table>
</body>



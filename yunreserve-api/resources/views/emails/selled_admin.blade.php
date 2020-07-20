<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>{{ $subject }}</h2>
        <div>{{ $msg }}</div>
        <br><br>
        <div><b>姓名:</b> {{ $name }}</div>
        <div><b>帳號:</b> {{ $account }}</div>
        <div><b>新的密碼:</b> {{ $password }}</div>
        <div><b>請至連結更改密碼:</b> {{ $changeAccountURL }}</div>
    </body>
</html>

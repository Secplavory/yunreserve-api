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
        <div><b>銀行代碼:</b> {{ $bankCode }}</div>
        <div><b>銀行帳號:</b> {{ $bankAccount }}</div>
        <div><b>電話:</b> {{ $phone }}</div>
        <div><b>驗證帳號請點選連結:</b> {{ $verifyURL }}</div>
    </body>
</html>

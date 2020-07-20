<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>{{ $subject }}</h2>
        <div>{{ $msg }}</div>
        <br><br>
        <div><b>商品: {{ $product }} 已經賣出</b></div>
        <div><b>價格: {{ $price }}</b></div>
        <div><b>手續費: {{ $fee }}</b></div><br>
        <div><b>匯款銀行代碼: {{ $bankCode }}</b></div>
        <div><b>匯款銀行帳號: {{ $bankAccount }}</b></div>
    </body>
</html>

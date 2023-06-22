<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(!session()->has('user'))
        <p>User is not logged in</p>
    @else
        <h2>{{ session()->get('user')->username }}</h2>
        <p>{{ session()->get('user')->name }} {{ session()->get('user')->surname }}</p>
    @endif
</body>
</html>

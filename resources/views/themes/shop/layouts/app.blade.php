<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>shop: Official Site</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/themes/shop/main.css'])
</head>
<body>
    @include('themes.shop.shared.header')
    @include('themes.shop.shared.slider')
    @yield('content')
    @include('themes.shop.shared.footer')
</body>
</html>
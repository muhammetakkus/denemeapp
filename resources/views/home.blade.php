<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Deneme App</title>

        <!--  -->
        <link rel="icon" type="image/png" sizes="16x16" href="/template/images/favicon.png">

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">

        <link href="/css/plugins.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">

        <link href="/template/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="/template/css/style.css" rel="stylesheet">

        <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    </head>
    <body>

      <div id="app">

      </div>

      <!--  -->
      <script src="/template/vendor/global/global.min.js"></script>
      <script src="/template/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
      <script src="/template/js/custom.min.js"></script>
      <script src="/template/js/deznav-init.js"></script>

      <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>

      <!-- <script src="/js/jquery.js"></script> -->
      <script src="/js/plugins.js"></script>
      <script src="/js/functions.js"></script>
    </body>
</html>

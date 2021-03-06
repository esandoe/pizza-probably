<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍕</text></svg>">
        <link rel="stylesheet" type="text/css" href="/style.css">
        <title>Pizza-Probably! {{ $pageTitle ?? '' }}</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans|RocknRoll+One">
        @stack('styles')
    </head>
    <body>
        <header class="content-wrap centered-content">
            <h1><a href="/">🍕 Erik's oppskriftsbok</a></h1>
        </header>

        {{ $slot }}

        <footer class="content-wrap centered-content content">
            <a href="/">Hjem</a> -
            <a href="https://github.com/esandoe/pizza-probably">GitHub</a>
        </footer>

        @stack('scripts')
    </body>
</html>

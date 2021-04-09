<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍕</text></svg>">
        <title>Pizza-Probably! {{ $pageTitle ?? '' }}</title>
        <style>
            .content-wrap {
                max-width: 850px;
                margin: 0 auto;
            }

            .centered-content {
                text-align: center;
            }

            .content {
                padding: .5em;
            }

            header {
                border-bottom: 2px solid darkgray;
            }

            header a, header a:link, header a:visited, header a:hover, header a:active {
                color: inherit;
                text-decoration: none;
            }

            footer {
                padding: 1em;
                border-top: 1px solid darkgray;
            }

            body {
                margin: 10px;
            }
        </style>
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
    </body>
</html>

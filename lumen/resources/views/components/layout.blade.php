<html lang="en">
    <head>
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
                padding: 2em 0.7em;
            }

            header {
                border-bottom: 2px solid darkgray;
            }

            footer {
                margin-top: 1em;
                padding-top: 1.5em;
                border-top: 1px solid darkgray;
            }
        </style>
    </head>
    <body>
        <header class="content-wrap centered-content">
            <h1>🍕 Erik's oppskriftsbok</h1>
        </header>

        {{ $slot }}

        <footer class="content-wrap centered-content">
            <a href="/">Hjem</a>
        </footer>
    </body>
</html>

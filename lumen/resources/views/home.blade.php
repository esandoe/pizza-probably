<x-layout>
    <section class="content-wrap content">
        <a href="/edit/untitled">Lag ny oppskrift!</a>
    </section>

    <section class="content-wrap flex-grid">
        @foreach ($recipes as $recipe)
            <div class="flex-item">
                <div class="polaroid">
                    <a href="/recipe/{{ $recipe->name }}">
                        <img src="{{ $recipe->image ?? '/uploads/img/stock-image.jpg' }}" alt="">
                        <div class="container">
                            <p>{{$recipe['title']}}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </section>

    <style>
        div.polaroid {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            text-align: center;
            background-color: var(--bg-light);
            height: 100%;
        }

        div.polaroid a {
            text-decoration: None;
        }

        div.polaroid img {
            width: 100%;
            height: 170px;
            object-fit: cover;
        }

        .flex-grid {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            align-items: stretch;
        }

        .flex-item {
            margin: 0;
            padding: 2%;
            box-sizing: border-box;
            width: 50%;
        }

        /* Medium devices (landscape tablets, 768px and up) */
        @media only screen and (min-width: 992px) {
            .flex-item { width: 33.32% }
        }

        /* Extra large devices (large laptops and desktops, 1200px and up) */
        @media only screen and (min-width: 1200px) {
            .flex-item { width: 25% }
        }
    </style>
</x-layout>

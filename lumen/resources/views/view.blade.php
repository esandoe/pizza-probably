<x-layout>
    <x-slot name="pageTitle">
        - {{ $recipe->title }}
    </x-slot>



    <section class="content-wrap two-column">

        <div class="recipe-image">
            <img src="{{ $recipe->image }}" alt="">
        </div>
        <div class="recipe-header">
            <h1>{{ $recipe->title }}</h1>
            <div class="recipe-infos">
                <ul>
                    <li class="author">{{ $recipe->author }}</li>
                    <li>{{ $recipe->created_at->format('M Y') }}</li>
                    <li>endret {{ $recipe->updated_at->format('d M Y')}}</li>
                    <li>&nbsp;</li>
                    <li><a href="/edit/{{ $recipe->name }}">Rediger oppskriften</a></li>
                </ul>
            </div>
        </div>

    </section>

    <section class="content-wrap content">
        <div>
            {!! $recipe->html !!}
        </div>
    </section>

    <style>
        .recipe-header {
            margin: 1em;
            border: 1px solid var(--primary);
            padding: 1em;
        }

        .recipe-header h1 {
            color: var(--primary);
            margin: 0;
            padding: 10px;
        }

        .recipe-infos ul {
            padding: 0;
        }

        .recipe-infos li {
            text-transform: uppercase;
            font-size: 0.8rem;
            list-style: none;
            line-height: 1.5em;
            color: var(--secondary);
        }

        .recipe-image img {
            display: inline-block;
            object-fit: cover;
            width: 100%;
            max-height: 350px;

            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.2);
        }

        .recipe-header, .recipe-infos { text-align: center; }
        @media only screen and (min-width: 768px) {
            .recipe-image img { height: 250px; }
            .recipe-header, .recipe-infos { text-align: left; }
            .recipe-header { margin-bottom: 2em; }
        }

        @media only screen and (min-width: 992px) {
            .recipe-image img { height: 300px; }
        }
    </style>
</x-layout>

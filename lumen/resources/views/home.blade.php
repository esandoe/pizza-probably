<x-layout>
    <section class="content-wrap content">
        <a href="/edit/untitled">Lag ny oppskrift!</a>
    </section>

    <section class="content-wrap content">
        <ul>
            @foreach ($recipes as $recipe)
                <li>
                    <a href="/recipe/{{$recipe['name']}}">{{$recipe['title']}}</a>
                </li>
            @endforeach
        </ul>
    </section>
</x-layout>

<x-layout>
    <x-slot name="pageTitle">
        - {{ $title }}
    </x-slot>

    <br>
    <section class="content-wrap">
        <a href="/edit/{{ $name }}">Rediger oppskriften</a>
    </section>

    <section class="content-wrap content">
        <h1>{{ $title }}</h1>

        <div>
            {!! $content !!}
        </div>
    </section>
</x-layout>

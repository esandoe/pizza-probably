<x-layout>
    <section class="content-wrap content">
        <form method="post">
            <label>
                Tittel på oppskrift:
                <input type="text" name="title" value="{{ $title }}">
            </label>

            <label>
                Innhold:
                <textarea id="editor-content" class="bg-light" name="content">{{ $content }}</textarea>
            </label>

            <button type="submit" class="bg-primary text-light">Lagre</button>
        </form>
    </section>

    <style>
        button, input, textarea {
            display: block;
            margin-bottom: 1em;
        }

        input {
            padding: .4em;
            width: 250px;
            border: 1px solid darkgray;
            resize: none;
            white-space:pre-wrap;
            word-wrap: break-word;
            line-height: 1.25em;
            border-radius: 0;
        }

        textarea {
            padding: .4em;
            width:100%;
            height: 500px;
            border: 1px solid darkgray;
            resize: none;
            white-space:pre-wrap;
            word-wrap: break-word;
            line-height: 1.25em;
            border-radius: 0;
        }
    </style>
</x-layout>

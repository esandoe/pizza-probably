<x-layout>
    <section class="content-wrap content">
        <form method="post">
            <label>
                @if (isset($errors) and count($errors) > 0)
                    <ul>
                    @foreach ($errors as $error)
                        <li style="color: red">{!! $error !!}</li>
                    @endforeach
                    </ul>
                @endif
                Innhold:
                <textarea id="editor-content" class="bg-light" name="content">{{ $content }}</textarea>
            </label>

            <button type="submit" class="bg-primary text-light">Lagre</button>
        </form>

        <h3>Tilgjengelige bilder</h3>
        <p>
            Klikk eller dra et bilde til feltet under for å legge til. Trykk på et bilde for å kopiere lenke eller slett.
        </p>

        <div id="drop-area">
            <form>
                <label id="image-previews-container" for="fileElem">
                    <input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
                </label>
            </form>
        </div>
    </section>

    <template id="img-template">
        <div class="image-upload-preview" data-clipboard-value="" data-image="">
            <img src="" alt="">
            <div class="text-overlay" data-click-text="kopiert!">trykk for å kopiere</div>
            <button class="image-upload-delete" title="slett">✖</button>
        </div>
    </template>

    @push('scripts')
        <script>
            function copyToClipBoard(text) {
                const tempInput = document.body.appendChild(document.createElement('input'));
                tempInput.value = text;
                tempInput.select();
                tempInput.setSelectionRange(0, 1000);
                document.execCommand("copy");
                tempInput.remove();
            }

            function setTextCopied(node) {
                const textNode = node.querySelector('.text-overlay')
                const oldText = textNode.textContent;
                textNode.textContent = textNode.dataset.clickText;

                node.classList.add('active');
                if (node.dataset.timeout)
                    clearTimeout(parseInt(node.dataset.timeout));

                const timeoutFunc = () => {
                    clearTimeout(parseInt(node.dataset.timeout));
                    node.classList.remove('active')
                    textNode.textContent = oldText;
                }

                node.dataset.timeout = setTimeout(timeoutFunc, 1000);
            }

            function deleteImage(node) {
                const image = node.dataset.image;
                const url = '/edit/{{ $id }}/images?image=' + encodeURI(image);

                fetch(url, {
                    method: 'DELETE',
                })
                    .then(async (response) => {
                        node.remove();
                    })
                    .catch((reason) => {
                        console.log(reason);
                    })
            }

            function setupEventListeners(node) {
                const clipboardValue = node.dataset.clipboardValue;
                node.addEventListener('click', (e) => {e.preventDefault();e.stopPropagation();})
                node.addEventListener('click', () => copyToClipBoard(clipboardValue));
                node.addEventListener('click', () => setTextCopied(node))

                const deleteButton = node.querySelector('.image-upload-delete');
                deleteButton.addEventListener('click', (e) => {e.preventDefault();e.stopPropagation();})
                deleteButton.addEventListener('click', () => deleteImage(node))
            }

            const imageContainer = document.querySelector('#image-previews-container');
            function addImage(url) {
                const template = document.querySelector('#img-template').content.cloneNode(true);
                const div = template.querySelector('.image-upload-preview')
                div.dataset.image = url;
                div.dataset.clipboardValue = url;
                div.querySelector('img').src = url;

                imageContainer.appendChild(template);
                setupEventListeners(div);
            }

            @json($images).forEach(imageUrl => addImage(imageUrl));
        </script>
    @endpush

    @push('styles')
        <style>
            #image-previews-container {
                min-height: 100px;
            }

            .image-upload-preview {
                position: relative;
                width: 100px;
                height: 100px;
                float: left;
                margin: .5rem;
                cursor: pointer;
            }

            .image-upload-preview img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform .2s, filter .2s;
            }

            .image-upload-preview:hover img,
            .image-upload-preview.active img {
                transform: scale(1.1);
                filter: brightness(0.25);
            }

            .image-upload-preview .text-overlay {
                position: absolute;
                margin: auto;
                top: 0; left: 0; right: 0; bottom: 0;
                width: 100%;
                text-align: center;
                height: 2rem;
                color: #fff;
                visibility: hidden;
            }

            .image-upload-preview .image-upload-delete {
                position: absolute;
                top: -0.75rem;
                right: -0.75rem;
                width: 1.5rem;
                height: 1.5rem;
                padding: 0;
                background: white;
                border: 1px solid;
                border-radius: 1.5rem;
                cursor: pointer;
                visibility: hidden;
            }

            .image-upload-preview .image-upload-delete:hover {
                color: red;
            }

            .image-upload-preview:hover .text-overlay,
            .image-upload-preview.active .text-overlay,
            .image-upload-preview:hover .image-upload-delete,
            .image-upload-preview.active .image-upload-delete
            {
                visibility: visible;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            let dropArea = document.getElementById('drop-area');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropArea.classList.add('highlight');
            }

            function unhighlight(e) {
                dropArea.classList.remove('highlight');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                let dt = e.dataTransfer;
                let files = dt.files;

                handleFiles(files);
            }

            function handleFiles(files) {
                ([...files]).forEach(uploadFile)
            }

            function htmlToElement(html) {
                var template = document.createElement('template');
                html = html.trim(); // Never return a text node of whitespace as the result
                template.innerHTML = html;
                return template.content.firstChild;
            }

            function uploadFile(file) {
                let url = '/edit/{{ $id }}/images'
                let formData = new FormData()

                formData.append('file', file)

                fetch(url, {
                    method: 'POST',
                    body: formData
                })
                    .then(async (response) => {
                        const data = await response.json();
                        if (data.url)
                            addImage(data.url);
                    })
                    .catch((reason) => {
                        console.log(reason);
                    })
            }
        </script>
    @endpush

    @push('styles')
        <style>
            #drop-area {
                border: 2px dashed var(--bg-dark);
                box-sizing: border-box;
                width: 100%;
                border-radius: 5px;
                display: inline-block;
                font-family: sans-serif;
                background: var(--bg-light);
            }

            #drop-area.highlight, #drop-area:hover {
                border-color: var(--primary);
                background: var(--text-light);
            }

            #drop-area form {
                margin: 0;
            }

            #drop-area label[for=fileElem] {
                position: relative;
                padding: 25px;
                display: block;
                overflow: hidden;
                cursor: pointer;
            }

            #fileElem {
                display: none;
            }

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
    @endpush
</x-layout>

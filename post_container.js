function handleFileSelect(event) {
    var files = event.target.files;
    var container = document.getElementById('preview-container');

    container.innerHTML = '';

    if (files.length === 0) {
        container.style.overflowY = 'hidden';
        return;
    }

    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        reader.onload = function (e) {
            var image = document.createElement('img');
            image.className = 'preview-image';
            image.src = e.target.result;
            container.appendChild(image);
        };

        reader.readAsDataURL(file);
    }

    container.style.overflowY = container.scrollHeight > container.clientHeight ? 'scroll' : 'hidden';
}

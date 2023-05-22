document.addEventListener("DOMContentLoaded", () => {
    const selectedFilesContainer = document.getElementById("selected-files");
    const uploadButton = document.getElementById("upload-button");
    const deleteFilesButton = document.getElementById("delete-files-button");
    const fileInput = document.getElementById("file-input");

    function viewFile(event) {
        const files = event.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileURL = URL.createObjectURL(file);
            const fileType = file.type.split("/")[0];

            if (fileType === "image") {
                const imgElement = document.createElement("img");
                imgElement.src = fileURL;
                selectedFilesContainer.appendChild(imgElement);
            } else if (fileType === "video") {
                const videoElement = document.createElement("video");
                videoElement.src = fileURL;
                videoElement.controls = true;
                selectedFilesContainer.appendChild(videoElement);
            }
        }
    }

    function uploadFiles() {
        const files = fileInput.files;
        viewFile({ target: { files: files } });
    }

    function deleteFiles() {
        selectedFilesContainer.innerHTML = "";
        fileInput.value = null;
    }

    uploadButton.addEventListener("click", uploadFiles);
    deleteFilesButton.addEventListener("click", deleteFiles);
    fileInput.addEventListener("change", viewFile);
});

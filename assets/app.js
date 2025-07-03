import './bootstrap.js';
import './styles/app.css';

const fileSelectors = document.querySelectorAll('.file-selector-container')


fileSelectors.forEach(fileSelector => {
    const rowID = fileSelector.dataset.rowId
    const fileSelectorInput = document.querySelector(`.file-selector-input[data-row-id="${rowID}"]`)
    fileSelector.onclick = () => fileSelectorInput.click();

    fileSelectorInput.onchange = () => {
        [...fileSelectorInput.files].forEach((file) => {
            if(typeValidation(file.type)) {
                console.log(file)
                console.log("/api/formations/"+rowID)
                uploadFile(file, "/api/formations/"+rowID);
            }
        })
    }

    fileSelector.ondragover = (e) => {
        e.preventdefault();
        [...e.dataTransfer.items].forEach((item) => {
            if (typeValidation(item.type)) {
                fileSelector.classList.add(".file-selector-drag-over")
            }
        })
    }

    fileSelector.ondragleave = () => {
        fileSelector.classList.remove("file-selector-drag-over")
    }

    fileSelector.ondrop = (e) => {
        e.preventdefault();
        fileSelector.classList.remove("file-selector-drag-over")
        if (e.dataTransfer.items) {
            [...e.dataTransfer.items].forEach((item) => {
                if (item.kind === "file") {
                    const file = item.getAsFile();
                    if (typeValidation(file.type)) {
                        uploadFile(file, "/api/formations/image")
                    }
                }
            })
        } else {
            [...e.dataTransfer.files].forEach((file) => {
                if (typeValidation(file.type)) {
                    uploadFile(file, "/api/formations/image")
                }
            })
        }
    }
})




function typeValidation(type) {
    var splitType = type.split('/')[0]
    if (splitType == "image") {
        return true
    }
}



function uploadFile(file, endpoint) {
    var data = new FormData()
    data.append('file', file)

    fetch(endpoint, {
        method: 'POST',
        body: data
    })
}

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
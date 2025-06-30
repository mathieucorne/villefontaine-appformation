import './bootstrap.js';
import './styles/app.css';

const fileSelector = document.querySelector('.file-selector-container')
const fileSelectorInput = document.querySelector('.file-selector-input')

fileSelector.onclick = () => fileSelectorInput.click();
fileSelectorInput.onchange = () => {
    [...fileSelectorInput.files].forEach((file) => {
        if(typeValidation(file.type)) {
            console.log(file)
        }
    })
}

function typeValidation(type) {
    var splitType = type.split('/')[0]
    if (splitType == "image") {
        return true
    }
}

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
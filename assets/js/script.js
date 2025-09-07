$(document).ready(function() {
    // Drop area functionality
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');

    if (dropArea) {
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);

        // Open file selector when drop area is clicked
        dropArea.addEventListener('click', () => {
            fileInput.click();
        });
    }

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        dropArea.classList.add('highlight');
    }

    function unhighlight() {
        dropArea.classList.remove('highlight');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length) {
            fileInput.files = files;
            handleFiles(files);
        }
    }

    function handleFiles(files) {
        if (files.length) {
            const file = files[0];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function() {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    img.className = 'img-thumbnail';
                    img.style.maxWidth = '200px';
                    imagePreview.innerHTML = '';
                    imagePreview.appendChild(img);
                }
            } else {
                alert('Please drop an image file');
            }
        }
    }

    // Handle file input change
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });
    }
});
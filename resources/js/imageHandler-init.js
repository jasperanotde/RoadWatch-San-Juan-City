    // Get references to the input field and image previews container
    var imageInput = document.getElementById('photo');
    var imagePreviews = document.getElementById('photoPreviews');
    var selectedImagesContainer = document.getElementById('selectedImagesContainer');

    // Add an event listener to the input field
    imageInput.addEventListener('change', function () {
        // Clear any existing image previews
        imagePreviews.innerHTML = '';
        imagePreviews.classList.add('flex', 'items-center', 'place-justify-center');

        // Create a Fancybox gallery
        var galleryId = 'gallery-' + Math.random(); // Generate a unique gallery ID
        var galleryItems = [];

        // Check if files are selected
        if (imageInput.files.length > 0) {
            selectedImagesContainer.removeAttribute('hidden'); // Show the container
        } else {
            selectedImagesContainer.setAttribute('hidden', 'true'); // Hide the container
        }

        // Loop through selected files
        for (var i = 0; i < imageInput.files.length; i++) {
            (function (file) { // Use an IIFE to capture the current file
                if (file) {
                    var reader = new FileReader();

                    // Create a new image element for the preview
                    var previewImage = document.createElement('a'); // Wrap the image in an anchor
                    previewImage.classList.add('mr-4');
                    var image = document.createElement('img');
                    image.style.maxWidth = '100px'; // Set maximum width for the preview
                    image.style.maxHeight = '100px'; // Set maximum height for the preview
                    image.classList.add('rounded-lg', 'border-solid', 'border-2', 'border-primary');
                    
  
                    // Set up the reader to load when the file is loaded
                    reader.onload = function (e) {
                        // Display the image preview
                        image.src = e.target.result;

                        // Add the image to the Fancybox gallery
                        var galleryItem = {
                            src: e.target.result,
                            opts: {
                                caption: 'Image ' + (i + 1) // Add a caption for each image
                            }
                        };
                        galleryItems.push(galleryItem);

                        // Set Fancybox attributes
                        previewImage.href = e.target.result; // Set the href attribute for the anchor
                        previewImage.setAttribute('data-fancybox', galleryId); // Set Fancybox attribute

                        previewImage.appendChild(image); // Append the image to the anchor
                        imagePreviews.appendChild(previewImage); // Append the anchor to the container
                    };

                    // Read the current file as a data URL
                    reader.readAsDataURL(file);
                }
            })(imageInput.files[i]);
        }

        // Initialize Fancybox for the gallery
        $('[data-fancybox="' + galleryId + '"]').fancybox({
            loop: true, // Enable looping through images
            // Add any additional Fancybox options here
        });
    });
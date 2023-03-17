const apiKeyInput = document.getElementById('api-key');
const modelSelect = document.getElementById('model');
const promptInput = document.getElementById('prompt');
const numImagesSelect = document.getElementById('num-images');
const generateBtn = document.getElementById('generate');
const carousel = document.getElementById('carousel');

generateBtn.addEventListener('click', async () => {
    const apiKey = apiKeyInput.value;
    const model = modelSelect.value;
    const prompt = promptInput.value;
    const numImages = numImagesSelect.value;

    if (!apiKey || !prompt) {
        alert('API key and prompt are required');
        return;
    }

    const images = await generateImages(apiKey, model, prompt, numImages);
    displayImages(carousel, images);
});

async function generateImages(apiKey, model, prompt, numImages) {
    // Create the inference request
    const createResponse = await fetch(`https://api.tryleap.ai/api/v1/images/models/${model}/inferences`, {
        method: 'POST',
        headers: {
            'accept': "application/json",
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${apiKey}`,
        },
        body: JSON.stringify({
            prompt,
            numberOfImages: numImages,
            width: 512,
            height: 512,
            steps: 50,
        }),
    });

    if (!createResponse.ok) {
        console.error('Error creating inference request:', createResponse.statusText);
        const errorBody = await createResponse.text();
        console.error('Error response body:', errorBody); // Log the error response body
        alert('An error occurred while creating the inference request');
        return;
    }

    const createData = await createResponse.json();
    const inferenceId = createData.id;

    // Poll the API for the inference result
    const pollInterval = 3000; // Poll every 3 seconds
    let images;

    do {
        await new Promise(resolve => setTimeout(resolve, pollInterval));

        const checkResponse = await fetch(`https://api.tryleap.ai/api/v1/images/models/${model}/inferences/${inferenceId}`, {
            headers: {
                'Authorization': `Bearer ${apiKey}`,
            },
        });

        if (!checkResponse.ok) {
            console.error('Error checking inference status:', checkResponse.statusText);
            alert('An error occurred while checking the inference status');
            return;
        }

        const checkData = await checkResponse.json();
        images = checkData.images;

    } while (!images);

    return images;
}

function displayImages(carousel, images) {
    const carouselInner = carousel.querySelector('.carousel-inner');
    carouselInner.innerHTML = '';

    images.forEach((image, index) => {
        const item = document.createElement('div');
        item.classList.add('carousel-item');
        if (index === 0) {
            item.classList.add('active');
        }

        const img = document.createElement('img');
        img.src = image;
        img.classList.add('d-block', 'w-100');
        img.addEventListener('click', () => {
            downloadImage(image);
        });

        item.appendChild(img);
        carouselInner.appendChild(item);
    });

    // Update carousel after adding new items
    const carouselInstance = new bootstrap.Carousel(carousel);
    carouselInstance.cycle();
}

function downloadImage(image) {
    const link = document.createElement('a');
    link.href = image;
    link.download = 'generated-image.png';
    link.click();
}

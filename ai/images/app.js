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
            steps: 50,
            width: 512,
            height: 512,
            numberOfImages: 2,
            promptStrength: 15,
            seed: 4523184,
            enhancePrompt: false
        }),
    });

    const createData = await createResponse.json();

    if (!createData || createData.status !== 'queued') {
        const errorBody = await createResponse.text();
        console.error('Error response body:', errorBody); // Log the error response body
        console.table(createData);
        alert('An error occurred while creating the inference request');
        return;
    }

    const inferenceId = createData.id;

    // Poll the API for the inference result
    const pollInterval = 3000; // Poll every 3 seconds
    let images;

    do {
        await new Promise(resolve => setTimeout(resolve, pollInterval));

        const checkResponse = await fetch(`https://api.tryleap.ai/api/v1/images/models/${model}/inferences/${inferenceId}`, {
            method: 'GET',
            headers: {
                accept: 'application/json',
                'Authorization': `Bearer ${apiKey}`,
            },
        });

        if (!checkResponse.ok) {
            console.error('Error checking inference status:', checkResponse.statusText);
            alert('An error occurred while checking the inference status');
            return;
        }

        const checkData = await checkResponse.json();
        if (checkData.images && checkData.images.length > 0) {
            images = checkData.images;
        }

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
        img.src = image.uri;
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
    link.href = image.uri;
    link.download = `generated-image-${image.id}.png`;
    link.click();
}

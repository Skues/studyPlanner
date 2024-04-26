
const progressBar = document.querySelector('.progress');
const percentElement = document.querySelector('.percent');

// Function to update the progress bar
function updateProgressBar(completionPercentage) {
    const progressWidth = (completionPercentage < 0) ? 0 : (completionPercentage > 100) ? 100 : completionPercentage;
    progressBar.style.width = `${progressWidth}%`;
    percentElement.textContent = `${progressWidth}%`;
}

// Initial completion percentage
let completionPercentage = 57;
updateProgressBar(completionPercentage);



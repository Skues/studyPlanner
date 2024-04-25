
const progressBar = document.querySelector('.progress');
const percentElement = document.querySelector('.percent');

//set the initial completion percentage (change this value as needed, later we will adjust it to take a value from the agenda as that's wher we edit progress)
let completionPercentage = 75;

//update the progress bar width and percent text
function updateProgressBar() {
    const progressWidth = (completionPercentage < 0) ? 0 : (completionPercentage > 100) ? 100 : completionPercentage;
    progressBar.style.width = `${progressWidth}%`;
    percentElement.textContent = `${progressWidth}%`;
}

updateProgressBar();


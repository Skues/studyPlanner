let allDataSets = [];


// Fetch and process the data from the database
function fetchDataFromDatabase() {
    return fetch('jsonget.php')
        .then(response => response.json())
        .then(data => handleDatabaseData(data))
        .catch(error => console.error('Error fetching data:', error));
}

// Handle the data fetched from the database
function handleDatabaseData(filesArray) {
    console.log(filesArray[0]);
    const modules = filesArray[0].modules;

    // Use Promise.all to wait for all createDataSet promises to resolve
    Promise.all(modules.map(module => createDataSet(module)))
        .then(() => {
            logAllTaskInformation();
            findEarliestAndLatestDates();
            addListElementsWithDateRange(".chart-values"); // Add list elements
            createChart(); // Ensure createChart is called after list elements are added
        })
        .catch(error => console.error('Error processing modules:', error));
}

// Create datasets for each module and their coursework
function createDataSet(module) {
    return new Promise((resolve, reject) => {
        const courseworkPromises = module.coursework.map(coursework => {
            return fetch("gettask.php")
                .then(response => response.json())
                .then(data => {
                    let taskArray = data.filter(task =>
                        task.module_code === module.module_code && task.cw_name === coursework.name
                    ).map(task => ({
                        name: task.task_name,
                        notes: task.notes,
                        task_end: task.task_end,
                        task_start: task.task_start,
                        requirement: task.requirement
                    }));

                    const dataSet = {
                        name: coursework.name,
                        moduleCode: module.module_code,
                        moduleName: module.module_name,
                        tasks: taskArray
                    };
                    allDataSets.push(dataSet);
                });
        });

        Promise.all(courseworkPromises)
            .then(() => resolve())
            .catch(error => reject(error));
    });
}

function findEarliestAndLatestDates() {
    let earliestDate = new Date();
    let latestDate = new Date(0);

    allDataSets.forEach(dataSet => {
        dataSet.tasks.forEach(task => {
            const taskStartDate = new Date(task.task_start);
            const taskEndDate = new Date(task.task_end);

            if (taskStartDate < earliestDate) {
                earliestDate = taskStartDate;
            }

            if (taskEndDate > latestDate) {
                latestDate = taskEndDate;
            }
        });
    });

    console.log('Earliest Date:', earliestDate.toISOString().split('T')[0]);
    console.log('Latest Date:', latestDate.toISOString().split('T')[0]);

    return { earliestDate, latestDate };
}

// Log all task information
function logAllTaskInformation() {
    const chartUl = document.querySelector(".chart-bars");
    chartUl.innerHTML = ''; // Clear existing elements

    allDataSets.forEach((dataSet, index) => {
        console.log(`DataSet ${index + 1}:`, dataSet);
        console.log(`Tasks for DataSet ${index + 1}:`, dataSet.tasks);

        dataSet.tasks.forEach(task => {
            console.log(task);
            const newEntry = document.createElement("li");
            newEntry.setAttribute('data-start', task.task_start);
            newEntry.setAttribute('data-end', task.task_end);
            newEntry.setAttribute('data-color', '#da6f2b');

            newEntry.textContent = task.name;
            chartUl.appendChild(newEntry);
        });
    });
}

// Create and style the chart
function createChart() {
    const days = document.querySelectorAll(".chart-values li");
    const tasks = document.querySelectorAll(".chart-bars li");
    const daysArray = [...days];

    tasks.forEach(el => {
        const startDate = new Date(el.dataset.start);
        const endDate = new Date(el.dataset.end);
        let left = 0,
            width = 0;

        const startIndex = Array.from(days).findIndex(day => day.textContent === startDate.toISOString().split('T')[0]);
        const endIndex = Array.from(days).findIndex(day => day.textContent === endDate.toISOString().split('T')[0]);

        const dayWidth = daysArray[1].offsetLeft - daysArray[0].offsetLeft;
        left = startIndex * dayWidth;
        width = (endIndex - startIndex + 1) * dayWidth;

        el.style.left = `${left}px`;
        el.style.width = `${width}px`;
        el.style.backgroundColor = el.dataset.color;
        el.style.opacity = 1; // Ensure this gets applied when the page loads
    });
}

// Function to add list elements with date range
function addListElementsWithDateRange(ulSelector) {
    const chartUl = document.querySelector(ulSelector);
    if (!chartUl) {
        console.error(`Element with selector ${ulSelector} not found.`);
        return;
    }

    // Find the earliest and latest dates
    const { earliestDate, latestDate } = findEarliestAndLatestDates();

    // Loop through dates from the earliest to the latest
    const currentDate = new Date(earliestDate);
    while (currentDate <= latestDate) {
        const newEntry = document.createElement("li");
        newEntry.textContent = currentDate.toISOString().split('T')[0];
        chartUl.appendChild(newEntry);

        currentDate.setDate(currentDate.getDate() + 1);
    }

    console.log(`Added elements to ${ulSelector}`);
}

// Initialize the process
document.addEventListener('DOMContentLoaded', handleFileFromDatabase);
window.addEventListener("resize", createChart);

// Fetch and process the data
function handleFileFromDatabase() {
    fetchDataFromDatabase();
}

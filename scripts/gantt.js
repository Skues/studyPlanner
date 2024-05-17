let allDataSets = [];


function fetchDataFromDatabase() {
    return fetch('jsonget.php')
        .then(response => response.json())
        .then(data => handleDatabaseData(data))
        .catch(error => console.error('Error fetching data:', error));
}

function handleDatabaseData(filesArray) {
    const modules = filesArray[0].modules;

    
    Promise.all(modules.map(module => createDataSet(module)))
        .then(() => {
            processAllTaskInformation();
            findEarliestAndLatestDates();
            addListElementsWithDateRange(".chart-values"); 
            createChart(); 
        })
        .catch(error => console.error('Error processing modules:', error));
}


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

 

    return { earliestDate, latestDate };
}


function processAllTaskInformation() {
    const chartUl = document.querySelector(".chart-bars");
    chartUl.innerHTML = ''; 

    allDataSets.forEach((dataSet, index) => {
    
        dataSet.tasks.forEach(task => {
            console.log(task);
            const newEntry = document.createElement("li");
            newEntry.setAttribute('data-start', task.task_start);
            newEntry.setAttribute('data-end', task.task_end);
            newEntry.setAttribute('data-color', '#007bff');

            newEntry.textContent = task.name;
            chartUl.appendChild(newEntry);
        });
    });
}

/* https://webdesign.tutsplus.com/build-a-simple-gantt-chart-with-css-and-javascript--cms-33813t */
function createChart() {
    const days = document.querySelectorAll(".chart-values li");
    const tasks = document.querySelectorAll(".chart-bars li");
    const daysArray = [...days];

    tasks.forEach(task => {
        const startDate = new Date(task.dataset.start);
        const endDate = new Date(task.dataset.end);
        let left = 0,
            width = 0;

        const startIndex = Array.from(days).findIndex(day => day.textContent === startDate.toISOString().split('T')[0]);
        const endIndex = Array.from(days).findIndex(day => day.textContent === endDate.toISOString().split('T')[0]);

        const dayWidth = daysArray[1].offsetLeft - daysArray[0].offsetLeft;
        left = startIndex * dayWidth;
        width = (endIndex - startIndex + 1) * dayWidth;

        task.style.left = `${left}px`;
        task.style.width = `${width}px`;
        task.style.backgroundColor = task.dataset.color;
        task.style.opacity = 1; 
    });
}

function addListElementsWithDateRange(ulSelector) {
    const chartUl = document.querySelector(ulSelector);
    if (!chartUl) {
        console.error(`Element with selector ${ulSelector} not found.`);
        return;
    }

    const { earliestDate, latestDate } = findEarliestAndLatestDates();

    const currentDate = new Date(earliestDate);
    while (currentDate <= latestDate) {
        const newEntry = document.createElement("li");
        newEntry.textContent = currentDate.toISOString().split('T')[0];
        chartUl.appendChild(newEntry);

        currentDate.setDate(currentDate.getDate() + 1);
    }

}

document.addEventListener('DOMContentLoaded', fetchDataFromDatabase);
window.addEventListener("resize", createChart);



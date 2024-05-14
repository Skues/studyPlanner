let uploadedFiles = [];
let allDeadlines = [];


function handleDatabaseData(filesArray) {
    filesArray.forEach(files => {
        let upcomingDeadlines = [];
        let pastDeadlines = [];
        console.log("this is files: ", files.modules);
        console.log("this is files length: ", files.modules.length);

        for (let i = 0; i < files.modules.length; i++) {
            const module = files.modules[i];
            console.log("this is module: ", module);
            console.log("this is module: ", module.module_name);
            console.log("this is module: ", module.module_code);
        }
        extractDeadlines(files.modules, upcomingDeadlines, pastDeadlines);
        displayModules(files.modules, files.module_name);
        allDeadlines = allDeadlines.concat(upcomingDeadlines, pastDeadlines);
    });

    sortDeadlines();
    displayDeadlines();
}

function fetchDataFromDatabase() {
    return fetch('jsonget.php')
        .then(response => response.json())
        .then(data => handleDatabaseData(data))
        .catch(error => console.error('Error fetching data:', error));
}

function handleFileFromDatabase() {
    fetchDataFromDatabase();
}

function extractDeadlines(modules, upcomingDeadlines, pastDeadlines) {
    const currentDate = new Date();
    console.log(modules);
    modules.forEach(module => {
        module.coursework.forEach(coursework => {
            const deadlineDate = new Date(coursework.deadline);
            const deadline = {
                name: coursework.name,
                deadline: deadlineDate,
                moduleCode: module.module_code,
                moduleName: module.module_name,
                tasks: coursework.tasks
            };
            if (deadlineDate > currentDate) {
                upcomingDeadlines.push(deadline);
            } else {
                pastDeadlines.push(deadline);
            }
        });
    });
}

function sortDeadlines() {
    allDeadlines.sort((a, b) => a.deadline - b.deadline);
}

function displayDeadlines() {
    const upcomingDeadlinesContainer = document.querySelector('.upcoming-deadlines');
    const pastDeadlinesContainer = document.querySelector('.past-deadlines');

    upcomingDeadlinesContainer.innerHTML = '';
    pastDeadlinesContainer.innerHTML = '';

    allDeadlines.forEach(deadline => {
        const deadlineItem = document.createElement('div');
        const viewTasksButton = document.createElement('button');
        viewTasksButton.textContent = 'View Tasks';
        viewTasksButton.classList.add('view-tasks-button');
        viewTasksButton.onclick = function() {
            showTasks(deadline.tasks, deadlineItem);
        };
        deadlineItem.innerHTML = `<span class="module-content">${deadline.moduleCode} - ${deadline.moduleName} - ${deadline.name}: Deadline ${deadline.deadline.toDateString()}</span>`;

        deadlineItem.appendChild(viewTasksButton);
        const tasksList = document.createElement('ul');
        if (deadline.deadline > new Date()) {
            upcomingDeadlinesContainer.appendChild(deadlineItem);
        } else {
            pastDeadlinesContainer.appendChild(deadlineItem);
        }
        deadlineItem.appendChild(tasksList);
    });
}

function showTasks(tasks, deadlineItem) {
    const tasksList = deadlineItem.querySelector('ul');
    tasksList.innerHTML = '';

    let completedTasks = 0;
    let totalTasks = tasks ? tasks.length : 0;

    if (tasks && tasks.length > 0) {
        let progressBar = deadlineItem.querySelector('.progress-bar');
        if (!progressBar) {
            const progress = document.createElement('div');
            progress.classList.add('progress');
            progressBar = document.createElement('div');
            progressBar.classList.add('progress-bar');
            progressBar.setAttribute('role', 'progressbar');
            progress.appendChild(progressBar);
            deadlineItem.appendChild(progress);
        }

        tasks.forEach(task => {
            const taskItem = document.createElement('li');
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    completedTasks++;
                } else {
                    completedTasks--;
                }
                updateProgressBar(progressBar, completedTasks, totalTasks);
            });
            const label = document.createElement('label');
            label.textContent = task;
            taskItem.appendChild(checkbox);
            taskItem.appendChild(label);
            tasksList.appendChild(taskItem);
        });

        updateProgressBar(progressBar, completedTasks, totalTasks);
    } else {
        const noTasksMessage = document.createElement('li');
        noTasksMessage.textContent = 'No tasks available for this deadline.';
        tasksList.appendChild(noTasksMessage);
    }
}

function updateProgressBar(progressBar, completedTasks, totalTasks) {
    const percentage = (completedTasks / totalTasks) * 100;
    progressBar.style.width = percentage + '%';
    progressBar.setAttribute('aria-valuenow', percentage);
    progressBar.textContent = Math.round(percentage) + '%';
}

function toggleContent() {
    this.classList.toggle('active');
    const content = this.nextElementSibling;
    if (content.style.display === "block") {
        content.style.display = "none";
    } else {
        content.style.display = "block";
    }
}

function displayModules(modules, fileName) {
    const moduleList = document.getElementById('moduleList');

    modules.forEach(module => {
        const moduleItem = document.createElement('div');
        moduleItem.innerHTML = `<button class="collapsible">${module.module_code} - ${module.module_name}</button>`;
        
        const courseworkList = document.createElement('div');
        courseworkList.classList.add('content');

        module.coursework.forEach(coursework => {
            const courseworkItem = document.createElement('p');
            courseworkItem.textContent = `${coursework.name}: Deadline ${coursework.deadline}`;
            courseworkList.appendChild(courseworkItem);
        });

        moduleItem.appendChild(courseworkList);
        moduleList.appendChild(moduleItem);
        
        moduleItem.querySelector('.collapsible').addEventListener('click', toggleContent);
    });
}

document.querySelector('.collapsible').addEventListener('click', toggleContent);
document.addEventListener('DOMContentLoaded', handleFileFromDatabase);

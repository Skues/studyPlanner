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


function extractDeadlines(modules, upcomingDeadlines, pastDeadlines) {
    const currentDate = new Date();
    console.log(modules);

    modules.forEach((module) => {
        module.coursework.forEach(coursework => {
            const deadlineDate = new Date(coursework.deadline);
            let taskArray = [];
            let taskNotesArray = [];
            console.log("b array print");
            fetch("gettask.php")
                .then(response => response.json())
                .then(data => {
                    console.log(data); 
                    console.log(coursework.name)
                    console.log(module.module_code)
                    for (let i = 0; i < data.length; i++){
                        if (data[i].module_code == module.module_code && data[i].cw_name == coursework.name){
                            taskArray.push({name : data[i].task_name, notes: data[i].notes , task_end: data[i].task_end , requirement: data[i].requirement});
                            
                        }
                    }

                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
            console.log("after array print");
            const deadline = {
                name: coursework.name,
                deadline: deadlineDate,
                moduleCode: module.module_code,
                moduleName: module.module_name,
                tasks: taskArray,
                // notes: taskNotesArray
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
        const tasksList = document.createElement('div');
        if (deadline.deadline > new Date()) {
            upcomingDeadlinesContainer.appendChild(deadlineItem);
        } else {
            pastDeadlinesContainer.appendChild(deadlineItem);
        }
        deadlineItem.appendChild(tasksList);
    });
}


function showTasks(tasks, deadlineItem) {
    const tasksList = deadlineItem.querySelector('div');
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
            const taskItem = document.createElement('div');
            taskItem.setAttribute("id", "task-container");
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
            const label = document.createElement('div');
            label.classList.add("taskdiv");
            label.textContent = task.name;
            label.appendChild(checkbox);
            taskItem.appendChild(label);
            tasksList.appendChild(taskItem);

            const infoWindow = document.createElement("div");
            infoWindow.classList.add("info-window");

            const infoWindowName = document.createElement("div");
            infoWindowName.classList.add("info-window-name");
            infoWindowName.textContent = task.name;
            infoWindow.appendChild(infoWindowName);

            const infoWindowEnd = document.createElement("div");
            infoWindowEnd.classList.add("info-window-end");
            infoWindowEnd.textContent = "Due: " + task.task_end;
            infoWindow.appendChild(infoWindowEnd);

            const infoWindowRequirement = document.createElement("div");
            infoWindowRequirement.classList.add("info-window-requirement");
            infoWindowRequirement.textContent = "Requirement: " + task.requirement;
            infoWindow.appendChild(infoWindowRequirement);

            const infoWindowNotes = document.createElement("div");
            infoWindowNotes.classList.add("info-window-notes");
            infoWindowNotes.textContent = "Notes: " + task.notes;
            infoWindow.appendChild(infoWindowNotes);
  
            taskItem.appendChild(infoWindow);
            

            taskItem.addEventListener("mouseover", () => {
                infoWindow.style.display = "block";
            });

            taskItem.addEventListener("mouseout", () => {
                infoWindow.style.display = "none";
            });
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

function showInfoWindow(listItem, info) {
    const infoWindow = listItem.querySelector(".info-window");
    infoWindow.style.display = "block";
    infoWindow.style.left = `${listItem.offsetWidth / 2 - infoWindow.offsetWidth / 2}px`;
    infoWindow.style.top = `${listItem.offsetHeight / 2 - infoWindow.offsetHeight / 2}px`;
}

function hideInfoWindow(listItem) {
    const infoWindow = listItem.querySelector(".info-window");
    infoWindow.style.display = "none";
}

// document.addEventListener('DOMContentLoaded', showTasks2);
document.addEventListener('DOMContentLoaded', fetchDataFromDatabase);
document.getElementsByClassName("tasklabel").onmouseover = function() {mouseOver()};
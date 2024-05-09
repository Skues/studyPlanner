let uploadedFiles = [];
let allDeadlines = [];

function handleFile(files) {
    let upcomingDeadlines = [];
    let pastDeadlines = [];

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (!uploadedFiles.includes(file.name)) {
            uploadedFiles.push(file.name);
            const reader = new FileReader();

            reader.onload = function(event) {
                const contents = event.target.result;
                const data = JSON.parse(contents);
                extractDeadlines(data.modules, upcomingDeadlines, pastDeadlines);
                displayModules(data.modules, file.name);
                allDeadlines = allDeadlines.concat(upcomingDeadlines, pastDeadlines);
                sortDeadlines();
                displayDeadlines();
            };

            reader.readAsText(file);
        } else {
            alert("File " + file.name + " has already been uploaded.");
        }
    }
}

function extractDeadlines(modules, upcomingDeadlines, pastDeadlines) {
    const currentDate = new Date();
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

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Calendar</title>
  <link rel="stylesheet" href="styles2.css">   

  <style>
    * {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
    }
    .ganttMenu {
      width: 100vw;
      height: 40px;
      background: #1A1A1A;
      color: rgba(54, 162, 235, 1);
    }
    .ganttMenu p {
      padding: 10px;
      font-size: 20px;
    }
    .ganttCard {
      width: 100vw;
      height: calc(100vh - 40px);
      background: rgba(54, 162, 235, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .ganttBox {
      width: 1250px;
      padding: 20px;
      border-radius: 20px;
      border: solid 3px rgba(54, 162, 235, 1);
      background: white;
    }
  </style>
</head>
<body>
  <div class="ganttMenu">
    <p>Calendar</p>
  </div>
  <div class="ganttCard">
    <div class="ganttBox">
      <canvas id="myChart"></canvas>
    </div>
  </div>
  <div class="inputs">
    <input type="text" id="label1" placeholder="Label 1">
    <input type="date" id="startDate1" placeholder="Start Date 1">
    <input type="date" id="endDate1" placeholder="End Date 1">
    <!-- Repeat the above inputs for other labels as needed -->
    <button onclick="updateChart()">Update Chart</button>
  </div>
  
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

  <script>
    // Get input values
    function getInputValues() {
      const labels = [];
      const dataValues = [];

      // Loop through input fields to get labels and date ranges
      for (let i = 1; i <= 7; i++) {
        const label = document.getElementById(`label${i}`).value;
        const startDate = document.getElementById(`startDate${i}`).value;
        const endDate = document.getElementById(`endDate${i}`).value;

        if (label && startDate && endDate) {
          labels.push(label);
          dataValues.push({ x: startDate, y: endDate });
        }
      }

      return { labels, dataValues };
    }

    // Update chart with new data
    function updateChart() {
      const { labels, dataValues } = getInputValues();

      // Update chart data with new labels and data
      myChart.data.labels = labels;
      myChart.data.datasets[0].data = dataValues;
      myChart.update();
    }

    //initialisation 
    const data = {
      labels: ['CW1', 'CW2', 'CW3', 'CW4', 'CW5', 'CW6', 'CW7'],
      datasets: [{
        label: 'Assignments',
        data: [
          ['2024-03-15', '2024-05-15'],
          ['2024-03-16', '2024-05-18'],
          ['2024-03-20', '2024-05-21'],
          ['2024-03-22', '2024-05-24'],
          ['2024-03-25', '2024-05-27'],
          // Here, we're repeating the above data structure, as per the user's inputs
        ],
        backgroundColor: [
          'rgba(255, 26, 104, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(0, 0, 0, 1)'
        ],
        borderColor: [
          'rgba(255, 26, 104, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(0, 0, 0, 1)'
        ],
        barPercentage: 0.5
      }]
    };

    // config 
    const config = {
      type: 'bar',
      data,
      options: {
        indexAxis: 'y',
        scales: {
          x: {
            min: '2024-03-15',
            type: 'time',
            time: {
              unit: 'day'
            }
          },
          y: {
            beginAtZero: true
          }
        }
      }
    };

    //render init block
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>
</body>
</html>

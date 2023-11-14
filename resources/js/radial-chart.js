// ApexCharts options and config
window.addEventListener("load", function () {
  // Show the loading indicator
  function showLoadingIndicator() {
    const loadingIndicator = document.getElementById('loading-indicator');
    loadingIndicator.classList.remove('hidden');
  }

  // Hide the loading indicator
  function hideLoadingIndicator() {
    const loadingIndicator = document.getElementById('loading-indicator');
    loadingIndicator.classList.add('hidden');
  }

  // Initialize the chart without data
  const chart = new ApexCharts(document.querySelector("#radial-chart"), getChartOptions([]));
  const radialChart = document.getElementById('radial-chart');
  const totalReportCounts = JSON.parse(radialChart.dataset.totalReportCounts);
  chart.render();

  function getFormattedDateRangeLabel(selectedDateRange) {
    switch (selectedDateRange) {
      case 'yesterday':
        return 'Yesterday';
      case 'today':
        return 'Today';
      case 'last_7_days':
        return 'Last 7 days';
      case 'last_30_days':
        return 'Last 30 days';
      case 'last_90_days':
        return 'Last 90 days';
      default:
        return '';
    }
  }

  // Define a function to fetch data based on the selected date range
  function fetchData(selectedDateRange) {
    showLoadingIndicator();

    axios.get('/reports/dashboard', {
      params: {
        date_range: selectedDateRange
      }
    })
      .then(function (response) {
        const chartData = response.data;
        const labelsAndCounts = Object.keys(chartData).map(status => ({
          label: status,
          count: chartData[status],
        }));

        // Update the content of the <dt> elements with the calculated counts
        document.getElementById('pending-count').textContent = (labelsAndCounts.find(item => item.label === 'PENDING') || { count: 0 }).count;
        document.getElementById('inprogress-count').textContent = (labelsAndCounts.find(item => item.label === 'INPROGRESS') || { count: 0 }).count;
        document.getElementById('finished-count').textContent = (labelsAndCounts.find(item => item.label === 'FINISHED') || { count: 0 }).count;
        document.getElementById('declined-count').textContent = (labelsAndCounts.find(item => item.label === 'DECLINED') || { count: 0 }).count;

        // Calculate the total number of completed tasks (you can adjust the label accordingly)
        const totalCompletedTasks = (labelsAndCounts.find(item => item.label === 'FINISHED') || { count: 0 }).count;

        // Calculate the total number of all tasks
        const totalCount = labelsAndCounts.reduce((total, item) => total + item.count, 0);

        // Calculate the average task completion rate
        const completionRate = (totalCompletedTasks / totalCount) * 100;

        // Update the content of the HTML element with the completion rate
        const completionRateElement = document.querySelector('#average-completion-rate');
        completionRateElement.textContent = `${completionRate.toFixed(2)}%`;

        // Update the heading based on the selectedDateRange
        const reportProgressHeading = document.querySelector('.report-progress-heading');
        reportProgressHeading.textContent = `Report Progress (${getFormattedDateRangeLabel(selectedDateRange)})`;

        // Update the chart data and render
        chart.updateOptions({
          labels: labelsAndCounts.map(item => {
            const percentage = totalReportCounts > 0 ? Math.round((item.count / totalReportCounts) * 100) : 0;
            return `${item.label} (${percentage}%)`;
          })
        });

        chart.updateSeries(labelsAndCounts.map(item => Math.round(totalReportCounts > 0 ? (item.count / totalReportCounts) * 100 : 0)));

        hideLoadingIndicator();
      })
      .catch(function (error) {
        console.error(error);
        hideLoadingIndicator();
      });
  }

  // Define the getChartOptions function in the same scope
  function getChartOptions(labelsAndCounts) {
    // Calculate the total count of reports
    const totalCount = labelsAndCounts.reduce((total, item) => total + item.count, 0);

    return {
      series: labelsAndCounts.map(item => {
        const count = item.count;
        return totalCount > 0 ? (count / totalCount) * 100 : 0; // Conditionally calculate percentage
      }),
      colors: ["#ea580c", "#2563eb", "#16a34a", "#dc2626"],
      chart: {
        height: "380px",
        width: "100%",
        type: "radialBar",
        sparkline: {
          enabled: true,
        },
      },
      plotOptions: {
        radialBar: {
          track: {
            background: '#E5E7EB',
          },
          dataLabels: {
            show: false,
          },
          hollow: {
            margin: 0,
            size: "32%",
          }
        },
      },
      grid: {
        show: false,
        strokeDashArray: 4,
        padding: {
          left: 2,
          right: 2,
          top: -23,
          bottom: -20,
        },
      },
      labels: labelsAndCounts.map(item => {
        const percentage = totalCount > 0 ? ((item.count / totalCount) * 100) : 0; // Conditionally calculate percentage
        return `${item.label} (${percentage}%)`;
      }),
      legend: {
        show: true,
        position: "bottom",
        fontFamily: "Inter, sans-serif",
      },
      tooltip: {
        enabled: true,
        x: {
          show: false,
        },
      },
      yaxis: {
        show: false,
        labels: {
          formatter: function (value) {
            return value + '%';
          }
        }
      }
    };
  }

  // Define a variable to store the selected date range
  let selectedDateRange = 'last_7_days'; // Default selected date range

  // Function to handle button click and update selectedDateRange
  function handleDateRangeButtonClick(event) {
    event.preventDefault();

    // Get the ID of the clicked button
    const buttonId = event.target.id;

    // Show the loading indicator
    showLoadingIndicator();

    // Update selectedDateRange based on the clicked button
    switch (buttonId) {
      case 'yesterday-button':
        selectedDateRange = 'yesterday';
        break;
      case 'today-button':
        selectedDateRange = 'today';
        break;
      case 'last-7-days-button':
        selectedDateRange = 'last_7_days';
        break;
      case 'last-30-days-button':
        selectedDateRange = 'last_30_days';
        break;
      case 'last-90-days-button':
        selectedDateRange = 'last_90_days';
        break;
      default:
        // Handle any other cases or set a default value
        break;
    }

    // Now, you can use the selectedDateRange in your Axios request or any other part of your code
    console.log('Selected Date Range:', selectedDateRange);

    // Simulate an Axios request (replace this with your actual Axios request)
    setTimeout(() => {
      // Hide the loading indicator when the data retrieval is complete
      hideLoadingIndicator();

      // Trigger the data retrieval with the updated selectedDateRange
      fetchData(selectedDateRange)

    }, 2000); // Simulated delay of 5 seconds (adjust as needed)
  }

  // Add event listeners to the date range buttons
  document.getElementById('yesterday-button').addEventListener('click', handleDateRangeButtonClick);
  document.getElementById('today-button').addEventListener('click', handleDateRangeButtonClick);
  document.getElementById('last-7-days-button').addEventListener('click', handleDateRangeButtonClick);
  document.getElementById('last-30-days-button').addEventListener('click', handleDateRangeButtonClick);
  document.getElementById('last-90-days-button').addEventListener('click', handleDateRangeButtonClick);

  // Initial data retrieval (you can use the default date range or any other initial value here)
  fetchData(selectedDateRange);

});

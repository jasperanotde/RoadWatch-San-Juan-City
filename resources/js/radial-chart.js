// ApexCharts options and config
window.addEventListener("load", function() {
  const getChartOptions = (labelsAndCounts) => {
      // Calculate the total count of reports
      const totalCount = labelsAndCounts.reduce((total, item) => total + item.count, 0);

      return {
          series: labelsAndCounts.map(item => (item.count / totalCount) * 100), // Calculate percentage
          colors: ["#1C64F2", "#16BDCA", "#FDBA8C", "#FDBA8C"],
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
          labels: labelsAndCounts.map(item => `${item.label} (${((item.count / totalCount) * 100).toFixed(2)}%)`), // Include percentage in labels
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

  if (document.getElementById("radial-chart") && typeof ApexCharts !== 'undefined') {
      axios.get('/reports/dashboard')
          .then(function(response) {
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

              var chart = new ApexCharts(document.querySelector("#radial-chart"), getChartOptions(labelsAndCounts));
              chart.render();
          })
          .catch(function(error) {
              console.error(error);
          });
  }
});

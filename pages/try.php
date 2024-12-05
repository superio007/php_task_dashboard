<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Region Data Pie Chart</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Region Data Visualization</h1>
    <label for="year">Enter Year:</label>
    <input type="number" id="year" placeholder="Enter a year" />
    <button id="fetchData">Fetch Data</button>

    <canvas id="regionPieChart" width="400" height="400"></canvas>

    <script>
        function fetchRegionData(year) {
            // Validate the year
            if (!year) {
                alert('Please enter a valid year.');
                return;
            }

            // Perform AJAX call
            $.ajax({
                url: 'retriveRegions.php', // Replace with your PHP script's path
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ year: year }), // Send data as JSON
                success: function (response) {
                    try {
                        const data = JSON.parse(response); // Parse the JSON response
                        if (data.status === 'success') {
                            const labels = [];
                            const values = [];

                            // Extract labels and values for the pie chart
                            for (const [region, count] of Object.entries(data.regionCounts)) {
                                labels.push(region); // Add region name
                                values.push(count); // Add count
                            }

                            // Render the pie chart
                            renderPieChart('regionPieChart', labels, values);
                        } else {
                            alert(`Error: ${data.message}`);
                        }
                    } catch (error) {
                        alert('An error occurred while parsing the response.');
                    }
                },
                error: function (xhr, status, error) {
                    alert(`An error occurred: ${error}`);
                }
            });
        }

        // Function to render a pie chart
        function renderPieChart(canvasId, labels, data) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels, // Regions
                    datasets: [{
                        label: 'Region Distribution',
                        data: data, // Counts
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', 
                            '#FF9F40', '#8B0000', '#4682B4', '#7CFC00', '#FFA07A', 
                            '#00CED1', '#9400D3', '#FFD700', '#DC143C', '#20B2AA', 
                            '#808000', '#DAA520', '#8A2BE2', '#5F9EA0'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    const label = tooltipItem.label || '';
                                    const value = tooltipItem.raw || 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Attach event listener
        $(document).ready(function () {
            $('#fetchData').click(function () {
                const year = $('#year').val(); // Get the year from the input
                fetchRegionData(year); // Call the function
            });
        });
    </script>
</body>
</html>

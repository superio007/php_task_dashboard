<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Line Charts with D3.js</title>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <style>
        /* Ensure the SVG container resizes properly */
        .chart-container {
            width: 100px; /* Make the container responsive */
            height: 200px; /* Default height for the chart container */
        }

        svg {
            width: 100px; /* SVG takes full width of container */
            height: 100%; /* SVG takes full height of container */
        }
    </style>
</head>

<body>
    <div class="chart-container">
        <svg id="chart-line-1"></svg>
    </div>
    <div class="chart-container">
        <svg id="chart-line-2"></svg>
    </div>

    <script>
        function renderLineChart(chartId, data, labels) {
            const container = document.getElementById(chartId);
            const containerWidth = container.offsetWidth; // Dynamically get the container width
            const containerHeight = container.offsetHeight || 200; // Default height if not set
            console.log(containerHeight);
            console.log(containerWidth);
            const margin = { top: 20, right: 20, bottom: 30, left: 40 };
            const width = containerWidth - margin.left - margin.right;
            const height = containerHeight - margin.top - margin.bottom;

            // Remove any existing SVG content to avoid overlap
            d3.select(`#${chartId}`).selectAll("*").remove();

            const svg = d3.select(`#${chartId}`)
                .attr("width", containerWidth)
                .attr("height", containerHeight);

            const g = svg.append("g").attr("transform", `translate(${margin.left},${margin.top})`);

            // Define the scales
            const x = d3.scalePoint()
                .domain(labels)
                .range([0, width]);

            const y = d3.scaleLinear()
                .domain([0, d3.max(data)])
                .range([height, 0]);

            // Define the line generator
            const line = d3.line()
                .x((_, i) => x(labels[i]))
                .y(d => y(d))
                .curve(d3.curveMonotoneX); // Smooth the line

            // Add X-axis
            g.append("g")
                .attr("transform", `translate(0,${height})`)
                .call(d3.axisBottom(x));

            // Add Y-axis
            g.append("g")
                .call(d3.axisLeft(y));

            // Add the line path
            g.append("path")
                .datum(data)
                .attr("fill", "none")
                .attr("stroke", "green")
                .attr("stroke-width", 2)
                .attr("d", line);

            // Add data points
            g.selectAll(".dot")
                .data(data)
                .enter().append("circle")
                .attr("class", "dot")
                .attr("cx", (_, i) => x(labels[i]))
                .attr("cy", d => y(d))
                .attr("r", 4)
                .attr("fill", "green");
        }

        const data1 = [200, 300, 150, 450, 400, 300, 250, 150, 200, 300, 350, 250];
        const labels1 = ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"];

        const data2 = [50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600];
        const labels2 = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        // Render the first chart
        renderLineChart("chart-line-1", data1, labels1);

        // Render the second chart
        renderLineChart("chart-line-2", data2, labels2);

        // Make charts responsive on window resize
        window.addEventListener("resize", () => {
            renderLineChart("chart-line-1", data1, labels1);
            renderLineChart("chart-line-2", data2, labels2);
        });
    </script>
</body>

</html>

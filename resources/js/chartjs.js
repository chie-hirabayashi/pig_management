import Chart from "chart.js/auto";

const bornDay = Laravel.bornInfos.map((bornInfo) => bornInfo.born_day);
const bornNum = Laravel.bornInfos.map((bornInfo) => bornInfo.born_num);
const rotate = Laravel.bornInfos.map((bornInfo) => bornInfo.rotate);

const ctx = document.getElementById("myChart").getContext("2d");
const myChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: bornDay.reverse(),
        datasets: [
            {
                label: "産子数",
                data: bornNum.reverse(),
                borderColor: "rgb(75, 192, 192)",
                backgroundColor: "rgba(75, 192, 192, 0.5)",
                yAxisID: "y",
            },
            {
                label: "回転数",
                data: rotate.reverse(),
                borderColor: "rgb(153, 102, 255)",
                backgroundColor: "rgba(153, 102, 255, 0.5)",
                yAxisID: "y2",
            },
        ],
    },
    options: {
        scales: {
            y: {
                min: 0,
                max: 30,
                ticks: {
                    color: "rgb(75, 192, 192)",
                    // color: "#f88",
                },
            },
            y2: {
                min: 0,
                max: 3,
                position: "right",
                ticks: {
                    color: "rgb(153, 102, 255)",
                    // color: "#48f",
                },
            },
        },
    },
});

import Chart from "chart.js/auto";

// sample
var num = Laravel.array;

const bornDay = Laravel.bornInfos.map((bornInfo) => bornInfo.born_day);
const bornNum = Laravel.bornInfos.map((bornInfo) => bornInfo.born_num);
const rotate = Laravel.bornInfos.map((bornInfo) => bornInfo.rotate);

const ctx = document.getElementById("myChart").getContext("2d");
const myChart = new Chart(ctx, {
    type: "line",
    data: {
        // labels: ["月", "火曜", "水曜", "木曜", "金曜", "土曜", "日曜"],
        labels: bornDay.reverse(),
        datasets: [
            {
                label: "産子数",
                // data: [12, 19, 3, 5, 2, 3, -10],
                // data: [Laravel.one, 19, 3, 5, 2, 3, -10],
                // data: Laravel.array,
                // data: num,
                data: bornNum.reverse(),
                borderColor: "rgb(75, 192, 192)",
                backgroundColor: "rgba(75, 192, 192, 0.5)",
            },
            {
                label: "回転数",
                // data: [8, 9, 13, 15, 1, 14, 1],
                data: rotate.reverse(),
                borderColor: "rgb(153, 102, 255)",
                backgroundColor: "rgba(153, 102, 255, 0.5)",
                yAxisID: 'y2',
            },
        ],
    },
    options: {
        scales: {
            y: {
                min: 0,
                max: 20,
                ticks: {
                    color: "#f88",
                },
            },
            y2: {
                min: 1,
                max: 3,
                position: "right",
                ticks: {
                    color: "#48f",
                },
            },
        },
    },
});

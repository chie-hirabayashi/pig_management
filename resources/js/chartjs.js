import Chart from "chart.js/auto";

// const bornDay = Laravel.bornInfos.map(
//     (bornInfo) => new Date(bornInfo.born_day)
// );
const bornDay = Laravel.bornInfos.map((bornInfo) => bornInfo.born_day);
const bornNum = Laravel.bornInfos.map((bornInfo) => bornInfo.born_num);
const rotate = Laravel.bornInfos.map((bornInfo) => bornInfo.rotate);

// var Data = [];
// for (var i = 0; i < window.Laravel.bornInfos.length; i++) {
//     Data[i] = {
//         x: new Date(window.Laravel.bornInfos[i].born_day),
//         // x: window.Laravel.bornInfos[i].born_day,
//         y: window.Laravel.bornInfos[i].born_num,
//     };
// }

const ctx = document.getElementById("myChart").getContext("2d");
const myChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: bornDay.reverse(),
        datasets: [
            // data1,
            // {
            //     label: "産子数",
            //     data: Data,
            //     borderColor: "rgb(75, 192, 192)",
            //     backgroundColor: "rgba(75, 192, 192, 0.5)",
            //     xAxisID: 'x',
            // },
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
                max: 20,
                ticks: {
                    color: "rgb(75, 192, 192)",
                    // color: "#f88",
                },
            },
            y2: {
                min: 1,
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

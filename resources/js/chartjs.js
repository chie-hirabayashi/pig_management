import Chart from "chart.js/auto";

// const bornDay = Laravel.bornInfos.map(
//     (bornInfo) => new Date(bornInfo.born_day)
// );

// const bornDay = Laravel.bornInfos.map((bornInfo) => bornInfo.born_day);
// const bornNum = Laravel.bornInfos.map((bornInfo) => bornInfo.born_num);
// const rotate = Laravel.bornInfos.map((bornInfo) => bornInfo.rotate);
// const troubleDay = Laravel.mixInfos.map((mixInfo) => mixinfo.trouble_id);

var bornNum = [];
for (var i = 0; i < window.Laravel.bornInfos.length; i++) {
    bornNum[i] = {
        // x: new Date(window.Laravel.bornInfos[i].born_day),
        x: window.Laravel.bornInfos[i].born_day,
        y: window.Laravel.bornInfos[i].born_num,
    };
}
var rotate = [];
for (var i = 0; i < window.Laravel.bornInfos.length; i++) {
    rotate[i] = {
        // x: new Date(window.Laravel.bornInfos[i].rotate),
        x: window.Laravel.bornInfos[i].rotate,
        y: window.Laravel.bornInfos[i].rotate,
    };
}
// var trouble = [];
// for (var i = 0; i < window.Laravel.mixInfos.length; i++) {
//     trouble[i] = {
//         x: window.Laravel.mixInfos[i].trouble_day,
//         y: window.Laravel.mixInfos[i].trouble_id,
//     };
// }

const ctx = document.getElementById("myChart").getContext("2d");
const myChart = new Chart(ctx, {
    plugins: [{
        beforeDraw: drawBackground
    }],
    type: "line",
    data: {
        // labels: bornDay.reverse(),
        datasets: [
            {
                label: "産子数",
                data: bornNum.reverse(),
                borderColor: "dimgray",
                backgroundColor: "dimgray",
                // borderColor: "rgb(75, 192, 192)",
                // backgroundColor: "rgba(75, 192, 192, 0.5)",
                yAxisID: "y",
            },
            {
                label: "回転数",
                data: rotate.reverse(),
                borderColor: "crimson",
                backgroundColor: "crimson",
                // borderColor: "rgb(153, 102, 255)",
                // backgroundColor: "rgba(153, 102, 255, 0.5)",
                yAxisID: "y2",
            },
            // {
            //     label: "異常",
            //     data: trouble.reverse(),
            //     borderColor: "rgb(153, 102, 255)",
            //     backgroundColor: "rgba(153, 102, 255, 0.5)",
            //     yAxisID: "y3",
            // },

            // {
            //     label: "産子数",
            //     data: bornNum.reverse(),
            //     borderColor: "rgb(75, 192, 192)",
            //     backgroundColor: "rgba(75, 192, 192, 0.5)",
            //     yAxisID: "y",
            // },
            // {
            //     label: "回転数",
            //     data: rotate.reverse(),
            //     borderColor: "rgb(153, 102, 255)",
            //     backgroundColor: "rgba(153, 102, 255, 0.5)",
            //     yAxisID: "y2",
            // },
        ],
    },
    options: {
        scales: {
            // x: [
            //     {
            //         type: "time",
            //         time: {
            //             unit: "day",
            //         },
            //     },
            // ],
            y: {
                min: -10,
                max: 25,
                ticks: {
                    color: "dimgray",
                    // color: "rgb(75, 192, 192)",
                    // color: "#f88",
                },
            },
            y2: {
                min: 0,
                max: 3.5,
                position: "right",
                ticks: {
                    color: "crimson",
                    // color: "rgb(153, 102, 255)",
                    // color: "#48f",
                },
            },
            // y3: {
            //     min: 1.5,
            //     max: 3.5,
            //     position: "right",
            //     ticks: {
            //         // color: "rgb(153, 102, 255)",
            //         color: "#48f",
            //     },
            // },
        },
    },
});

function drawBackground(target) {
    var xscale = target.scales.x;
    var yscale = target.scales.y;
    var left = xscale.left;
    var top = yscale.getPixelForValue(8);
    var width = xscale.width;
    var height = yscale.getPixelForValue(-10) - top;

    // 着色範囲
    ctx.fillStyle = "gainsboro";
    // ctx.fillStyle = "whitesmoke";
    // ctx.fillStyle = "rgba(0, 100, 255, 0.2)";
    ctx.fillRect(left, top, width, height);
}

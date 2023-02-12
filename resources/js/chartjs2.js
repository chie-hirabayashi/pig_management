import Chart from "chart.js/auto";

var ages = [];
window.Laravel.achievements.forEach((element) => {
    ages.push(element["age"]);
});

var success_mixes = [];
window.Laravel.achievements.forEach((element) => {
    success_mixes.push(element["success_mix"]);
});

var borns = [];
window.Laravel.achievements.forEach((element) => {
    borns.push(element["bornPigs_by_borns"]);
});

var rotates = [];
window.Laravel.achievements.forEach((element) => {
    rotates.push(element["rotates"]);
});

const ctx = document.getElementById("myChart").getContext("2d");
const myChart = new Chart(ctx, {
    plugins: [
        {
            beforeDraw: drawBackground,
        },
    ],
    type: "line",
    data: {
        labels: ages,
        datasets: [
            {
                label: "一腹産数",
                // data: bornNum.reverse(),
                data: borns,
                borderColor: "dimgray",
                backgroundColor: "dimgray",
                // borderColor: "rgb(75, 192, 192)",
                // backgroundColor: "rgba(75, 192, 192, 0.5)",
                yAxisID: "y",
            },
            {
                label: "交配率",
                // data: rotate.reverse(),
                data: success_mixes,
                borderColor: "steelblue",
                backgroundColor: "steelblue",
                yAxisID: "y2",
            },
            {
                label: "回転数",
                // data: rotate.reverse(),
                data: rotates,
                borderColor: "crimson",
                backgroundColor: "crimson",
                yAxisID: "y3",
            },
        ],
    },
    options: {
        scales: {
            // x: [
            x: {
                //         type: "time",
                //         time: {
                //             unit: "day",
                //         },
                title: {
                    display: true,
                    text: "年齢",
                },
                ticks: {
                    callback: function (value, index, ticks) {
                        return value + "歳";
                    },
                },
            },
            // ],
            y: {
                min: -10,
                max: 20,
                ticks: {
                    color: "dimgray",
                },
                title: {
                    display: true,
                    text: "一腹産数",
                },
                ticks: {
                    callback: function (value, index, ticks) {
                        return value + "匹";
                    },
                },
                // title: {
                //     display: true,
                //     text: "匹",
                //     padding: {
                //         top: 10, // 右側
                //         bottom: 10, // 左側
                //     },
                // },
            },
            y2: {
                min: 0,
                max: 1.2,
                // stepSize: 0.25,
                position: "right",
                ticks: {
                    color: "steelblue",
                },
                title: {
                    display: true,
                    text: "交配率",
                },
            },
            y3: {
                min: 0,
                max: 3.0,
                position: "right",
                ticks: {
                    color: "crimson",
                },
                title: {
                    display: true,
                    text: "回転数",
                },
            },
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

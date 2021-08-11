setInterval(showTime, 1000);
function showTime() {
    let time = new Date();
    let hour = time.getHours();
    let min = time.getMinutes();
    let sec = time.getSeconds();
    am_pm = " AM";
  
    if (hour > 12) {
        hour -= 12;
        am_pm = " PM";
    }
    if (hour == 0) {
        hr = 12;
        am_pm = " AM";
    }
  
    hour = hour < 10 ? "0" + hour : hour;
    min = min < 10 ? "0" + min : min;
    sec = sec < 10 ? "0" + sec : sec;
  
    let currentTime = hour + ":" + min + ":" + sec + am_pm;
  
    document.getElementById("jam").innerHTML = currentTime;
}
showTime();

$(function () {
    var ctx = document.getElementById("sumber-kas").getContext("2d");
    var json_url = baseURI + "/dashboard/get-sumber-kas";

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: "Sumber Kas Masjid",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 50000,
                    data: [],
                    spanGaps: false,
                }
            ]
        },
        options: {
            tooltips: {
                mode: 'index',
                intersect: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        stepSize: 500000
                    }
                }]
            }
        }
    });

    ajax_chart(myChart, json_url);

    function ajax_chart(chart, url, data) {
        var data = data || {};

        $.getJSON(url, data).done(function(response) {
            chart.data.labels = response.labels;
            chart.data.datasets[0].data = response.data.jumlah;
            chart.update();
        });
    }
});

getNotifAlert()
setInterval(function () {
    var date = new Date();
    var heure = date.toLocaleTimeString();
    console.log(date.toLocaleTimeString());
    document.getElementById("date").innerHTML = heure;
}, 100)
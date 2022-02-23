(function () {

let countdownDate = document.querySelector("#countdown");
let startDate = countdownDate.dataset.date

const second = 1000,
      minute = second * 60,
      hour = minute * 60,
      day = hour * 24;

let dateCounter = startDate,
    countDown = new Date(dateCounter).getTime(),
    counter = setInterval(function() {    
        let now = new Date().getTime(),
            distance = countDown - now;

            document.getElementById("days").innerText = Math.floor(distance / (day)),
            document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
            document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

        // //do something later when date is reached
        if (distance < 0) {
            document.getElementById("days").innerText = "00",
            document.getElementById("hours").innerText = "00",
            document.getElementById("minutes").innerText = "00",
            document.getElementById("seconds").innerText = "00";

            clearInterval(counter);
        }

    }, 0)

}());
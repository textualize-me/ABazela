document.getElementById("generate").addEventListener("click", function () {
    const city = document.querySelector("#search").value;
    const apiKey = "bd050b912445935da6ad14b0dcfc3d44";
    const currentWeatherUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=pl`;

    const req = new XMLHttpRequest();
    req.open("GET", currentWeatherUrl, true);
    req.onload = function () {
            const data = JSON.parse(req.responseText);
            const weather = document.querySelector("div");
            weather.className = "weatherResults";
        console.log(data)
        weather.innerHTML = `
                <h2>Pogoda w ${data.name}</h2>
                <p>Temperatura: ${data.main.temp}°C</p>
                <p>${data.weather[0].description}</p>
                <img src="https://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png" alt="Ikona pogody">
            `;


    };

    req.send();

    const forecastUrl = `https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${apiKey}&units=metric&lang=pl`;
    fetch(forecastUrl)
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            console.log(data)
            const weather = document.querySelector("div");
            weather.className = "weatherResults";
            weather.innerHTML += `<h2>Prognoza 5-dniowa dla ${data.city.name}</h2>`;

            data.list.forEach((item, index) => {
                if (index % 8 === 0) {
                    weather.innerHTML += `
                        <div>
                            <p>Data: ${item.dt_txt}</p>
                            <p>Temperatura: ${item.main.temp}°C</p>
                            <p>${item.weather[0].description}</p>
                            <img src="https://openweathermap.org/img/wn/${item.weather[0].icon}@2x.png" alt="Ikona pogody">
                        </div>
                    `;
                }
            });
        })

});

let loader;
let markersGrid;

// settings map
let mymap = L.map('mapid').setView([51.305, 18.09], 13);

mymap.setZoom(6);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoia3ViYWd1bGEiLCJhIjoiY2tieG10ejVrMGwwcjJ6bmFzeWNlbHN2ZiJ9.Ecbt_b3LW-BxxRo7Psjiqg', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1
}).addTo(mymap);

mymap.on('click', onMapClick);

function onMapClick(e) {
    //loader    
    let centerPoint = mymap.getCenter();

    let myIcon = L.icon({
        iconUrl: '../images/45.gif',
        iconSize: [64, 64],
    });
    loader = L.marker([centerPoint.lat, centerPoint.lng], {
        icon: myIcon
    }).addTo(mymap);
    if (markersGrid != undefined) {
        mymap.removeLayer(markersGrid);
    }
    mymap.addLayer(loader);

    // disabled click second time
    mymap.off('click', onMapClick);

    let clickedCoorinates = e.latlng;

    $.ajax({
        url: "/getWeather", //wymagane, gdzie się łączymy
        method: "get", //typ połączenia, domyślnie get
        contentType: 'application/json', //gdy wysyłamy dane czasami chcemy ustawić ich typ
        dataType: 'json', //typ danych jakich oczekujemy w odpowiedzi
        data: { //dane do wysyłki
            coordinatesLat: clickedCoorinates.lat,
            coordinatesLng: clickedCoorinates.lng,
            action: "open",
            scope: "all"
        },
        success: function (result) {
            //delete loader when get data from API
            mymap.removeLayer(loader);
            // enabled click
            mymap.on('click', onMapClick);

            let lat = result['clicked']['current']['lat'];
            let lng = result['clicked']['current']['lng'];

            //center and zoom map
            mymap.fitBounds([
                [lat, lng],
            ], {
                maxZoom: 10
            });

            displayImprovedForecast(result);
            displayGridMarkers(result['nearest']);
        }
    });
}

function displayImprovedForecast(result) {
    let lat = result['clicked']['current']['lat'];
    let lng = result['clicked']['current']['lng'];
    let currentWeatherData = result['clicked']['current'];
    let hourlyWeatherData = result['clicked']['hourly'];

    $("#place").html('<p>lat: ' + lat.toFixed(2) + ' lng: ' + lng.toFixed(2) + ' ' + currentWeatherData['city_name'] + '</p>');
    $("#current_icon_img").prop('src', currentWeatherData['icon']);
    $("#current_icon_img").prop('title', currentWeatherData['description']);


    $.each(currentWeatherData, function (index, element) {
        let htmlId = "#current_" + index;
        $(htmlId).html(element);
    });

    $(".currentForPlace").show();
    $("#weatherDetailsCurrent").addClass("weatherDetailsSelected");
    $("#weatherDetailsCurrent").click(function (event) {
        event.preventDefault();
        onClickWeatherDetailsCurrent();
    });

    $(".hourlyForPlace").hide();
    $("#weatherDetailsHourly").removeClass("weatherDetailsSelected");
    $("#weatherDetailsHourly").click(function (event) {
        event.preventDefault();
        onClickWeatherDetailsHourly();
    });

    $(".forecast").css("display", "flex");
    $('.hourlyForPlace').html('');
    $.each(hourlyWeatherData, function (index, element) {
        $(".hourlyForPlace").append("<div class='tableRow'><div class='hour'><p>" + element['dt'] + ":00</p></div><div class='icon'><img class='leaflet-div-icon' src='" + element['icon'] + "' title='" + element['description'] + "' /></div><div class='temp_wind'><div class='labels'><p>Temperatura</p><p>Ciśnienie</p><p>Wiatr</p></div><div class='values'><p>" + Math.round(element['temperature']) + "&deg;C</p><p>" + element['pres'] + "hPa</p><p>" + element['wind_spd'] + "m/s</p></div></div><div class='feels_rain'><div class='labels'><p>Odczuwalnie</p><p>Chmury</p><p>Deszcz</p></div><div class='values'><p>" + Math.round(element['app_temp']) + "&deg;C</p><p>" + element['clouds'] + "%</p><p>" + element['precip'] + "mm</p></div></div></div>");
    });
}

function displayGridMarkers(grid) {
    let markersList = [];
    $.each(grid, function (index, element) {
        let lat = element['current']['lat'];
        let lng = element['current']['lng'];
        let temperature = Math.round(element['current']['temperature']);
        let iconUrl = element['current']['icon'];
        let description = element['current']['description'];

        marker = new L.Marker([lat, lng], {
                icon: new L.DivIcon({
                    className: 'clearSkyD',
                    html: '<img class="leaflet-div-icon" src="' + iconUrl + '" title="' + description + '"/>' +
                        '<span class="textTemperature">' + temperature + '&deg;C</span>'
                })
            }).addTo(mymap)
            .on('click', onMarkerClick);
        markersList.push(marker);
    });
    markersGrid = L.layerGroup(markersList);
    markersGrid.addTo(mymap);
}

function onClickWeatherDetailsHourly() {
    $(".currentForPlace").hide();
    $(".hourlyForPlace").show();
    $("#weatherDetailsCurrent").removeClass("weatherDetailsSelected");
    $("#weatherDetailsHourly").addClass("weatherDetailsSelected");
}

function onClickWeatherDetailsCurrent() {
    $(".currentForPlace").show();
    $(".hourlyForPlace").hide();
    $("#weatherDetailsCurrent").addClass("weatherDetailsSelected");
    $("#weatherDetailsHourly").removeClass("weatherDetailsSelected");
}

function onMarkerClick(e) {
    let clickedCoorinates = e.latlng;
    $.ajax({
        url: "/getWeather", //wymagane, gdzie się łączymy
        method: "get", //typ połączenia, domyślnie get
        contentType: 'application/json', //gdy wysyłamy dane czasami chcemy ustawić ich typ
        dataType: 'json', //typ danych jakich oczekujemy w odpowiedzi
        data: { //dane do wysyłki
            coordinatesLat: clickedCoorinates.lat,
            coordinatesLng: clickedCoorinates.lng,
            action: "open",
            scope: "place"
        },
        success: function (result) {
            displayImprovedForecast(result);
        }
    });
}

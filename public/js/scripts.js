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

function onMapClick(e) {
    let clickedCoorinates = e.latlng;
    console.log(e.latlng);
    $.ajax({
        url: "/getWeather", //wymagane, gdzie się łączymy
        method: "get", //typ połączenia, domyślnie get
        contentType: 'application/json', //gdy wysyłamy dane czasami chcemy ustawić ich typ
        dataType: 'html', //typ danych jakich oczekujemy w odpowiedzi
        data: { //dane do wysyłki
            coordinatesLat: clickedCoorinates.lat,
            coordinatesLng: clickedCoorinates.lng
        },
        success: function (result) {
            let obj = JSON.parse(result);
            let lat = obj['coordinatesLat'];
            let lng = obj['coordinatesLng'];
            let temperature = Math.round(obj['temperature']);
            let icon = obj['icon'];
            let description = obj['description'];
            console.log(icon);
            let iconM;

            switch (icon) {
                case '01d':
                    iconUrl = '../images/icons/01d@2x.png';
                    break;
                case '02d':
                    iconUrl = '../images/icons/02d@2x.png';
                    break;
                case '03d':
                    iconUrl = '../images/icons/03d@2x.png';
                    break;
                case '04d':
                    iconUrl = '../images/icons/04d@2x.png';
                    break;
                case '09d':
                    iconUrl = '../images/icons/09d@2x.png';
                    break;
                case '10d':
                    iconUrl = '../images/icons/10d@2x.png';
                    break;
                case '11d':
                    iconUrl = '../images/icons/11d@2x.png';
                    break;
                case '13d':
                    iconUrl = '../images/icons/13d@2x.png';
                    break;
                case '50d':
                    iconUrl = '../images/icons/50d@2x.png';
                    break;
                case '01n':
                    iconUrl = '../images/icons/01n@2x.png';
                    break;
                case '02n':
                    iconUrl = '../images/icons/02n@2x.png';
                    break;
                case '03n':
                    iconUrl = '../images/icons/03n@2x.png';
                    break;
                case '04n':
                    iconUrl = '../images/icons/04n@2x.png';
                    break;
                case '09n':
                    iconUrl = '../images/icons/09n@2x.png';
                    break;
                case '10n':
                    iconUrl = '../images/icons/10n@2x.png';
                    break;
                case '11n':
                    iconUrl = '../images/icons/11n@2x.png';
                    break;
                case '13n':
                    iconUrl = '../images/icons/13n@2x.png';
                    break;
                case '50n':
                    iconUrl = '../images/icons/50n@2x.png';
                    break;
                default:
                    iconUrl = '../images/icons/13n@2x.png';
            }

            new L.Marker([lat, lng], {
                    icon: new L.DivIcon({
                        className: 'clearSkyD',
                        html: '<img class="leaflet-div-icon" src="' + iconUrl + '" title="' + description + '"/>' +
                            '<span class="textTemperature">' + temperature + '&deg;C</span>'
                    })
                }).addTo(mymap)
                .on('click', onMarkerClick);
        }
    });
}

function onMarkerClick(e) {
    // console.log(e);
    let clickedCoorinates = e.latlng;
    console.log(e.latlng);
    $.ajax({
            url: "/getWeather", //wymagane, gdzie się łączymy
            method: "get", //typ połączenia, domyślnie get
            contentType: 'application/json', //gdy wysyłamy dane czasami chcemy ustawić ich typ
            dataType: 'html', //typ danych jakich oczekujemy w odpowiedzi
            data: { //dane do wysyłki
                coordinatesLat: clickedCoorinates.lat,
                coordinatesLng: clickedCoorinates.lng
            },
            success: function (result) {}
        }
    }

    mymap.on('click', onMapClick);

<html>

<head>
    <meta charset="utf-8">
    <meta name="author" content="AM">
    <meta name="description" content="Sprawdź, gdzie jest pogoda pasująca do Twoich planów wycieczkowych.">
    <meta name="keywords" content="pogoda, prognoza pogody, wycieczka">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime&family=Montserrat&display=swap" rel="stylesheet">
    <title>Znajdź pogodę</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Znajdź pogodę</h1>

            <h3>Kliknij na mapie i zobacz, jaka jest pogoda w promieniu 100 km.</h3>
        </header>

        <section class="map">
            <div id="mapid" style="width: 60vw; height: 60vh;"></div>

        </section>

        <section id="forecast" class="forecast">
            <p>Prognoza pogody dla: </p>
            <div id="place">
            </div>

            <div class="tableData">
                <div>
                    <a href="#" class="weatherDetails" id="weatherDetailsCurrent">Aktualna pogoda</a>
                    <a href="#" class="weatherDetails" id="weatherDetailsHourly">Godzinowa prognoza</a>
                </div>
                <div class="currentForPlace">
                    @include('currentForPlace')
                </div>
                <div class="hourlyForPlace">
                    {{-- @include('hourlyForPlace') --}}
                </div>
            </div>
        </section>

        <footer></footer>
    </div>
</body>

</html>
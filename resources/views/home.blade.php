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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime&family=Montserrat&display=swap" rel="stylesheet">
    <title>Gdzie jest ładna pogoda?</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Gdzie jest ładna pogoda?</h1>

            <h3>Kliknij na mapie i zobacz, jaka jest pogoda w promieniu 100km.</h3>
        </header>

        <section class="map">
            <div id="mapid" style="width: 60vw; height: 60vh;"></div>

        </section>

        <section id="forecast" class="forecast">

        </section>

        <footer></footer>
    </div>
</body>

</html>
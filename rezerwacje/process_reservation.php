<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobieranie danych z formularza
    $number_of_guests = $_POST["number_of_guests"];
    $arrival_date = $_POST["arrival_date"];
    $departure_date = $_POST["departure_date"];
    $arrival_time = $_POST["arrival_time"];
    $child_bed = isset($_POST["child_bed"]) ? "Tak" : "Nie";
    $amenities = isset($_POST["amenities"]) ? implode(", ", $_POST["amenities"]) : "Brak";

    // Inicjalizacja tablicy na dane gości
    $guests_data = array();

    // Pobieranie danych dla każdej osoby
    for ($i = 1; $i <= $number_of_guests; $i++) {
        $guest_name = $_POST["guest_" . $i . "_name"];
        $guest_last_name = $_POST["guest_" . $i . "_last_name"];
        $guest_email = $_POST["guest_" . $i . "_email"];

        // Dodawanie danych do tablicy
        $guests_data[] = array(
            "name" => $guest_name,
            "last_name" => $guest_last_name,
            "email" => $guest_email
        );
    }

    // Obliczanie liczby dni hotelowych
    $start_date = new DateTime($arrival_date);
    $end_date = new DateTime($departure_date);
    $num_nights = $start_date->diff($end_date)->days;

    // Wyświetlanie podsumowania rezerwacji
    echo "<h2>Podsumowanie rezerwacji</h2>";
    echo "<p><strong>Liczba osób:</strong> $number_of_guests</p>";
    echo "<p><strong>Data przyjazdu:</strong> $arrival_date</p>";
    echo "<p><strong>Data wyjazdu:</strong> $departure_date</p>";
    echo "<p><strong>Godzina przyjazdu:</strong> $arrival_time</p>";
    echo "<p><strong>Liczba dni hotelowych:</strong> $num_nights</p>";
    echo "<p><strong>Dostawka dla dziecka:</strong> $child_bed</p>";
    echo "<p><strong>Udogodnienia:</strong> $amenities</p>";

    // Wyświetlanie danych dla każdej osoby
    echo "<h3>Dane osób:</h3>";
    foreach ($guests_data as $index => $guest) {
        echo "<p><strong>Osoba " . ($index + 1) . ":</strong></p>";
        echo "<p><strong>Imię:</strong> " . $guest['name'] . "</p>";
        echo "<p><strong>Nazwisko:</strong> " . $guest['last_name'] . "</p>";
        echo "<p><strong>E-mail:</strong> " . $guest['email'] . "</p>";
    }
}
?>

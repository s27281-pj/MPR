<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdź czy liczba została przesłana
    if (isset($_POST["number"])) {
        $number = intval($_POST["number"]);

        // Sprawdź czy liczba jest liczbą całkowitą dodatnią
        if ($number > 1 && filter_var($number, FILTER_VALIDATE_INT)) {
            $is_prime = true;
            $iterations = 0;

            // Sprawdź czy liczba jest liczbą pierwszą
            for ($i = 2; $i <= sqrt($number); $i++) {
                $iterations++; // Zlicz iteracje pętli

                if ($number % $i == 0) {
                    $is_prime = false;
                    break;
                }
            }

            if ($is_prime) {
                echo "<p>Liczba $number jest liczbą pierwszą.</p>";
            } else {
                echo "<p>Liczba $number nie jest liczbą pierwszą.</p>";
            }

            echo "<p>Ilość iteracji pętli: $iterations</p>";
        } else {
            echo "<p>Wprowadzona wartość nie jest poprawną liczbą całkowitą dodatnią.</p>";
        }
    } else {
        echo "<p>Nie podano liczby do sprawdzenia.</p>";
    }
}
?>

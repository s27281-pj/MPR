<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wynik</title>
</head>
<body>
<h2>Wynik</h2>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];
    $operation = $_POST["operation"];
    $result = 0;

    switch ($operation) {
        case "add":
            $result = $num1 + $num2;
            echo "Wynik dodawania: $result";
            break;
        case "subtract":
            $result = $num1 - $num2;
            echo "Wynik odejmowania: $result";
            break;
        case "multiply":
            $result = $num1 * $num2;
            echo "Wynik mnożenia: $result";
            break;
        case "divide":
            if ($num2 != 0) {
                $result = $num1 / $num2;
                echo "Wynik dzielenia: $result";
            } else {
                echo "Nie można dzielić przez zero!";
            }
            break;
        default:
            echo "Niepoprawne działanie!";
    }
}
?>
</body>
</html>

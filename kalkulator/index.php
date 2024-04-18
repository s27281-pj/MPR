<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator</title>
</head>
<body>
<h2>Prosty kalkulator</h2>
<form action="calculate.php" method="post">
    <label for="num1">Liczba 1:</label>
    <input type="number" name="num1" id="num1" required><br><br>

    <label for="num2">Liczba 2:</label>
    <input type="number" name="num2" id="num2" required><br><br>

    <label for="operation">Działanie:</label>
    <select name="operation" id="operation">
        <option value="add">Dodawanie</option>
        <option value="subtract">Odejmowanie</option>
        <option value="multiply">Mnożenie</option>
        <option value="divide">Dzielenie</option>
    </select><br><br>

    <input type="submit" value="Oblicz">
</form>
</body>
</html>
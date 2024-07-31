<?php

require_once 'config.php';
require_once 'num2words.php';

function validateData($data)
{
    global $Currency, $today_time;

    // Weryfikacja czy podane dane są w odpowiednim formacie
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [false, "JSON Array error", 500];
    }

    if (!is_array($data)) {
        return [false, "JSON Array error", 500];
    }

    // Wartości domyślne (jeżeli nie podano)
    $defaults = [
        "issueDate" => $today_time,
        "city" => "",
        "seller" => "",
        "buyer" => "",
        "signature" => "",
        "unitOfMeasures" => "szt.",
        "paymentMethod" => "-",
        "language" => "pl",
        "currency" => "PLN",
        "priceInWords" => false,
        "additionalFooter" => ""
    ];

    foreach ($defaults as $key => $value) {
        if (!isset($data[$key])) {
            $data[$key] = $value;
        }
    }

    // Weryfikacja niezbędnych danych
    if (!isset($data["paymentDate"], $data["id"], $data["rows"], $data["unitOfMeasures"])) {
        return [false, "Missing required data", 404];
    }

    // issueDate
    if ($data["issueDate"] == "") {
        $data["issueDate"] = $today_time;
    }

    // paymentDate
    if ($data["paymentDate"] == "" || $data["paymentDate"] == 0) {
        return [false, "Payment Date is required", 404];
    }

    // Weryfikacja wierszy
    if (count($data["rows"]) == 0) {
        return [false, "It is required to have at least one row", 404];
    }

    // Struktura "rows"
    foreach ($data["rows"] as $i => $row) {
        // Czy odpowiednie wartości są dostarczone
        if (!isset($row["name"], $row["number"], $row["netPrice"], $row["grossPrice"])) {
            return [false, "Invalid rows structure", 400];
        }

        // Czy wartość name nie jest pusta
        if (empty($row["name"])) {
            return [false, "No name in row", 404];
        }

        // Zamiana przecinka na kropkę w danych liczbowych
        $row["number"] = str_replace(",", ".", $row["number"]);
        $row["netPrice"] = str_replace(",", ".", $row["netPrice"]);
        $row["grossPrice"] = str_replace(",", ".", $row["grossPrice"]);

        // Czy liczby są rzeczywiście liczbami
        if (!is_numeric($row["number"]) || !is_numeric($row["netPrice"]) || !is_numeric($row["grossPrice"])) {
            return [false, "Provided value is not numeric", 400];
        }

        $data["rows"][$i] = $row;
    }

    // Weryfikacja języka
    if (!in_array($data["language"], ["pl", "en"])) {
        return [false, "Invalid language", 400];
    }

    // weryfikacja priceInWords
    $data["priceInWords"] = in_array($data["priceInWords"], [1, "1", "true", "True", true]);

    // Weryfikacja poprawności waluty
    if (!array_key_exists($data["currency"], $Currency)) {
        return [false, "Invalid currency name", 400];
    }

    // Dodawanie break linów w sprzedającym i kupującym w celu oddzielenia danych od siebie
    $data["buyer"] = str_replace("|", "<br>", $data["buyer"]);
    $data["seller"] = str_replace("|", "<br>", $data["seller"]);

    return [true, $data, 200];
}

// Funkcja dająca poprawny format liczby tzn: [...]xxx,xx [waluta]
function moneyFormat($value, $currency)
{
    global $Currency;
    $value = (round($value * 100) / 100);
    return number_format($value, 2, ',', '') . " " . $Currency[$currency];
}

// Funkcja zamieniająca liczbę na nazwę tekstową liczby
function moneyText($value, $currency)
{
    // You can use a library or write your own function to convert numbers to words in Polish
    $reszta = round(($value - floor($value))*100);
    return num2words(intval($value), 'pl') . " " . $currency . " " . $reszta . "/100 ";
}

?>

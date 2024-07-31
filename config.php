<?php

// Languages
$Languages = [
    "generateData" => [
        "pl" => "Data i miejsce wystawienia dokumentu",
        "en" => "Document generate date and city"
    ],

    "paymentData" => [
        "pl" => "Termin płatności",
        "en" => "Document payment date"
    ],

    "seller" => [
        "pl" => "Sprzedawca",
        "en" => "Seller"
    ],

    "buyer" => [
        "pl" => "Kupujący",
        "en" => "Buyer"
    ],

    "documentName" => [
        "pl" => "Faktura",
        "en" => "Invoice"
    ],

    "orderName" => [
        "pl" => "L.p.",
        "en" => "NO"
    ],

    "productName" => [
        "pl" => "Nazwa towaru lub usługi",
        "en" => "Name of product or service"
    ],

    "unit" => [
        "pl" => "Jm.",
        "en" => "pc"
    ],

    "amount" => [
        "pl" => "Ilość",
        "en" => "amount"
    ],

    "netPrice" => [
        "pl" => "Cena Netto",
        "en" => "Net Price"
    ],

    "grossPrice" => [
        "pl" => "Cena Brutto",
        "en" => "Gross Price"
    ],

    "grossValue" => [
        "pl" => "Wartość Brutto",
        "en" => "Gross Value"
    ],

    "charge" => [
        "pl" => "Należność",
        "en" => "Total Charge"
    ],

    "paymentMethod" => [
        "pl" => "Metoda płatności",
        "en" => "Payment Method"
    ],

    "owing" => [
        "pl" => "Do zapłaty",
        "en" => "Owing"
    ],

    "sellerSignature" => [
        "pl" => "Podpis osoby upoważnionej do wystawienia",
        "en" => "Signature of seller"
    ],

    "buyerSignature" => [
        "pl" => "Podpis osoby upoważnionej do odbioru",
        "en" => "Signature of buyer/reciever"
    ],

    "priceInWords" => [
        "pl" => "Słownie",
        "en" => ""
    ]

];

// Currency
$Currency = [
    "PLN" => "zł",
    "USD" => "$",
    "CAD" => "$",
    "GBP" => "£",
    "EUR" => "€",
    "JPY" => "¥",
    "RUB" => "₽",
    "CNY" => "¥",
    "AUD" => "$",
    "CHF" => "Fr",
    "SEK" => "kr",
    "NOK" => "kr",
    "BRL" => "R$",
    "MXN" => "$",
    "INR" => "₹",
    "ZAR" => "R",
    "TRY" => "₺",
    "KRW" => "₩",
    "SGD" => "$",
    "NZD" => "$"
];

$now = new DateTime();
$today_time = $now->format('d/m/Y H:i:s');

?>

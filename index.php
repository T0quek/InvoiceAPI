<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'config.php';
require 'invoice.php';
require 'validate.php';

require __DIR__.'/vendor/autoload.php';
use Dompdf\Dompdf;


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['data'])) {
    generate_invoice();
}
else {
    header('Content-Type: application/json');
    echo json_encode(['info' => "No data", 'statusCode' => 404, 'documentationLink' => 'https://invoice.toquek.pl/documentation']);
    exit();
}

function generate_invoice() {

    if(!is_array($_GET["data"])) $requestData = json_decode($_GET['data'], true);

    // Validate data
    list($isValid, $validatedData, $errorCode) = validateData($requestData);

    // If data is not valid, return error as JSON
    if (!$isValid) {
        header('Content-Type: application/json');
        echo json_encode(['info' => $validatedData, 'statusCode' => $errorCode]);
        exit();
    }

    // Generate HTML from parameters
    $html_content = wstep(
        $validatedData["issueDate"],
        $validatedData["city"],
        $validatedData["seller"],
        $validatedData["paymentDate"],
        $validatedData["buyer"],
        $validatedData["id"],
        $validatedData["language"]
    );

    // Rows in the invoice
    $total = 0;
    foreach ($validatedData["rows"] as $i => $row) {
        $lp = $i + 1;
        $html_content .= wiersz(
            $lp,
            $row["name"],
            $validatedData["unitOfMeasures"],
            $row["number"],
            moneyFormat($row["netPrice"], $validatedData["currency"]),
            moneyFormat($row["grossPrice"], $validatedData["currency"]),
            moneyFormat($row["number"] * $row["grossPrice"], $validatedData["currency"])
        );

        $total += $row["number"] * $row["grossPrice"];
        $total = round($total, 2);
    }

    // Ending
    $html_content .= koniec(
        moneyFormat($total, $validatedData["currency"]),
        moneyText($total, $validatedData["currency"]),
        $validatedData["paymentMethod"],
        $validatedData["signature"],
        "",
        $validatedData["additionalFooter"],
        $validatedData["language"],
        $validatedData["priceInWords"]
    );

    // Convert HTML to PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html_content);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream($validatedData["id"], array("Attachment" => false));
    exit();
}

?>

<?php

require_once 'config.php';

function wstep($data, $miejscowosc, $sprzedawca, $termin_platnosci, $nabywca, $invoice_id, $language = "pl")
{
    global $Languages;

    $css_code = "
    <style>
        @page {
            margin: 0 20px 0 20px;
            font-family: DejaVu Sans;
            font-size: 12px;
        }
        
        .invoice {
            margin: 30px auto;
            display: block;
            width: 100%;
        }
        p {
            margin: 0;
            padding: 5px 0;
            border-top: 1px solid black;
        }
        .header {
            margin-top: 30px;
            text-align: center;
        }
        .header-block {
            min-height: 80px;
        }
        .left-header, .right-header {
            float: left;
            width: 50%;
            min-height: 80px;
        }
        .grey {
            background-color: #e1e1e1;
            font-weight: bold;
            text-align: center;
        }
        .block {
            margin: 0 5%;
        }
        table {
            text-align: center;
            border-collapse: collapse;
            width: 100%;
        }
        .data {
            clear: both;
            margin: 0 2.5%;
        }
        .table td {
            padding: 8px 5px;
            border: 1px solid black;
        }
        .h2 {
            text-align: center;
            padding-top: 50px;
        }
        .td-bottom {
            width: 45%;
            border: none;
            vertical-align: top;
        }
        .bottom {
            vertical-align: bottom;
        }

        footer {
                margin: 0 20px 0 20px;
                position: fixed; 
                bottom: 0; 
                left: 0; 
                right: 0;
            }
    </style>
    ";

    return "
    <head>
        <meta charset='UTF-8'>
        <title>{$Languages['documentName'][$language]} {$invoice_id}</title>
        {$css_code}
    </head>
    <body>
    <header class='header'>
        <div class='left-header'>
            <div class='block'>
                <div class='header-block'>
                    <p class='grey'>{$Languages['generateData'][$language]}</p>
                    <p>{$miejscowosc} {$data}</p>
                </div>
                <div class='header-block'>
                    <p class='grey'>{$Languages['seller'][$language]}</p>
                    <p>{$sprzedawca}</p>
                </div>
            </div>
        </div>
        <div class='right-header'>
            <div class='block'>
                <div class='header-block'>
                    <p class='grey'>{$Languages['paymentData'][$language]}</p>
                    <p>{$termin_platnosci}</p>
                </div>
                <div class='header-block'>
                    <p class='grey'>{$Languages['buyer'][$language]}</p>
                    <p>{$nabywca}</p>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class='invoice'>
            <div class='data'>
                <h2 class='h2'>{$Languages['documentName'][$language]} {$invoice_id}</h2>
                <table class='table'>
                    <thead>
                        <tr class='grey'>
                            <td>{$Languages['orderName'][$language]}</td>
                            <td>{$Languages['productName'][$language]}</td>
                            <td>{$Languages['unit'][$language]}</td>
                            <td>{$Languages['amount'][$language]}</td>
                            <td>{$Languages['netPrice'][$language]}</td>
                            <td>{$Languages['grossPrice'][$language]}</td>
                            <td>{$Languages['grossValue'][$language]}</td>
                        </tr>
                    </thead>
                    <tbody>
    ";
}

function wiersz($lp, $productName, $unit, $amount, $netPrice, $grossPrice, $grossValue)
{
    return "
            <tr>
                <td>{$lp}</td>
                <td class='tdName'>{$productName}</td>
                <td>{$unit}</td>
                <td>{$amount}</td>
                <td>{$netPrice}</td>
                <td>{$grossPrice}</td>
                <td>{$grossValue}</td>
            </tr>";
}

function koniec($total, $totalText, $paymentMethod, $sellerSignature, $buyerSignature, $additionalFooter, $language = "pl", $priceInWords = false)
{
    global $Languages;

    $slownie = "";
    if ($priceInWords && strlen($totalText) > 0 && $language == "pl") {
        $slownie = "<p>{$Languages['priceInWords'][$language]}: {$totalText}</p>";
    }

    return ("
                    <tr>
                        <td colspan='4' style='border:none;'></td>
                        <td colspan='2'>{$Languages['charge'][$language]}:</td>
                        <td class='grey'>{$total}</td>
                    </tr>
                    </tbody>
                </table>
                <div style='padding-top:30px;padding-bottom: 30px;'></div>
                <table>
                    <tr>
                        <td class='td-bottom'>
                            <p>{$Languages['paymentMethod'][$language]}: {$paymentMethod}</p>
                        </td>
                        <td style='width: 10%;'></td>
                        <td class='td-bottom'>
                            <div>
                                <p style='font-weight: bold'>{$Languages['owing'][$language]} {$total}</p>
                                " . $slownie . "
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
    <footer>
        <table>
            <tr>
                <td class='td-bottom bottom'>
                    <p style='font-weight: bold; border-top:none;'>{$sellerSignature}</p>
                    <p>{$Languages['sellerSignature'][$language]}</p>
                </td>
                <td style='width: 10%;'></td>
                <td class='td-bottom bottom'>
                    <div>
                        <p style='font-weight: bold; border-top:none;'>{$buyerSignature}</p>
                        <p>{$Languages['buyerSignature'][$language]}</p>
                    </div>
                </td>
            </tr>
        </table>
        <p style='border:none; margin:15px 0; font-size: 10px;'>{$additionalFooter}</p>
    </footer>
</body>");
}

?>

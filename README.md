## Introduction

The INVOICE HTTP GENERATOR 1.0 web application allows for quick generation of a ready-to-use PDF file with an invoice sheet based on the provided data and parameters using an HTTP request. The application returns content in PDF format with the header "Content-Type": "application/pdf". This document contains the full specification of this software.

## Invocation

The application is available at https://invoice.toquek.pl/?data= and can be run in a browser or using special software/libraries for making HTTP requests. Generating a PDF file requires creating a GET request to the given URL. The "data" attribute should contain a properly formatted JSON array according to the documentation below.

## Data Preparation

The data that will be passed to the application should be properly formatted in the form of a JSON array. You should also use the Escape String function on characters that require it (e.g., spaces) if necessary. All document parameters should be provided according to the following schema:

```
  {
      // Required parameters //
      "id": "unique Id",
      \[...]
  
      // Optional parameters //
      "language": "en",
      \[...]
  
      // Invoice rows //
      "rows": [
          { // Row data // }
          \[...]
      ]
  }
```
                        
## Required Arguments

| Name        | Possible Formats      | Description                                                                                                                                                        | Example                          | Default Value |
|-------------|-----------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------|---------------|
| id          | string                | A unique identifier of the document that uniquely identifies it. This name also becomes the file name (when downloading the file in the browser).                  | "JSHG-XYZA-ABCDE"                | -             |
| paymentDate | string                | The payment date can be provided in any format (e.g., dd/mm/YYYY). It indicates the final date of the described transaction.                                       | "01/10/2025"                     | -             |
| rows        | array of JSON objects | An array containing individual document items must contain at least one item in the form of a JSON array as described in the section "Arguments for a Single Row". | See "Arguments for a Single Row" | -             |



## Arguments for a Single Row

| Name       | Possible Formats      | Description                                                                                                  | Example | Default Value |
|------------|-----------------------|--------------------------------------------------------------------------------------------------------------|---------|---------------|
| name       | string                | The name of the described good or service.                                                                   | "Apple" | -             |
| number     | int or float          | The quantity of the described good or service.                                                               | "3.4"   | -             |
| netPrice   | string, int, or float | The net price of a single product or service unit. The price is always rounded down to two decimal places.   | "13,24" | -             |
| grossPrice | string, int, or float | The gross price of a single product or service unit. The price is always rounded down to two decimal places. | "15,23" | -             |

## Optional Arguments

| Name             | Possible Formats    | Description                                                                                                                                                                                                     | Example                                       | Default Value         |
|------------------|---------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------|-----------------------|
| issueDate        | string              | The document issue date. The format is optional, but the suggested format is dd/mm/YYYY HH:ii:ss.                                                                                                               | "10/11/2023 12:30:00"                         | current date and time |
| city             | string              | The name of the city/town where the document was issued. It is placed after the document issue date.                                                                                                            | "New York"                                    | ""                    |
| seller           | string              | The name of the seller or entity issuing the document. You can use the '\|' character to create a new line to separate key data.                                                                                | "Vortex Company \| Institution of Technology" | ""                    |
| buyer            | string              | The name of the buyer or entity purchasing. You can use the '\|' character to create a new line to separate key data.                                                                                           | "John Smith \| +14844761234"                  | ""                    |
| signature        | string              | The signature of the seller/entity issuing the document, placed at the bottom of the document.                                                                                                                  | "Jacob Butch - CEO"                           | ""                    |
| unitOfMeasures   | string              | The unit of measure used to describe each item of goods or services, e.g., kg, hour, pound, etc.                                                                                                                | "kg"                                          | kg                    |
| paymentMethod    | string              | The payment method used or selected by the buyer.                                                                                                                                                               | "kg"                                          | ""                    |
| language         | string              | The language used for the document template. Available languages are: "en" - English, "pl" - Polish.                                                                                                            | "en"                                          | pl                    |
| currency         | string              | The selected currency in the format of a three-letter uppercase abbreviation. Acceptable currencies are: PLN, USD, CAD, GBP, EUR, JPY, RUB, CNY, AUD, CHF, SEK, NOK, BRL, MXN, INR, ZAR, TRY, KRW, SGD, NZD.    | "PLN"                                         | PLN                   |
| priceInWords     | bool, string or int | A boolean flag indicating whether the total amount of the document should also be expressed in words. Only Polish language ("language":"pl") is supported. Accepted values are: True, False, true, false, 1, 0. | true                                          | false                 |
| additionalFooter | string              | Additional information placed in the document footer, e.g., information about a special VAT rate if necessary.                                                                                                  | "Generated by invoiceAPI"                     | ""                    |


## Usage Example

```
https://invoice.toquek.pl/?data={
    "id":"JSHG-XYZA-ABCDE",
    "paymentDate":"01/10/2025",
    "rows": [
        {"name":"Apple", "number":"3.4", "netPrice":"13,24", "grossPrice":"15,23"},
        {"name":"Orange", "number":"21", "netPrice":"16.51", "grossPrice":"17"}
    ],
    "issueDate":"",
    "city":"New York",
    "seller":"Vortex Company | Institution of Technology",
    "buyer":"John Smith | +14844761234",
    "unitOfMeasures":"kg",
    "signature":"Jacob Butch - CEO",
    "paymentMethod":"Money Transfer",
    "language":"pl",
    "currency":"PLN",
    "priceInWords":true,
    "additionalFooter":"Generated by invoiceAPI"
}
```

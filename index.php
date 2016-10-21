<?php

use POData\OperationContext\ServiceHost;
use charris\PODataSimple\SimpleDataService;
use charris\PODataSimple\SimpleRequestAdapter ;
use charris\PODataSimple\SimpleQueryProvider ;

require(__DIR__ . '/vendor/autoload.php');

require(__DIR__ . '/OperationContextAdapter.php');
require(__DIR__ . '/models/MetadataProvider.php');
require(__DIR__ . '/models/Product.php');
require(__DIR__ . '/QueryProvider.php');

// DB Connection
$dsn = 'sqlite:'. __DIR__ . "/odata.sqlite";
$db = new \PDO($dsn);

// Realisation of QueryProvider
$db->queryProviderClassName = "\\QueryProvider"	;

// Controller
$op = new OperationContextAdapter($_GET);
$host = new ServiceHost($op);
$host->setServiceUri("/odata2.svc/");
$service = new SimpleDataService($db, \models\MetadataProvider::create());
$service->setHost($host);
$service->handleRequest();
$odataResponse = $op->outgoingResponse();

// Headers for response
foreach ($odataResponse->getHeaders() as $headerName => $headerValue) {
    if (!is_null($headerValue)) {
        header($headerName . ": " . $headerValue);
    }
}

// Body of response
echo $odataResponse->getStream();

<?php

require_once 'swedbankJson.php';

try
{
	// Login with your credentials
	// Read a file and divide it into lines
    $arr = file("../.credentials/swedbank");

    $username = trim($arr[0]); // Personnummer
    $password = trim($arr[1]); // Personlig kod
    $authKey = trim(count($arr) > 2 ? $arr[2] : ""); // Autientiseringsnyckel, kan vara tom

    $bankConn    = new SwedbankJson($username, $password, $authKey);
    $accounts    = $bankConn->accountList();
    $accountInfo = $bankConn->accountDetails($accounts->transactionAccounts[1]->id); // Hämtar från första kontot, sannolikt lönekontot
    $bankConn->terminate();
}
catch (Exception $e)
{
    echo 'Swedbank-fel: ' . $e->getMessage() . ' (Err #' . $e->getCode() . ")\r\n" . $e->getTraceAsString();
    exit;
}

####

/*
echo '<pre>
Konton
';
print_r($accounts);

####

echo '
Kontoutdrag
';
print_r($accountInfo);

####

echo '
Auth-nyckel:
';
echo $bankConn->getAuthorizationKey();
*/

echo (json_encode($accountInfo));

$bankConn = new SwedbankJson($username, $password);

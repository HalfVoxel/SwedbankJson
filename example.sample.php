<?php
require_once 'swedbankJson.php';
require_once 'appData.php';

// Inställningar
define('BANKID',    'swedbank');     // Byt mot motsvarnde IOS/Android mobil app. Alternativ: swedbank, sparbanken, swedbank_ung, sparbanken_ung, swedbank_företag

try
{
	// Login with your credentials
	// Read a file and divide it into lines
    $arr = file("../.credentials/swedbank");

    $username = trim($arr[0]); // Personnummer
    $password = trim($arr[1]); // Personlig kod
    //$authKey = trim(count($arr) > 2 ? $arr[2] : ""); // Autientiseringsnyckel, kan vara tom

    $bankConn    = new SwedbankJson($username, $password, $appData[BANKID]);
    $accounts    = $bankConn->accountList();
    $accountInfo = $bankConn->accountDetails($accounts->transactionAccounts[0]->id); // Hämtar från första kontot, sannolikt lönekontot
    $bankConn->terminate();
}
// Fel av användare
catch (UserException $e)
{
    echo $e->getMessage();
    exit;
}

// Systemfel och övriga fel
catch (Exception $e)
{
    echo 'Swedbank-fel: ' . $e->getMessage() . ' (Err #' . $e->getCode() . ")\r\n" . $e->getTraceAsString();
    exit;
}

echo (json_encode($accountInfo));
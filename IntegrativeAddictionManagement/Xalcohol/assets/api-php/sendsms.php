<?php
/*
=======================================================================
 Bestand:		verstuurSMS.php
 Created:		16-01-2005
 Author:		Mollie B.V.
 Ver:			v 2.0 08-02-2005 13:56:11

 More information? Go to www.mollie.nl
========================================================================
*/


require('classes/class.mollie.php');

$sms = new mollie();

// Kies een gateway
$sms->setGateway(1);
// Stel gebruikersnaam en wachtwoord van Mollie.nl in
$sms->setLogin('gebruikersnaam', 'wachtwoord');
// Stel de afzender in van het SMS-bericht
$sms->setOriginator('Mollie');
// Voeg een ontvanger toe aan het bericht
$sms->addRecipients('31612345678');


// Verstuur het SMS-bericht
$sms->sendSMS('Hallo, dit is een SMS-bericht naar jou!');


if ($sms->success) 
{
	echo '<b>SMS-bericht verzonden naar '.$sms->successcount.' nummer(s)!</b>';
}
else
{
	echo '<b>Het versturen van het SMS-bericht is niet gelukt!</b><br>
		  Errorcode: '.$sms->resultcode.'<br>
		  Errormessage: '.$sms->resultmessage;
}
?>
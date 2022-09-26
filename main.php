
<?php
$currDir = dirname(__FILE__) . '/..';
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");

/* grant access to all users who have acess to the receiving table */
$od_from = get_sql_from('receiving');
if(!$od_from){
header('HTTP/1.0 401 Unauthorized');
exit;
}

$SupplyLotCode = intval($_REQUEST['SupplyLotCode']);
if(!$SupplyLotCode) exit;

$AmountReceived = sqlValue("select AmountReceived from receiving where SupplyLotCode='{$SupplyLotCode}'");
$QuantityUsed = sqlValue("select sum(QuantityUsed)from batchesdetails where SupplyLotCode='{$SupplyLotCode}'");


$balance_Quantity = $AmountReceived - $QuantityUsed;
sql("update receiving set Balance='{$balance_Quantity}' where SupplyLotCode='{$SupplyLotCode}'", $eo);

echo number_format($balance_Quantity, 2);

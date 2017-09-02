<?php

// formatear moneda
function convertAmount($bs) {
	$amount = str_replace(".","", $bs);// 750.000,00 -> 750000,00
	$amount = str_replace(",",".",$amount);// 750000,00 -> 750000.00
	
	return $amount;
};
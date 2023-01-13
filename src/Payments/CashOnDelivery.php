<?php

namespace App\Payments;

use App\Payments\PaymentStrategy;


class CashOnDeliveryStrategy implements PaymentStrategy
{
	use App\Payments\Customer;

	public function __construct($customer)
	{
		$this->name = $name;
		$this->address = $address;
		$this->email= $email;
	}

	public function pay($amount)
	{
		echo "Payment for the amount {$amount} would be paid on delivery\n";
		echo "C.O.D. Details\n";
		echo "Payee: {$this->name} \n";
		echo "Address: {$this->address}, {$this->email} \n";
	}
}

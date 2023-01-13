<?php

namespace App\Order;

use Exception;
use App\Invoice\InvoiceStrategy;
use App\Payments\PaymentStrategy;
use App\Tax\TaxStrategy;

class Order
{
	protected $items;
	protected $total;
	protected $paymentMethod;
	protected $invoiceGenerator;

	public function __construct($customer, $cart)
	{
		$this->items = $cart->getItems();
		$this->total = $cart->getTotal();
	}

	public function getItems()
	{
		return $this->items;
	}

	public function getTotal()
	{
		return $this->total;
	}

	public function setInvoiceGenerator(InvoiceStrategy $generator)
	{
		$this->invoiceGenerator = $generator;
	}

	public function generateInvoice()
	{
		try {
			if (empty($this->invoiceGenerator)) {
				throw new Exception("Invoice generator is missing");
			}
			$this->invoiceGenerator->generate($this);
		} catch (Exception $e) {
			error_log($e->getMessage());
		}
	}


	public function setPaymentMethod(PaymentStrategy $method)
	{
		$this->paymentMethod = $method;
	}

	public function payInvoice()
	{
		try {
			if (empty($this->paymentMethod)) {
				throw new Exception('Invalid payment method');
			}
	
			$total = $this->total;
			if ($this->isTaxEnabled) {
				$total = $this->totalWithTax;
			}
			$this->paymentMethod->pay($total);
		} catch (Exception $e) {
			error_log($e->getMessage());
		}
	}


}
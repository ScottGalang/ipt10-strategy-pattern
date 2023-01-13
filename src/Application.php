<?php

namespace App;

use App\Cart\Item;
use App\Cart\ShoppingCart;
use App\Customer\Customer;
use App\Order\Order;
use App\Invoice\TextInvoice;
use App\Invoice\PDFInvoice;
use App\Payments\CashOnDelivery;
use App\Payments\CreditCardPayment;
use App\Payments\PaypalPayment;

class Application
{
	public static function run()
	{
		$cart = new ShoppingCart();
		$ballpen= new Item('Office','Ergonomic Ballpen', 25000);
		
		$cart->addItem($ballpen, 1);


		$customer = new Customer('Scott', 'Dizon Estate', 'galang.scott@gmail.com');

		$order = new Order($customer, $cart);

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$textInvoice = new TextInvoice($order);
		$order->setInvoiceGenerator($textInvoice);
		$order->generate();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$pdfInvoice = new PDFInvoice($order);
		$order->setInvoiceGenerator($pdfInvoice);
		$order->generate();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$creditCard = new CreditCardPayment('Scott', '1234-4321-1234-4321', '619', '09/25');
		$order->setPaymentMethod($creditCard);
		$order->pay();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$cod = new CashOnDeliveryStrategy($customer);
		$order->setPaymentMethod($cod);
		$order->pay();

	}
}
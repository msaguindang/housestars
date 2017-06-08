<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Customer;

class TradesmanService
{
	private $invalidStatus = ['past_due', 'canceled', 'unpaid'];

	public function isSubscriber($tradesman)
	{
		if ($tradesman->subs_status && $tradesman->status && $tradesman->customer_id) {
			Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
      		$customer_info = Customer::retrieve($tradesman->customer_id);
      		$payment_status = $customer_info->status;

      		// if (!is_null($customer_info->subscriptions) && count($customer_info->subscriptions->data) == 0 && !in_array($payment_status, $this->invalidStatus)) {
      		// 	return true;
      		// }
      		if (!in_array($payment_status, $this->invalidStatus)) {
      			return true;
      		}
		}
		return false;
	}
}

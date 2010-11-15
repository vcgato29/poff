<?php

class ProductOrderTable extends Doctrine_Table
{
	const STATUS_NEW = "new";
	const STATUS_PAID = "paid";
	const STATUS_CANCELED = "canceled";
	
	public function checkout( array $products, PublicUser $user, Currency $payInCurrency ){
		$order = new ProductOrder();

		$order->fromArray(
			array(	'public_user_id' => $user->getId(),
					'order_number' => time(),
					'status' => ProductOrderTable::STATUS_NEW,
					'pay_in_currency' => $payInCurrency['abbr']
					 )
		);
		
		$order->save();
		
		
		$shipping = new ProductOrderShipping();
		$shipping->fromArray(array('order_id' => $order['id'], 'vatrate' => 20));
		$shipping->save();
		
		$billing = new ProductOrderBilling();
		$billing->fromArray(array('order_id' => $order['id']));
		$billing->save();
		
		foreach($products as $productID => $qty){
			$product = Doctrine::getTable('Product')->find($productID);
			$item = new ProductOrderItem();
			$item->fromArray(
				array(	'order_id' => $order['id'],
						'product_id' => $productID,
						'quanity' => $qty,
						'mass' => $product['mass'],
						'vatrate' => $product['vatrate'],
						'code' => $product['code'],
						'price' => $product['price_actual'],
						'name' => $product['name'],
						'order_shipping_id' => $shipping['id']));
			$item->save();
		}
		
		return $order;
		
	}


}
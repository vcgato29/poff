<?php use_helper('Currency')?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style>
		
			body{
				padding-top: 5px; 
				padding-bottom: 85px; 
				margin-left: 0px; 
				margin-right: 0px; 
				font-size: 16px; 
				font-family: arial;
				
				padding-bottom:150px;	/* Height of the footer */

				height:100%;
				
			}
			
			#listing
			{
				width: 90%; 
				margin: auto; 
				border-collapse: collapse;
			}
			
			#listing th
			{
				font-weight: normal;
				text-align: left;
				padding-left: 6px;
				margin: 0;
				font-size: 16px;
			}
			
			#listing td
			{
				padding-left: 6px;
				margin: 0;
				font-size: 12px;
			}
			
			#invoice_info
			{
				margin-left: 88px;
			}
			
			#invoice_info td,th
			{
				padding: 5px;
			}
			
			#invoice_table
			{
				margin-top: 17px;
			}
			
	#footer {
		position:absolute;
		bottom:1;
		width:90%;
		height:150px;			/* Height of the footer */
		left: 5%;
	}
	
	#footer table {
		margin:0;
		width: 100%;
	}
	
	#signatures{
		margin:60px;
	}
	
	#logo{
		padding: 50px;
	}


			

		</style>
	</head>
	
	<body>
		
		<img id="logo" src="/sfInvoiceGenerationPlugin/images/logo.png" />
		
		<div id="invoice_info">
			<table>
				<tr>
					<td>
						<i><?php echo $i18n->__('Maksja')?>:</i>
					</td>
					<td>
						<i><?php echo $order->BillingAddress->receiver?> </i>
					</td>
				</tr>
				<tr>
					<td>
						<i><?php echo $i18n->__('Saaja')?>:</i>
					</td>
					<td>
						<i><?php echo $order->Shippings[0]['name']?> </i>
					</td>
				</tr>
			</table>
			
			<table cellpadding="0" cellspacing="0" style="margin-top: 17px;">
				<tr>
					<td>
						<i><?php echo $i18n->__('Arve nr')?>:</i>
					</td>
					<td>
						<i><?php echo $order->getOrderNumber()?></i>
					</td>
				</tr>
				<tr>
					<td>
						<i><?php echo $i18n->__('Kuupäev')?>:</i>
					</td>
					<td>
						<i><?php echo $order->getCreatedAt()?></i>
					</td>
				</tr>
				
				<!-- 
				<tr>
					<td>
						<i><?php echo $i18n->__('Tähtaeg')?>:</i>
					</td>
					<td>
						<i>-</i>
					</td>
				</tr>
				<tr>
					<td>
						<i><?php echo $i18n->__('Maksetingimus')?>:</i>
					</td>
					<td>
						<i>-</i>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<i><?php echo $i18n->__('Õigus nõuda viivist 0.5 % päevas')?></i>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<i><?php echo $i18n->__('Makse selgitusse kirjutage arve number')?></i>
					</td>
				</tr>
				 --> 
				
			</table>
		</div>
		
		
		
		<div id="invoice_table">
		
			<table id="listing" cellspacing="0"  border="0">
				<thead>
					<tr>
						<th colspan="6" style="height: 3px; background-color: #30613a; padding: 0;"></th>
					</tr>
					
					<tr>
						<th><?php echo $i18n->__('Kauba kood')?></th>
						<th><?php echo $i18n->__('Toode') . '/' .$i18n->__('Teenus')?></th>
						<th><?php echo $i18n->__('Km')?> %</th>
						<th><?php echo $i18n->__('Hind')?> (<?php echo $order['pay_in_currency']?>)</th>
						<th><?php echo $i18n->__('Kogus')?></th>
						<th><?php echo $i18n->__('Summa')?> (<?php echo $order['pay_in_currency']?>)</th>
					</tr>
					
					<tr>
						<th colspan="6" style="height: 1px; background-color: #488b1d; padding: 0;"></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach( $order->Shippings as $shipping ):?>
					<?php foreach( $shipping->OrederedItems as $item ):?>
						<tr>
							<td style="padding-left: 6px;"><?php echo $item->getCode()?></td>
							<td style="padding-left: 6px;"><?php echo $item->getName()?></td>
							<td style="padding-left: 6px;"><?php echo $item->getVatrate()?></td>
							<td style="padding-left: 6px;"><?php echo price_convert($item->getPrice(), $order['pay_in_currency'])?></td>
							<td style="padding-left: 6px;"><?php echo $item->getQuanity()?></td>
							<td style="padding-left: 6px;"><?php echo price_convert($item->getQuanity() * $item->getPrice(),$order['pay_in_currency'])?></td>
						</tr>
					<tr>
						<th colspan="6" style="height: 3px;"></th>
					</tr>
					<tr>
						<th colspan="6" style="height: 1px; background-color: #488b1d; padding: 0;"></th>
					</tr>
					<?php endforeach;?>
					<tr>
						<td style="padding-left: 6px;"><?php echo $i18n->__('Transport')?></td>
						<td style="padding-left: 6px;"><?php echo $shipping->getInformation()?></td>
						<td style="padding-left: 6px;"><?php echo $shipping->getVatrate()?></td>
						<td style="padding-left: 6px;"><?php echo price_convert($shipping->getCost(), $order['pay_in_currency'])?></td>
						<td style="padding-left: 6px;">-</td>
						<td style="padding-left: 6px;"><?php echo price_convert($shipping->getCost(),$order['pay_in_currency'])?></td>
					</tr>
					<tr>
						<th colspan="6" style="height: 5px;"></th>
					</tr>
					<tr>
						<td colspan="6" style="height: 3px; background-color: #30613a; padding: 0;"></td>
					</tr>
					<tr>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"><?php echo $i18n->__('Kokku KM-ta')?>:</td>
						<td style="padding-left: 6px;"><?php echo round(price_convert($basketCheckedOut->price(BasketCheckedOut::TOTAL_PAYABLE), $order['pay_in_currency']) * 0.8, 2) ?></td>
					</tr>
					<tr>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"><?php echo $i18n->__('Käibemaks')?> (20%):</td>
						<td style="padding-left: 6px;"><?php echo round(price_convert($basketCheckedOut->price(BasketCheckedOut::TOTAL_PAYABLE), $order['pay_in_currency']) * 0.2, 2) ?></td>
					</tr>
					<tr>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"><?php echo $i18n->__('Kokku')?>:</td>
						<td style="padding-left: 6px;"><?php echo price_convert($basketCheckedOut->price(BasketCheckedOut::TOTAL_PAYABLE), $order['pay_in_currency'])?></td>
					</tr>
					<tr>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px;"></td>
						<td style="padding-left: 6px; font-size: 11px; font-weight: bold;">
							<i><?php echo $i18n->__('Tasuda')?> EUR:</i>
						</td>
						<td style="padding-left: 6px; font-size: 11px; font-weight: bold;">
							<i><?php echo price_convert($basketCheckedOut->price(BasketCheckedOut::TOTAL_PAYABLE), 'EUR')?></i>
						</td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
			
		</div>
		
		<div id="signatures">
			<i><?php echo $i18n->__('Arve väljastas')?>:</i><br /><br />
			<i><?php echo $i18n->__('Kauba kätte saanud')?>:</i>
		</div>
		
		
	<div id="footer">
		<!-- Footer start -->
		<table>
			<tr>
				<th colspan="6" style="height: 5px; background-color: #30613a; padding: 0;"></th>
			</tr>
			<tr align="center">
				<td>
					<table align="center">
						<tr><td>Belander Grupp OÜ</td></tr>
						<tr><td>Tulika 1-6, 49303 Jõgeva</td></tr>
						<tr><td>Reg. nr.: 10694328</td></tr>
					</table>
				</td>
				<td>
					<table>
						<tr>
							<td>Tel:</td>
							<td>7751033</td>
						</tr>
						<tr>
							<td>Fax:</td>
							<td>7751033</td>
						</tr>
						<tr>
							<td>E-mail:</td>
							<td>asdasd@gmail.com</td>
						</tr>
					</table>
				</td>
				<td>
					<table>
						<tr><td>Swedbank 221015242386</td></tr>
						<tr><td>Nordea 17002356088</td></tr>
						<tr><td>SEB 10220104860013</td></tr>
						<tr><td>KMKR: EE100647884</td></tr>
					</table>
				</td>
			</tr>
		</table>
		<!-- Footer end -->
	</div>
		
	</body>
</html>
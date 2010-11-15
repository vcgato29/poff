<?php

############
# MUUTUJAD #
############

$VIHMAVEE_SYSTEEMI_RUUTMEETRI_HIND = 100;
$LISATARVIKUTE_RUUTMEETRI_HIND = 200;
$VANA_KATUSE_EEMALDAMISE_HIND = 400;



#####################
# PINDALA VAHEMIKUD #
#####################

$pindala_vahemik[] = array(
	'start' => 1,
	'end'	=> 100,
	'install_coef' => 1,
	'remove_coef' => 1
);

$pindala_vahemik[] = array(
	'start' => 101,
	'end'	=> 200,
	'install_coef' => 0.9,
	'remove_coef' => 0.9
);



##############
# MATERJALID #
##############

$materjal[] = array(
	'name' => 'Kivi profiil',
	'price' => 300,
);

$materjal[] = array(
	'name' => 'Metall profiil',
	'price' => 200,
);



##########
# K6RGUS #
##########

$k6rgus[] = array(
	'name' => 'Madal',
	'coef' => 1.05 // 1.05 * 100 = 105%
);

$k6rgus[] = array(
	'name' => 'Keskmine',
	'coef' => 1.10 // 1.05 * 100 = 105%
);



#############
# LIIGENDUS #
#############

$liigendus[] = array(
	'name' => 'Lihtne',
	'coef' => 1.05

);

$liigendus[] = array(
	'name' => 'Keeruline',
	'coef' => 1.15

);


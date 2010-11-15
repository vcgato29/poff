<?php
    /********************************************
     * Pangalingi n??iteprogramm                 *
     * (C) 2006 Margus Kaidja, Zone Media O??nbsp;   *
     ********************************************/

    require_once 'config.php';

    /**
     * Loome n??itliku ostukorvi ning nende v????rtuste p??hjal loome
     * vormi tehingu parameetritega.
     * Ostukorvi sisu v??iks tegelikult tulla andmebaasist, kus vastava
     * rea ID pannakse ka tehingu identifikaatoriks
     */
    $shoppingCart= Array(
                            /* Tehingu summa, mis klient tasuma peab */
                            'price'     => 1.5,

                            /* Valuuta, milles ta tasub */
                            'currency'  => 'LTL',

                            /* Teenuse/kauba kirjeldus */
                            'description' => 'Torso Tiger',

                            /* Tehingu identifikaator
                             * See on unikaalne v????rtus, millega saab identifitseerida
                             * k??esoleva tehingu. Kuna tehingu saatmine panka ning pangast
                             * vastuse lugemine toimuvad t??iesti eraldiseisvate protsessidena,
                             * siis on pangast vastuse lugemise skriptis ID j??rgi konkreetset
                             * tehingut tuvastada. */
                            'transaction_id' => 12345,
                        );

    /**
     * Loome massiivi tehingu andmetega, mis l??hevad panka
     */
    $macFields = Array(
                        'VK_SERVICE'    => '1001',
                        'VK_VERSION'    => '008',
                        'VK_SND_ID'     => $preferences['my_id'],
                        'VK_STAMP'      => $shoppingCart['transaction_id'],
                        'VK_AMOUNT'     => $shoppingCart['price'],
                        'VK_CURR'       => $shoppingCart['currency'],
                        'VK_ACC'        => $preferences['account_number'],
                        'VK_NAME'       => $preferences['account_owner'],
                        'VK_REF'        => '',
                        'VK_MSG'        => $shoppingCart['description'],
                        'VK_RETURN'     => 'http' . ($_SERVER['HTTPS'] ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] .
                                            dirname ($_SERVER['PHP_SELF']) . '/notify.php',
                    );

    /**
     * Genereerime tehingu v????rtustest signatuuri
     */
    $key = openssl_pkey_get_private (file_get_contents ($preferences['my_private_key']),
                                            $preferences['my_private_key_password']);

    if (!openssl_sign (generateMACString ($macFields), $signature, $key)) {
        trigger_error ("Unable to generate signature", E_USER_ERROR);
    }

    $macFields['VK_MAC'] = base64_encode ($signature);

    /**
     * Genereerime maksmise vormi
     */
    header ("Content-Type: text/html; charset=utf-8");
?>
<form method="POST" action="<?php echo $preferences['banklink_address']; ?>">
<?php
    foreach ($macFields as $f => $v) {
        echo '<input type="hidden" name="' . $f . '" value="' . htmlspecialchars ($v) . '" />' . "\n";
    }
?>
<table cellpadding="0" cellspacing="0" border="2">
    <tr>
        <td>Summa:</td>
        <td><?php echo htmlspecialchars ($shoppingCart['price'] . ' ' . $shoppingCart['currency']); ?>
    </tr>

    <tr>
        <td>Kellele:</td>
        <td><?php echo htmlspecialchars ($preferences['account_owner']) . ' (' . htmlspecialchars ($preferences['account_number']) . ')'; ?>
    </tr>

    <tr>
        <td>Mille eest:</td>
        <td><?php echo htmlspecialchars ($shoppingCart['description']); ?></td>
    </tr>

    <tr>
        <td>Tehingu ID:</td>
        <td><?php echo htmlspecialchars ($shoppingCart['transaction_id']); ?></td>
    </tr>

    <tr>
        <td colspan="2" align="center"><input type="submit" value="MAKSMA" /></td>
    </tr>
</table>
</form> 
<?php
    /********************************************
     * Pangalingi n??iteprogramm                 *
     * (C) 2006 Margus Kaidja, Zone Media O??nbsp;   *
     ********************************************/

    require_once 'config.php';

    /**
     * Koostame VK_* muutujatest massiivi
     */
    $macFields = Array ();

    foreach ((array)$_REQUEST as $f => $v) {
        if (substr ($f, 0, 3) == 'VK_') {
            $macFields[$f] = $v;
        }
    }

    /**
     * Kontrollime v????rtusi, mis pangast tulid.
     * Selleks arvutame nende v????rtuste p??hjal signatuuri ning
     * v??rdleme seda selle signatuuriga, mis pank koos v????rtustega meile saatis.
     */
    $key = openssl_pkey_get_public (file_get_contents ($preferences['bank_certificate']));

    if (!openssl_verify (generateMACString ($macFields), base64_decode ($macFields['VK_MAC']), $key)) {
        trigger_error ("Invalid signature", E_USER_ERROR);
    }

    header ("Content-Type: text/html; charset=utf-8");

    /**
     * Teavitame tehingu sooritajat tehingu ??nnestumisest v??i eba??nnestumisest
     */
    if ($macFields['VK_SERVICE'] == '1901') {

        echo '<h2><font color="red">Makse sooritamine katkestati!</font></h2>' . "\n";
?>
<table cellpadding="0" cellspacing="0" border="2">
    <tr>
        <td>Katkestatud tehingu ID:</td>
        <td><?php echo htmlspecialchars ($macFields['VK_STAMP']); ?></td>
    </tr>
</table>

<?php
    } else if ($macFields['VK_SERVICE'] == '1101') {

        echo '<h2><font color="green">Makse sooritamine ??nnestus!</font></h2>' . "\n";
?>
<table cellpadding="0" cellspacing="0" border="2">
    <tr>
        <td>Maksja:</td>
        <td><?php echo htmlspecialchars ($macFields['VK_SND_NAME'] . ' (' . $macFields['VK_SND_ACC'] .')'); ?></td>
    </tr>

    <tr>
        <td>Maksekorralduse number:</td>
        <td><?php echo htmlspecialchars ($macFields['VK_T_NO']); ?></td>
    </tr>

    <tr>
        <td>Summa:</td>
        <td><?php echo htmlspecialchars ($macFields['VK_AMOUNT'] . ' ' . $macFields['VK_CURR']); ?></td>
    </tr>

    <tr>
        <td>Tehingu identifikaator:</td>
        <td><?php echo htmlspecialchars ($macFields['VK_STAMP']); ?></td>
    </tr>
</table>
<?php
    }
?> 
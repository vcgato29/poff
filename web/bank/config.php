<?php
    /********************************************
     * Pangalingi n??iteprogramm                 *
     * (C) 2006 Margus Kaidja, Zone Media O??nbsp;   *
     ********************************************/

    /**
     * Pangaga suhtlemiseks vajalikud parameetrid
     */
    $preferences = Array(
                            /* Sertifikaadip??ringu loomisel saadud privaatv??tme fail */
                            'my_private_key'    => 'my_private_key.pem',
                            
                            /* Juhul, kui privaatv??ti on parooliga kaitstud, siis
                             * peab ka parool alati siin kirjas olema */
                            'my_private_key_password' => '',

                            /* Panga poolt saadetud sertifikaat */
                            'bank_certificate'  => 'bank_certificate.pem',

                            /* Panga poolt saadetud kaupmehe identifikaator */
                            'my_id'             => 'testvpos',

                            /* Pangakonto number, kuhu maksed laekuma hakkavad */
                            'account_number'    => '10002050618003',

                            /* Pangakonto omaniku nimi */
                            'account_owner'     => 'PANGAKONTO OMANIK',

                            /* Pangalingi aadress */
                            'banklink_address'  => 'https://www.seb.ee/cgi-bin/dv.sh/un3min.r',
                        );

    /**
     * P??ringute/vastuste muutujate j??rjekorrad
     */
    $VK_variableOrder = Array(
                                    1001 => Array(
                                                    'VK_SERVICE','VK_VERSION','VK_SND_ID',
                                                    'VK_STAMP','VK_AMOUNT','VK_CURR',
                                                    'VK_ACC','VK_NAME','VK_REF','VK_MSG'
                                                 ),

                                    1101 => Array(
                                                    'VK_SERVICE','VK_VERSION','VK_SND_ID',
                                                    'VK_REC_ID','VK_STAMP','VK_T_NO','VK_AMOUNT','VK_CURR',
                                                    'VK_REC_ACC','VK_REC_NAME','VK_SND_ACC','VK_SND_NAME',
                                                    'VK_REF','VK_MSG','VK_T_DATE'
                                                 ),

                                    1901 => Array(
                                                    'VK_SERVICE','VK_VERSION','VK_SND_ID',
                                                    'VK_REC_ID','VK_STAMP','VK_REF','VK_MSG'
                                                 ),
                                );

    /**
     * Genereerib sisseantud massiivi v????rtustest jada.
     * Jadasse lisatakse iga v????rtuse pikkus (kolmekohalise arvuna)
     * ning selle j??rel v????rtus ise.
     */
    function generateMACString ($macFields) {
        global  $VK_variableOrder;

        $requestNum = $macFields['VK_SERVICE'];

        $data = '';

        foreach ((array)$VK_variableOrder[$requestNum] as $key) {
            $v = $macFields[$key];
            $data .= str_pad (strlen ($v), 3, '0', STR_PAD_LEFT) . $v;
        }

        return $data;        
    }
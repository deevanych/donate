<?php
$ch = curl_init();
$re = "Лилоппа, молодец!";
$re = urlencode($re);
curl_setopt_array($ch, array(
    CURLOPT_URL => "https://tts.api.cloud.yandex.net/speech/v1/tts:synthesize?text=$re&folderId=b1g3cl7mgbqrd028u8vk",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer t1.9euelZqbm8eclJPNi5aUm5jHkJKdlO3rnpWazc2cyozHmorHj5WPl5Oajpnl8_cAdWl_-e93GRA0_d3z90AjZ3_573cZEDT9.x4_ALp17FxxePSD8nFhkA_Oq17oEN0ckq_UUpUsxhZXDqOMPWAR3sILtpSn99QCPnRpAT2yqVnZM_W_KwO7RAw'
    ),
));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    print "Error: " . curl_error($ch);
}
if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
    $decodedResponse = json_decode($response, true);
    echo "Error code: " . $decodedResponse["error_code"] . "\r\n";
    echo "Error message: " . $decodedResponse["error_message"] . "\r\n";
} else {
    file_put_contents("speech.ogg", $response);
}
curl_close($ch);

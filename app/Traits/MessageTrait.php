<?php

namespace App\Traits;

trait MessageTrait
{
    //send message
    public function sendMessage(string $phoneNumber, string $message)
    {

        $phoneNumber = $this->formatMobileInternational($phoneNumber);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.africastalking.com/version1/messaging',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "username=madiniapp&to=" . urlencode($phoneNumber) . "&message=" . urlencode($message),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
                'apiKey: 794f87384eae80d8c961cceacd4e9e5e6445248557508dcb1d1b6a7216f693e1'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    public function formatMobileInternational($mobile)
    {
        $length = strlen($mobile);
        $m = '+256';
        //format 1: +256752665888
        if ($length == 13)
            return $mobile;
        elseif ($length == 12) //format 2: 256752665888
            return "+" . $mobile;
        elseif ($length == 10) //format 3: 0752665888
            return $m .= substr($mobile, 1);
        elseif ($length == 9) //format 4: 752665888
            return $m .= $mobile;

        return $mobile;
    }

    
}

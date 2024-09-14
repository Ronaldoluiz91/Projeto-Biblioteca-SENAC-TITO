<?php

class Crypt {
     private $PassOUT;
     private $HashOUT;

     public function CryptPass(string $Cemail, string $Cpass){

        $apikey = "maçã";
        $apikey = (md5($apikey));

        $userEmailC = (md5($Cemail));
        $userPasswordC = (md5($Cpass));

        $passWordC = (md5($apikey . $userPasswordC . $userEmailC));

        $custPassword = "09";
        $saltPassword = $passWordC;

        $passWordC = crypt($userEmailC, '$2b$' . $custPassword . '$' . $saltPassword . '$');

        return $PassOUT = $passWordC;
     }


      public function CryptHash(string $Cemail, string $Cpass){

        $apikey = "maçã";
        $apikey = (md5($apikey));
        $userEmailC = (md5($Cemail));

        $dateTime = new DateTime(null, new DateTimeZone('America/Sao_Paulo'));

        $formattedDate = $dateTime->format('Y-m-d H-i-s');

        $Cpass = $Cpass.$formattedDate;

        
        $userPasswordC = (md5($Cpass));

        $hashC = (md5($apikey . $userEmailC . $userPasswordC));

        $custHash = "08";
        $saltHash = $hashC;

        $hashC = crypt($userEmailC, '$2b$' . $custHash . '$' . $saltHash . '$');

        return $HashOUT = $hashC;
     }
}

?>
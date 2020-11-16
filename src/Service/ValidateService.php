<?php

namespace App\Service;

class ValidateService
{
    public function isPostCodeValid($validPostCodes, $postcode)
    {
        foreach ($validPostCodes as $validPostCode) {
            if (strpos($postcode, $validPostCode) === 0) {

                return true;
            }
        }

        return false;
    }
}

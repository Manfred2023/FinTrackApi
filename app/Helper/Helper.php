<?php
/*
 *  BuildTrackApi
 *
 *  Created by Manfred MOUKATE on 1/7/25, 10:15 AM,
 *  Email moukatemanfred@gmail.com
 *  Copyright (c) 2025. All rights reserved.
 *  Last modified 1/7/25, 10:15 AM
 */

namespace Helper;
class Helper
{
    static public function isEmailFormatValid(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    static public function isCameroonianPhoneNumber($phoneNumber)
    {
        $pattern = "/^6[5789][0-9]{7}$/";
        return preg_match($pattern, $phoneNumber) === 1;
    }



}
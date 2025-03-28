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
class Constant
{
    ///APP INFORMATION
    public const APP_NAME = "FinTrack";
    public const APP_VERSION = "1.0.0";
    ///APP VARIABLE
    public const JWT_KEY = "faacd77c-164b-4137-8dbc-33b0f5638ffb";
    public const TOKEN = "token";
    public const NICKNAME = "nickname";
    public const MOBILE = "mobile";
    public const EMAIL = "email";
    public const ID = "id";
    public const ADMIN = "admin";
    public const PIN = "pin";
    public const BLOCKED = "blocked";
    public const USER = "user";
    public const AMOUNT = "amount";
    public const ACCOUNT = "account";
    public const MOTIF = "motif";
    public const TYPE = "type";
    public const APP = "app";
    public const NAME = "name";
    public const VERSION = "version";
    public const CONTACT = "contact";
    public const LOCATION = "location";

    ///APP ERROR
    public const USER_NOT_FOUND = "user_not_found";
    public const ACCOUNT_NOT_FOUND = "account_not_found";
    public const CONTACT_NOT_FOUND = "contact_not_found";
    public const MOTIF_ALREADY_EXIST = "motif_already_exist";
    public const CONTACT_ALREADY_EXIST = "contact_already_exist";
    public const MOTIF_NOT_FOUND = "motif_not_found";
    public const INVALID_PIN = "invalid_pin";
    public const INVALID_NAME = "invalid_name";
    public const INVALID_EMAIL = "invalid_email";
    public const INVALID_MOBILE = "invalid_mobile";
    public const MOBILE_ALREADY_USED = "mobile_already_used";
    public const EMAIL_ALREADY_USED = "email_already_used";
    public const AUTHENTICATION_FAILED = "authentication_failed";
    public const AUTHENTICATION_SUCCESS = "authentication_success";
}

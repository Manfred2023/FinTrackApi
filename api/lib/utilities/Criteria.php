<?php
/*
 *  BuildTrackApi
 *
 *  Created by Manfred MOUKATE on 1/7/25, 10:15 AM,
 *  Email moukatemanfred@gmail.com
 *  Copyright (c) 2025. All rights reserved.
 *  Last modified 1/7/25, 10:15 AM
 */

class Criteria
    {
        const ID = 0;
        const TOKEN = 1;
        const USER = 20;
        const UUID = 17;
        const MOBILE = 27;
        const TOWN = 27;

        const NAME  = 30;

        /**
         * @param array|null $fields
         * @param array|null $request
         * @return void
         * @throws Exception
         */
        static public function _formRequiredCheck(?array $fields, ?array $request): void
        {
            if (empty($request))
                throw new Exception("Empty request not accepted here!");

            foreach ($fields as $field)
                if (!array_key_exists($field, $request))
                    throw new Exception("{$field} missing in your request!");

        }

    }
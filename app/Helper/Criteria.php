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
use Exception;

class Criteria
{

    /**
     * @param array|null $fields
     * @param array|null $request
     * @return void
     * @throws Exception
     */
    static public function _formRequiredCheck(?array $fields, ?array $request): void
    {
        if (empty($request))
            Reply::_error("Empty request not accepted here!",code: 400);


        foreach ($fields as $field)
            if (!array_key_exists($field, $request))
                Reply::_error("{$field} missing in your request!",code: 400);
                //throw new Exception("{$field} missing in your request!");

    }

}
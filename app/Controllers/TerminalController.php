<?php
/*
 *  BuildTrackApi
 *
 *  Created by Manfred MOUKATE on 1/7/25, 10:15 AM,
 *  Email moukatemanfred@gmail.com
 *  Copyright (c) 2025. All rights reserved.
 *  Last modified 1/7/25, 10:15 AM
 */

use Helper\Constant;
use Helper\Criteria;
use Helper\Jwt;
use Helper\Reply;

if (!require realpath(dirname(__DIR__, 2)) . '/conf.php') {
    http_response_code(403);
    exit;
}

require_once dirname(__DIR__, 2) . '/lib/utilities/Constant.php';

try {
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    Criteria::_formRequiredCheck([APP, VERSION,], $data);

    if (Constant::APP_NAME != $data[APP])
        Reply::_error("invalid_application_identifier", code: 400);
    if (Constant::APP_VERSION != $data[VERSION])
        Reply::_error("you_need_to_upgrade_your_apk", code: 400);

    $JwtController = new Jwt('cc6fb08a-6725-4016-a1d9-09a486bf26ec');

    Reply::_successBearer($JwtController->encode('cc6fb08a-6725-4016-a1d9-09a486bf26ec'), type: 'reference');


} catch (Exception $exception) {
    Reply::_exception($exception);
}

?>

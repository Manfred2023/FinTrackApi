<?php


namespace App\Controllers;
use Helper\Constant;
use Helper\Criteria;
use Helper\Jwt;
use Helper\Reply;

class TerminalController{

    /**
     * @throws \Exception
     */
    public function getBearerToken(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);
        Criteria::_formRequiredCheck([
            Constant::APP,
            Constant::VERSION,
        ], $data);

        if (Constant::APP_VERSION != $data[Constant::VERSION])
            Reply::_error(" you_need_to_upgrade_your_apk", code: 400);
        if (Constant::APP_NAME != $data[Constant::APP])
            Reply::_error("Invalid_application_name", code: 400);

        $JwtController = new Jwt(Constant::JWT_KEY);

        Reply::_successBearer($JwtController->encode( Constant::JWT_KEY), type: 'reference');
    }
}
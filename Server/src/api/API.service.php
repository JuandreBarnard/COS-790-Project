<?php

require_once __DIR__ . '/../../src/services/services.inc.php';

class APIService{
    /**
     * Constant type definers.
     */
    const PRIVATE_API = 0x01;
    const PUBLIC_API = 0x02;
    
    ////////////////////////////////////////////////////////////////////////////
    // EXPOSED FUNCTIONS
    ////////////////////////////////////////////////////////////////////////////
    public function authorise(PDO $db, $type, $endPointType = NULL){
        switch($type){
            case APIService::PRIVATE_API: return $this->authorisePrivateAPI($db);
            case APIService::PUBLIC_API: return $this->authorisePublicAPI($db, $endPointType);
            default: return new ErrorResponse('Invalid API type defined.');
        }
    }
    
    ////////////////////////////////////////////////////////////////////////////
    // PRIVATE FUNCTIONS
    ////////////////////////////////////////////////////////////////////////////
    private function authorisePrivateAPI(PDO $db){
        require_once __DIR__ . '/../../src/account/Users.service.php';
        $usersService = new UsersService();
        return $usersService->isLoggedIn($db);
    }
    
    private function authorisePublicAPI(PDO $db, $endPointType){
        require_once __DIR__ . '/../../src/applications/CWebOAuth.server.php';
        $oauthServer = new CWebOAuthServer($db);
        return $oauthServer->checkEndpoint($endPointType);
    }
}

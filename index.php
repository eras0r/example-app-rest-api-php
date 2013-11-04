<?php

require_once 'vendor/autoload.php';

// CORS hack (UI can be on different domain than API)
// e.g. 	API: 	http://localhost/
// 	 		UI:		http://localhost:9000
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Max-Age: 86400");
header('Access-Control-Request-Method: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With");

try {
    $app = new Tonic\Application(array(
        'load' => 'resource/*/*.php'
    ));

    $request = new Tonic\Request();

    $resource = $app->getResource($request);
    $response = $resource->exec();
    // TODO the line below is not really needed
    //$response->contentType = "application/json";
} catch (Tonic\NotFoundException $e) {
    $response = new Tonic\Response(Tonic\Response::NOTFOUND, 'Not found');

} catch (Tonic\UnauthorizedException $e) {
    $response = new Tonic\Response(Tonic\Response::UNAUTHORIZED, 'Unauthorized');
    $response->wwwAuthenticate = 'Basic realm="My Realm"';

} catch (Tonic\Exception $e) {
    echo $e;
    $response = new Tonic\Response(Tonic\Response::INTERNALSERVERERROR, 'Server error');
}

$response->output();

?>
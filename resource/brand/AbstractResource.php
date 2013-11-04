<?php

require_once 'vendor/autoload.php';

abstract class AbstractResource extends Tonic\Resource
{

    // constructor for resources do have to invokce parent constructor and must have exactly this signature
    function __construct(Tonic\Application $app, Tonic\Request $request)
    {
        parent::__construct($app, $request);
    }

    //TODO comment
    //TODO use ORM mapper
    protected function connectDb()
    {
        $link = new mysqli("localhost", "webstack", "8MuYHPNG2SxZSWzy", "webstack");
        // check connection
        if ($link->connect_errno) {
            printf("Connect failed: %s\n", $link->connect_error);
            // TODO throw exception
        }
        return $link;
    }

    /**
     * Needed for CORS (UI can be on different domain than API).
     * e.g.     API:     http://localhost/
     *           UI:     http://localhost:9000
     * @method OPTIONS
     * @provides application/json
     */
    function options()
    {

    }

}

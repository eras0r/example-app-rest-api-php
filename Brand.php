<?php

require_once 'vendor/autoload.php';


/**
 * This class defines an example resource that is wired into the URI /example
 * @uri /brands
 */
class BrandCollection extends Tonic\Resource
{


    /**
     * @json
     * @method GET
     * @provides application/json
     */
    function getAll()
    {
        $link = connectDb();

        $brands = array();

        // Select queries return a resultset
        if ($result = $link->query("SELECT * FROM brand")) {
            while ($obj = $result->fetch_object()) {
                $brands[] = $obj;
            }

            // free result set
            mysqli_free_result($result);
        }

        return json_encode($brands);
    }

    /**
     * @method POST
     * @accepts application/json
     */
    function add()
    {
        // decode json object
        $brand = json_decode($this->request->data);

        // TODO proper validation
        if (empty($brand->name) || empty($brand->country)) {
            return new Tonic\Response(Tonic\Response::NOTACCEPTABLE);
        } else {
            $link = connectDb();
            $link->query("INSERT INTO brand (name, country) VALUES ('" . $brand->name . "', '" . $brand->country . "')");
            return new Tonic\Response(Tonic\Response::CREATED);
        }

        return new Tonic\Response(Tonic\Response::CREATED);
    }

    /**
     * @method OPTIONS
     * @provides application/json
     */
    function options()
    {
        // CORS hack (UI can be on different domain than API)
        // e.g. 	API: 	http://localhost/
        // 	 		UI:		http://localhost:9000
        /*
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true' );
        header("Access-Control-Max-Age: 86400");
        header('Access-Control-Request-Method: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With");
        */
    }

}

/**
 * This class defines an example resource that is wired into the URI /example
 * @uri /brands/:id
 */
class BrandResource extends Tonic\Resource
{

    /**
     * @method GET
     * @provides application/json
     */
    function display()
    {
        $link = connectDb();
        $result = $link->query("SELECT * FROM brand WHERE id = '$this->id'");
        $brand = $result->fetch_object();
        mysqli_free_result($result);
        return json_encode($brand);
    }

    /**
     * @method PUT
     * @accepts application/json
     * @provides application/json
     */
    function update()
    {
        $brand = json_decode($this->request->data);

        // TODO proper validation
        if (empty($brand->name) || empty($brand->country)) {
            return new Tonic\Response(Tonic\Response::NOTACCEPTABLE);
        } else {
            $link = connectDb();
            $result = $link->query("UPDATE brand SET name='$brand->name', country='$brand->country' WHERE id = '$this->id'");
            $brand = $result->fetch_object();
            mysqli_free_result($result);
        }

        return $this->display();
    }

    /**
     * @method DELETE
     */
    function remove()
    {
        $link = connectDb();
        $result = $link->query("DELETE FROM brand WHERE id = '$this->id'");
        mysqli_free_result($result);
        return new Tonic\Response(Tonic\Response::NOCONTENT);
    }

    /**
     * @method OPTIONS
     * @provides application/json
     */
    function options()
    {
        // CORS hack (UI can be on different domain than API)
        // e.g. 	API: 	http://localhost/
        // 	 		UI:		http://localhost:9000
        /*
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true' );
        header("Access-Control-Max-Age: 86400");
        header('Access-Control-Request-Method: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With");
        */
    }

}

?>
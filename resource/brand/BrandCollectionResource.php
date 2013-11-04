<?php

require_once 'vendor/autoload.php';

/**
 * This class defines an example resource that is wired into the URI /example
 * @uri /brands
 * @uri /brands/
 */
class BrandCollectionResource extends AbstractResource
{

    /**
     * TODO comment
     *
     * @json
     * @method GET
     * @provides application/json
     */
    public function getAll()
    {
        $link = $this->connectDb();

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
     * TODO comment
     *
     * @method POST
     * @accepts application/json
     */
    public function add()
    {
        // decode json object
        $brand = json_decode($this->request->data);

        // TODO proper validation
        if (empty($brand->name) || empty($brand->country)) {
            return new Tonic\Response(Tonic\Response::NOTACCEPTABLE);
        } else {
            $link = $this->connectDb();
            $link->query("INSERT INTO brand (name, country) VALUES ('" . $brand->name . "', '" . $brand->country . "')");
            return new Tonic\Response(Tonic\Response::CREATED);
        }

        return new Tonic\Response(Tonic\Response::CREATED);
    }

}

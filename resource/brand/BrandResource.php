<?php

require_once 'vendor/autoload.php';

/**
 * This class defines an example resource that is wired into the URI /example
 * @uri /brands/:id
 * @uri /brands/:id/
 */
class BrandResource extends AbstractResource
{

    /**
     * TODO comment
     *
     * @method GET
     * @provides application/json
     */
    public function display()
    {
        $link = $this->connectDb();
        $result = $link->query("SELECT * FROM brand WHERE id = '$this->id'");
        $brand = $result->fetch_object();
        mysqli_free_result($result);
        return json_encode($brand);
    }

    /**
     * TODO comment
     *
     * @method PUT
     * @accepts application/json
     * @provides application/json
     */
    public function update()
    {
        $brand = json_decode($this->request->data);

        // TODO proper validation
        if (empty($brand->name) || empty($brand->country)) {
            return new Tonic\Response(Tonic\Response::NOTACCEPTABLE);
        } else {
            $link = $this->connectDb();
            $result = $link->query("UPDATE brand SET name='$brand->name', country='$brand->country' WHERE id = '$this->id'");
            $brand = $result->fetch_object();
            mysqli_free_result($result);
        }

        return $this->display();
    }

    /**
     * TODO comment
     *
     * @method DELETE
     */
    public function remove()
    {
        $link = $this->connectDb();
        $result = $link->query("DELETE FROM brand WHERE id = '$this->id'");
        mysqli_free_result($result);
        return new Tonic\Response(Tonic\Response::NOCONTENT);
    }

}
<?php

/**
 * This class defines an example object of a possible business object model.
 */
class Brand {

    // TODO must be public to be considered during json_encode :-(
    public $id;

    public $name;

    public $country;

    function __construct($name, $country) {
        $this->name = $name;
        $this->country = $country;
    }

    public function getName() {
        return $this->name;
    }

}



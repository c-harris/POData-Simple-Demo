<?php

namespace models;

use charris\PODataSimple\SimpleEntityTrait ;

class Product {

    // This trait contains method for fields mapping (between database table and this class)
    use SimpleEntityTrait;

    public $id;
    public $added_at;
    public $name;
    public $weight;
    public $code;
}

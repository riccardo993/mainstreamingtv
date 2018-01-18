<?php
namespace riccardo993\mainstreamingtv\Vod\Resource;

use riccardo993\mainstreamingtv\Vod\Category;

class Categories{
    protected $categories = [];

    public function __construct(array $categories = []) {
        foreach ($categories as $category) {
            array_push($this->categories, new Category($category));
        }
    }

    public function all()
    {
        return $this->categories;
    }

    public function first()
    {
        if(! empty($this->categories))
            return $this->categories[0];

        return null;
    }

    public function find($name)
    {
        $object = array_filter($this->categories, function($obj) use($name){
            return strtolower($obj->getDescription()) == strtolower($name);
        });

        return $object[0] ?? null;
    }
}

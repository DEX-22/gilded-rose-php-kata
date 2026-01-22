<?php

namespace GildedRose\Contexts;

use GildedRose\Contracts\UpdateProduct;

class UpdateProductContext{
    private UpdateProduct $strategy;
    public function setStrategy(UpdateProduct $product){
        $this->strategy = $product;
    }
    public function updateValues(){
        $this->strategy->update();
    }
}

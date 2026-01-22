<?php

namespace GildedRose\Strategies;

use GildedRose\Contracts\UpdateProduct;
use GildedRose\Item;

class SulfurasStrategy implements UpdateProduct{


    public function __construct(private Item $item) {
    }
    public function update(){}
}
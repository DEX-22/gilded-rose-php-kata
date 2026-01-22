<?php

namespace GildedRose\Strategies;

use GildedRose\Contracts\UpdateProduct;
use GildedRose\Item;

class AgedBrieStrategy implements UpdateProduct{

    private int $MAX_QUALITY = 50;

    public function __construct(private Item $item) {
    }
    public function update(){
        $incrementIn = $this->item->sellIn > 0 ? 1 : 2;

        if ($this->item->quality + $incrementIn >= $this->MAX_QUALITY) {
            $this->item->quality = $this->MAX_QUALITY;
        } else {
            $this->item->quality += $incrementIn;
        }

        $this->item->sellIn--;
    }
}
<?php

namespace GildedRose\Strategies;

use GildedRose\Contracts\UpdateProduct;
use GildedRose\Item;


class ConjuredStrategy implements UpdateProduct{

    private int $MIN_QUALITY = 0;
    public function __construct(private Item $item) {
    }
    public function update(){
        $decrementIn = $this->item->sellIn >= 0 ? 2 : 4;

        if ($this->item->quality - $decrementIn <= $this->MIN_QUALITY) {
            $this->item->quality = $this->MIN_QUALITY;
        } else {
            $this->item->quality -= $decrementIn;
        }

        $this->item->sellIn--;
    }
}
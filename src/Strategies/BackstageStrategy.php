<?php

namespace GildedRose\Strategies;

use GildedRose\Contracts\UpdateProduct;
use GildedRose\Item;

class BackstageStrategy implements UpdateProduct{

    private int $MAX_QUALITY = 50;

    public function __construct(private Item $item) {
    }
    public function update(){
        $incrementIn = 0;
        switch (true) {
            case $this->item->sellIn <= 0:
                $incrementIn = 0;
                break;
            case $this->item->sellIn <= 5:
                $incrementIn += 3;
                break;
            case $this->item->sellIn <= 10:
                $incrementIn += 2;
                break;
            default:
                $incrementIn++;
                break;
        }

        if ($incrementIn === 0) {
            $this->item->quality = 0;
        } else {
            $this->item->quality = $this->item->quality + $incrementIn <= $this->MAX_QUALITY ?
                $this->item->quality + $incrementIn :
                $this->MAX_QUALITY;
        }

        $this->item->sellIn--;
    }
}
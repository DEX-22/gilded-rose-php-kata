<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {

        $products = [
            "Aged Brie" => AgedBrieStrategy::class, 
            "Backstage passes to a TAFKAL80ETC concert" => BackstageStrategy::class, 
            "Sulfuras, Hand of Ragnaros" => SulfurasStrategy::class, 
            "Conjured Mana Cake" => ConjuredStrategy::class, 
            "normal" => NormalProductStrategy::class
        ];

        $context = new UpdateProductContext();
        foreach ($this->items as $item) {
            $handler = $products[$item->name] ?? $products["normal"];
            
            $product = new $handler($item);
            
            $context->setStrategy($product);
            $context->updateValues();
        }
    }
}

class UpdateProductContext{
    private UpdateProduct $strategy;
    public function setStrategy(UpdateProduct $product){
        $this->strategy = $product;
    }
    public function updateValues(){
        $this->strategy->update();
    }
}


interface UpdateProduct{
    public function update();
}

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
class SulfurasStrategy implements UpdateProduct{


    public function __construct(private Item $item) {
    }
    public function update(){}
}

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

class NormalProductStrategy implements UpdateProduct{

    private int $MIN_QUALITY = 0;
    public function __construct(private Item $item) {
    }
    public function update(){
        $decrementIn = $this->item->sellIn > 0 ? 1 : 2;

        if ($this->item->quality - $decrementIn <= $this->MIN_QUALITY) {
            $this->item->quality = $this->MIN_QUALITY;
        } else {
            $this->item->quality -= $decrementIn;
        }

        $this->item->sellIn--;
    }
}

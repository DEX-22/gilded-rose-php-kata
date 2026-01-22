<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Contexts\UpdateProductContext;
use GildedRose\Contracts\UpdateProduct;
use GildedRose\Strategies\AgedBrieStrategy;
use GildedRose\Strategies\BackstageStrategy;
use GildedRose\Strategies\ConjuredStrategy;
use GildedRose\Strategies\NormalProductStrategy;
use GildedRose\Strategies\SulfurasStrategy;

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

        foreach ($this->items as $item) {
            $handler = $products[$item->name] ?? $products["normal"];
            
            $product = new $handler($item);
            
            $product->update();
        }
    }
}


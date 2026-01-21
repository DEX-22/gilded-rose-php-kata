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
        $AGED_BRIE = 'Aged Brie';
        $BACKSTAGE = 'Backstage passes to a TAFKAL80ETC concert';
        $SULFURAS = 'Sulfuras, Hand of Ragnaros';
        $CONJURED = 'Conjured Mana Cake';

        $MAX_QUALITY = 50;

        foreach ($this->items as $item) {
            switch ($item->name) {
                case $AGED_BRIE:

                    $incrementIn = $item->sellIn > 0 ? 1 : 2;

                    if ($item->quality + $incrementIn >= $MAX_QUALITY) {
                        $item->quality = $MAX_QUALITY;
                    } else {
                        $item->quality += $incrementIn;
                    }

                    $item->sellIn--;

                    break;
                case $BACKSTAGE:
                    $incrementIn = 0;
                    switch (true) {
                        case $item->sellIn <= 0:
                            $incrementIn = 0;
                            break;
                        case $item->sellIn <= 5:
                            $incrementIn += 3;
                            break;
                        case $item->sellIn <= 10:
                            $incrementIn += 2;
                            break;
                        default:
                            $incrementIn++;
                            break;
                    }

                    if ($incrementIn === 0) {
                        $item->quality = 0;
                    } else {
                        $item->quality = $item->quality + $incrementIn <= $MAX_QUALITY ?
                            $item->quality + $incrementIn :
                            $MAX_QUALITY;
                    }

                    $item->sellIn--;

                    break;
                case $SULFURAS:
                    break;
                case $CONJURED:
                    $decrementIn = $item->sellIn >= 0 ? 2 : 4;

                    if ($item->quality - $decrementIn <= 0) {
                        $item->quality = 0;
                    } else {
                        $item->quality -= $decrementIn;
                    }

                    $item->sellIn--;
                    break;
                default:

                    $decrementIn = $item->sellIn > 0 ? 1 : 2;

                    if ($item->quality - $decrementIn <= 0) {
                        $item->quality = 0;
                    } else {
                        $item->quality -= $decrementIn;
                    }

                    $item->sellIn--;

                    break;
            }
        }
    }
}

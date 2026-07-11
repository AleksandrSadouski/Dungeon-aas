<?php

namespace App\Constants;

class ChanceConst
{
    const CHANCE_TYPES = ['monster' => 30, 'chest' => 20, 'empty' => 25, 'healer' => 20, 'armor' => 5];

    const CHANCE_SUBTYPES_MONSTER = ['shrekell' => 60, 'tormin' => 30, 'grosstroyts' => 10];
    const CHANCE_SUBTYPES_CHEST = ['wooden' => 60, 'iron' => 20, 'golden' => 15, 'diamond' => 5];
    const CHANCE_SUBTYPES_ARMOR = ['chainmail' => 70, 'ironclad' => 30];
    const CHANCE_SUBTYPES_HEALER = ['herbs' => 40, 'potion' => 30, 'bonesetter' => 25, 'anatomist' => 5];
    const CHANCE_SUBTYPES_EMPTY = ['empty' => 100];
}
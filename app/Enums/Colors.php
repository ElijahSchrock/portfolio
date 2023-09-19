<?php

namespace App\Enums;

enum Colors: string
{
    case GRAY = 'gray';
    case RED = 'red';
    case ORANGE = 'orange';
    case AMBER = 'amber';
    case YELLOW = 'yellow';
    case LIME = 'lime';
    case GREEN = 'green';
    case EMERALD = 'emerald';
    case TEAL = 'teal';
    case SKY = 'sky';
    case INDIGO = 'indigo';
    case BLUE = 'blue';
    case CYAN = 'cyan';
    case PINK = 'pink';
    case ROSE = 'rose';

    public function description(): string
    {
        return match ($this) {
            Colors::GRAY => 'gray',
            Colors::RED => 'red',
            Colors::ORANGE => 'orange',
            Colors::AMBER => 'amber',
            Colors::YELLOW => 'yellow',
            Colors::LIME => 'lime',
            Colors::GREEN => 'green',
            Colors::EMERALD => 'emerald',
            Colors::TEAL => 'teal',
            Colors::SKY => 'sky',
            Colors::INDIGO => 'indigo',
            Colors::BLUE => 'blue',
            Colors::CYAN => 'cyan',
            Colors::PINK => 'pink',
            Colors::ROSE => 'rose',
            default => 'indigo'
        };
    }
}

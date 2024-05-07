<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Stack
{
    public const STACK_DIRECTIONS = [
        self::DIRECTION_COLUMN,
        self::DIRECTION_ROW,
    ];

    public const STACK_SPACINGS = [
        self::SPACING_DENSE,
        self::SPACING_STANDARD,
        self::SPACING_AIRY,
        self::SPACING_2X_STANDARD,
        self::SPACING_3X_STANDARD,
        self::SPACING_4X_STANDARD,
    ];

    public const STACK_COLUMNS_AT_BREAKPOINTS = [
        self::STACK_COLUMNS_AT_NEVER,
        self::STACK_COLUMNS_AT_MOBILE,
        self::STACK_COLUMNS_AT_TABLET,
    ];
    private const DIRECTION_COLUMN = 'column';
    private const DIRECTION_ROW = 'row';

    private const SPACING_DENSE = 'dense';
    private const SPACING_STANDARD = 'standard';
    private const SPACING_AIRY = 'airy';
    private const SPACING_2X_STANDARD = '2x-standard';
    private const SPACING_3X_STANDARD = '3x-standard';
    private const SPACING_4X_STANDARD = '4x-standard';

    private const STACK_COLUMNS_AT_NEVER = 'never';
    private const STACK_COLUMNS_AT_MOBILE = 'mobile';
    private const STACK_COLUMNS_AT_TABLET = 'tablet';

    public string $direction = self::DIRECTION_COLUMN;
    public string $space = self::SPACING_STANDARD;
    public string $stackColumnsAt = self::STACK_COLUMNS_AT_NEVER;
    public bool $reverseColumnsWhenStacked = false;

    public function getDirections(): array
    {
        return self::STACK_DIRECTIONS;
    }

    public function getSpacings(): array
    {
        return self::STACK_SPACINGS;
    }

    public function getStackColumnsAtBreakpoints(): array
    {
        return self::STACK_COLUMNS_AT_BREAKPOINTS;
    }
}

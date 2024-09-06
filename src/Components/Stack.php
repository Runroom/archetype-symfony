<?php

declare(strict_types=1);

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/stack.html.twig')]
class Stack
{
    public const array STACK_DIRECTIONS = [
        self::DIRECTION_COLUMN,
        self::DIRECTION_ROW,
    ];

    public const array STACK_SPACINGS = [
        self::SPACING_DENSE,
        self::SPACING_STANDARD,
        self::SPACING_AIRY,
        self::SPACING_2X_STANDARD,
        self::SPACING_3X_STANDARD,
        self::SPACING_4X_STANDARD,
    ];

    public const array STACK_COLUMNS_AT_BREAKPOINTS = [
        self::STACK_COLUMNS_AT_NEVER,
        self::STACK_COLUMNS_AT_MOBILE,
        self::STACK_COLUMNS_AT_TABLET,
    ];
    private const string DIRECTION_COLUMN = 'column';
    private const string DIRECTION_ROW = 'row';

    private const string SPACING_DENSE = 'dense';
    private const string SPACING_STANDARD = 'standard';
    private const string SPACING_AIRY = 'airy';
    private const string SPACING_2X_STANDARD = '2x-standard';
    private const string SPACING_3X_STANDARD = '3x-standard';
    private const string SPACING_4X_STANDARD = '4x-standard';

    private const string STACK_COLUMNS_AT_NEVER = 'never';
    private const string STACK_COLUMNS_AT_MOBILE = 'mobile';
    private const string STACK_COLUMNS_AT_TABLET = 'tablet';

    public string $direction = self::DIRECTION_COLUMN;
    public string $space = self::SPACING_STANDARD;
    public string $stackColumnsAt = self::STACK_COLUMNS_AT_NEVER;
    public bool $reverseColumnsWhenStacked = false;

    /**
     * @return array<string>
     */
    public function getDirections(): array
    {
        return self::STACK_DIRECTIONS;
    }

    /**
     * @return array<string>
     */
    public function getSpacings(): array
    {
        return self::STACK_SPACINGS;
    }

    /**
     * @return array<string>
     */
    public function getStackColumnsAtBreakpoints(): array
    {
        return self::STACK_COLUMNS_AT_BREAKPOINTS;
    }
}

<?php

namespace App\Constants;

class TaskPriority
{
    public const LOW = 'Low';
    public const MEDIUM = 'Medium';
    public const HIGH = 'High';
    public const URGENT = 'Urgent';

    public static function all(): array
    {
        return [
            [
                'name' => self::LOW,
                'color' => '#64748b',
                'icon' => '<i class="bi bi-arrow-down-short"></i>',
            ],
            [
                'name' => self::MEDIUM,
                'color' => '#eab308',
                'icon' => '<i class="bi bi-dash-short"></i>',
            ],
            [
                'name' => self::HIGH,
                'color' => '#f97316',
                'icon' => '<i class="bi bi-arrow-up-short"></i>',
            ],
            [
                'name' => self::URGENT,
                'color' => '#ef4444',
                'icon' => '<i class="bi bi-exclamation-triangle"></i>',
            ],
        ];
    }

    public static function get($name): ?array
    {
        return collect(self::all())->firstWhere('name', $name);
    }
}

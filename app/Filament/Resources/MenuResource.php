<?php

namespace App\Filament\Resources;

use Datlechin\FilamentMenuBuilder\Resources\MenuResource as BaseMenuResource;

class MenuResource extends BaseMenuResource
{
    protected static ?int $navigationSort = 99;

    protected static ?string $navigationIcon = 'fluentui-navigation-16';


    protected static ?string $modelLabel = '菜单';
    protected static ?string $pluralModelLabel = '菜单';
    public static function getNavigationGroup(): ?string
    {
        return "前台";
    }
}

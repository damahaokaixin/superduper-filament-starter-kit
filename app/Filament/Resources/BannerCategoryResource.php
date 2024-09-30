<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerCategoryResource\Pages;
use App\Models\BannerCategory;
use Filament\Forms;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BannerCategoryResource extends Resource
{
    protected static ?string $model = BannerCategory::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = -1;
    protected static ?string $navigationIcon = 'fluentui-stack-20';
    protected static ?string $navigationLabel = '横幅分类';
    protected static ?string $modelLabel = '横幅分类';
    protected static ?string $pluralModelLabel = '横幅分类';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('parent_id')
                    ->label('父分类')
                    ->options(BannerCategory::all()->pluck('name', 'id'))
                    ->searchable()
                    ->nullable()
                    ->columnSpan('full'),

                Forms\Components\TextInput::make('name')
                    ->label('名称')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                Forms\Components\TextInput::make('slug')
                    ->label('别名')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(255)
                    ->unique(BannerCategory::class, 'slug', ignoreRecord: true),

                Forms\Components\MarkdownEditor::make('description')
                    ->label('描述')
                    ->columnSpan('full'),

                Forms\Components\Toggle::make('is_active')
                    ->label('是否激活')
                    ->default(true),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('name')
                    ->label('名称'),
                Infolists\Components\TextEntry::make('slug')
                    ->label('别名'),
                Infolists\Components\TextEntry::make('description')
                    ->label('描述'),
                Infolists\Components\IconEntry::make('is_active')
                    ->label('是否激活'),
                Infolists\Components\TextEntry::make('updated_at')
                    ->label('更新时间')
                    ->dateTime(),
            ])
            ->columns(1)
            ->inlineLabel();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('名称')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('父分类')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('别名')
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_active')
                    ->label('状态')
                    ->badge()
                    ->alignCenter()
                    ->formatStateUsing(fn (string $state, $record) => match ($state) {
                        '' => '未激活',
                        '1' => '已激活',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '' => 'danger',
                        '1' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('创建时间')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新时间')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('编辑'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBannerCategories::route('/'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.banner");
    }
}

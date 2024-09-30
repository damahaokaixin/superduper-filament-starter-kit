<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use TomatoPHP\FilamentMediaManager\Form\MediaManagerInput;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;
    protected static int $globalSearchResultsLimit = 10;

    protected static ?int $navigationSort = -1;
    protected static ?string $navigationIcon = 'fluentui-image-shadow-24';

    // 添加中文资源名称
    protected static ?string $modelLabel = '横幅';
    protected static ?string $pluralModelLabel = '横幅';

    protected static function getLastSortValue(): int
    {
        return Banner::max('sort') ?? 0;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('横幅详情')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->label('基础')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Section::make('主要详情')
                                    ->description('填写横幅的主要详情')
                                    ->icon('heroicon-o-clipboard')
                                    ->schema([
                                        Forms\Components\Select::make('banner_category_id')
                                            ->label('分类')
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->required(),
                                        Forms\Components\Select::make('is_visible')
                                            ->label('是否可见')
                                            ->default(1)
                                            ->options([
                                                0 => "否",
                                                1 => "是",
                                            ])
                                            ->native(false)
                                            ->required(),
                                        Forms\Components\TextInput::make('title')
                                            ->label('标题')
                                            ->maxLength(255)
                                            ->columnSpan(2),
                                        Forms\Components\MarkdownEditor::make('description')
                                            ->label('描述')
                                            ->helperText('提供横幅的描述')
                                            ->maxLength(500)
                                            ->columnSpanFull(),
                                    ])
                                    ->compact()
                                    ->columns(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('Images')
                            ->label('图片')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\Section::make('图片')
                                    ->description('在此上传横幅图片')
                                    ->schema([
                                        MediaManagerInput::make('images')
                                            ->label('图片')
                                            ->hiddenLabel()
                                            ->schema([
                                            ])
                                            ->defaultItems(1)
                                            ->minItems(1),
                                    ])
                                    ->compact(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Scheduling')
                            ->label('计划')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                Forms\Components\Section::make('计划')
                                    ->description('设置横幅的计划详情')
                                    ->schema([
                                        Forms\Components\DateTimePicker::make('start_date')
                                            ->label('开始日期')
                                            ->helperText('选择开始日期和时间'),
                                        Forms\Components\DateTimePicker::make('end_date')
                                            ->label('结束日期')
                                            ->helperText('选择结束日期和时间'),
                                    ])
                                    ->compact()
                                    ->columns(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('Additional Settings')
                            ->label('附加设置')
                            ->icon('heroicon-o-cog')
                            ->schema([
                                Forms\Components\Section::make('设置')
                                    ->description('横幅的附加设置')
                                    ->schema([
                                        Forms\Components\TextInput::make('sort')
                                            ->label('排序顺序')
                                            ->helperText('设置横幅的排序顺序')
                                            ->required()
                                            ->numeric()
                                            ->default(static::getLastSortValue() + 1),
                                        Forms\Components\TextInput::make('click_url')
                                            ->label('点击链接')
                                            ->helperText('输入点击横幅时导航到的URL')
                                            ->default('#')
                                            ->maxLength(255),
                                        Forms\Components\Select::make('click_url_target')
                                            ->label('链接打开方式')
                                            ->helperText('选择如何打开URL')
                                            ->options([
                                                '_blank' => '新标签页',
                                                '_self' => '当前标签页',
                                                '_parent' => '父框架',
                                                '_top' => '整个窗口'
                                            ])
                                            ->native(false),
                                    ])
                                    ->compact(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')->label('图片')
                    ->collection('images')
                    ->wrap(),
                Tables\Columns\TextColumn::make('title')
                    ->label('标题')
                    ->description(fn(Model $record): string => strip_tags((new CommonMarkConverter())->convert($record->description)->getContent()))
                    ->lineClamp(2)
                    ->wrap()
                    ->searchable()
                    ->extraAttributes(['class' => '!w-96']),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('分类')
                    ->searchable()
                    ->alignCenter()
                    ->lineClamp(2),
                Tables\Columns\IconColumn::make('is_visible')
                    ->label('是否可见')
                    ->boolean()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('开始日期')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('结束日期')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('click_url')
                    ->label('点击链接')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('创建时间')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新时间')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('分类')
                    ->relationship('category', 'name')
                    ->searchable(),
                Tables\Filters\TernaryFilter::make('is_visible')
                    ->label('可见性')
                    ->trueLabel('可见')
                    ->falseLabel('隐藏')
                    ->nullable(),
                Tables\Filters\Filter::make('start_date')
                    ->label('开始日期')
                    ->form([
                        Forms\Components\DatePicker::make('start_date')->label('开始日期'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['start_date'] ?? null, fn($query, $date) => $query->whereDate('start_date', '>=', $date));
                    }),
                Tables\Filters\Filter::make('end_date')
                    ->label('结束日期')
                    ->form([
                        Forms\Components\DatePicker::make('end_date')->label('结束日期'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['end_date'] ?? null, fn($query, $date) => $query->whereDate('end_date', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hiddenLabel()->tooltip('详情'),
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('编辑'),
                Tables\Actions\DeleteAction::make()->hiddenLabel()->tooltip('删除'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort', 'asc')
            ->reorderable('sort');
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['category']);
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->title;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'category.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Category' => $record->category->name,
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.banner");
    }
}

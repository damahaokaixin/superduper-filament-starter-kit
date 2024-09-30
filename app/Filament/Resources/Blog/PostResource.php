<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\PostResource\Pages;
use App\Models\Blog\Post;
use Filament\Forms;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use TomatoPHP\FilamentMediaManager\Form\MediaManagerInput;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $slug = 'blog/posts';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationIcon = 'fluentui-news-20';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationLabel = '文章';
    protected static ?string $modelLabel = '文章';
    protected static ?string $pluralModelLabel = '文章';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Image')
                    ->label('图片')
                    ->schema([
                        MediaManagerInput::make('images')
                            ->hiddenLabel()
                            ->schema([
                            ])
                            ->defaultItems(1)
                            ->minItems(1),
                    ])
                    ->collapsible(),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('标题')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->label('别名')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Post::class, 'slug', ignoreRecord: true),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('是否推荐')
                            ->required(),

                        Forms\Components\MarkdownEditor::make('content')
                            ->label('内容')
                            ->required()
                            ->columnSpan('full'),

                        Forms\Components\Select::make('blog_author_id')
                            ->label('作者')
                            ->relationship(
                                name: 'author',
                                modifyQueryUsing: fn(Builder $query) => $query->with('roles')->whereRelation('roles', 'name', '=', 'admin'),
                            )
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->firstname} {$record->lastname}")
                            ->searchable(['firstname', 'lastname'])
                            ->required(),

                        Forms\Components\Select::make('blog_category_id')
                            ->label('分类')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->required(),

                        Forms\Components\DatePicker::make('published_at')
                            ->label('发布日期'),

                        SpatieTagsInput::make('tags')
                            ->label('标签'),
                    ])
                    ->columns(2),
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
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('别名')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('作者')
                    ->searchable(['firstname', 'lastname'])
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('状态')
                    ->badge()
                    ->getStateUsing(fn(Post $record): string => $record->published_at?->isPast() ? '已发布' : '草稿')
                    ->colors([
                        'success' => '已发布',
                    ]),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('分类')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('发布日期')
                    ->date(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新时间')
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hiddenLabel()->tooltip('详情'),
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('编辑'),
                Tables\Actions\DeleteAction::make()->hiddenLabel()->tooltip('删除'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('批量删除'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.blog");
    }
}

<?php
/**
 * Filament 管理面板配置提供者
 * 这个类负责配置整个 Filament 管理面板的外观、功能和行为
 */
namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EmailVerification;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\RequestPasswordReset;
use App\Filament\Resources\MenuResource;
use App\Livewire\MyProfileExtended;
use App\Settings\GeneralSettings;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // 设置这个面板为默认面板
            ->default()
            // 设置面板ID为admin
            ->id('admin')
            // 设置访问路径为/admin
            ->path('admin')
            // 设置页面最大宽度为全屏
            ->maxContentWidth(\Filament\Support\Enums\MaxWidth::Full)
            // 自定义登录页面
            ->login(Login::class)
            // 自定义密码重置页面
            ->passwordReset(RequestPasswordReset::class)
            // 自定义邮箱验证页面
            ->emailVerification(EmailVerification::class)
            // 从设置中获取网站图标
            ->favicon(fn (GeneralSettings $settings) => Storage::url($settings->site_favicon))
            // 从设置中获取品牌名称
            ->brandName(fn (GeneralSettings $settings) => $settings->brand_name)
            // 从设置中获取品牌logo
            ->brandLogo(fn (GeneralSettings $settings) => Storage::url($settings->brand_logo))
            // 设置品牌logo高度
            ->brandLogoHeight(fn (GeneralSettings $settings) => $settings->brand_logoHeight)
            // 从设置中获取网站主题颜色
            ->colors(fn (GeneralSettings $settings) => $settings->site_theme)
            // 启用数据库通知，并设置轮询间隔为30秒
            ->databaseNotifications()->databaseNotificationsPolling('30s')
            // 设置全局搜索快捷键
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            // 允许在桌面端折叠侧边栏
            ->sidebarCollapsibleOnDesktop()
            // 配置导航分组
            ->navigationGroups([
                // 前台导航组
                Navigation\NavigationGroup::make()
                    ->label('前台')
                    ->collapsible(true)  // 允许折叠
                    ->collapsed(),        // 默认折叠
                // 后台管理导航组
                Navigation\NavigationGroup::make()
                    ->label('后台管理')
                    ->collapsible(true)
                    ->collapsed(),
                // 后台管理导航组
                Navigation\NavigationGroup::make()
                    ->label('媒体')
                    ->collapsible(true)
                    ->collapsed(),
                // 设置导航组
                Navigation\NavigationGroup::make()
                    ->label('设置')
                    ->collapsible(true)
                    ->collapsed(),
                // 开发维护导航组
                Navigation\NavigationGroup::make()
                    ->label(__('开发维护'))
                    ->collapsible(true)
                    ->collapsed(),
            ])
            // 配置独立导航项
            ->navigationItems([
                // 前台首页链接
                Navigation\NavigationItem::make('user-home')
                    ->label("前台首页")
                    ->url("/", true)
                    ->icon('heroicon-o-cog-6-tooth'),
                // 日志查看器链接
                Navigation\NavigationItem::make('Log Viewer')
                    ->label(__('日志文件中心'))
                    ->visible(fn(): bool => auth()->user()->can('access_log_viewer'))
                    ->url(config('app.url').'/'.config('log-viewer.route_path'), shouldOpenInNewTab: true)
                    ->icon('fluentui-document-bullet-list-multiple-20-o')
                    ->group('开发维护')
                    ->sort(99),
            ])
            // 加载自定义主题CSS
            ->viteTheme('resources/css/filament/admin/theme.css')
            // 自动发现并注册Resources目录下的资源
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            // 注册额外的资源
            ->resources([
                config('filament-logger.activity_resource')
            ])
            // 自动发现并注册Pages目录下的页面
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            // 注册默认页面
            ->pages([
                Pages\Dashboard::class,
            ])
            // 自动发现并注册Widgets目录下的小部件
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            // 注册默认小部件
            ->widgets([
                Widgets\FilamentInfoWidget::class,
            ])
            // 配置中间件
            ->middleware([
                EncryptCookies::class,                    // Cookie加密
                AddQueuedCookiesToResponse::class,        // 添加队列Cookie到响应
                StartSession::class,                      // 启动会话
                AuthenticateSession::class,               // 会话认证
                ShareErrorsFromSession::class,            // 共享会话错误
                VerifyCsrfToken::class,                   // CSRF令牌验证
                SubstituteBindings::class,                // 路由模型绑定
                DisableBladeIconComponents::class,        // 禁用Blade图标组件
                DispatchServingFilamentEvent::class,      // 分发Filament服务事件
            ])
            // 配置认证中间件
            ->authMiddleware([
                Authenticate::class,
            ])
            // 注册插件
            ->plugins([
                // 健康检查插件
                \ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin::make()
                    ->usingPage(\App\Filament\Pages\HealthCheckResults::class),
                // 媒体管理器插件
                \TomatoPHP\FilamentMediaManager\FilamentMediaManagerPlugin::make()
                    ->allowSubFolders(),
                // 异常处理插件
                \BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin::make(),
                // 权限管理插件
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 2,
                        'sm' => 1
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                // 用户配置文件插件
                \Jeffgreco13\FilamentBreezy\BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true,     // 注册用户菜单
                        shouldRegisterNavigation: false,  // 不注册导航
                        navigationGroup: 'Settings',      // 导航组
                        hasAvatars: true,                // 启用头像
                        slug: 'my-profile'               // URL slug
                    )
                    ->myProfileComponents([
                        'personal_info' => MyProfileExtended::class,
                    ]),
                // 菜单构建器插件
                \Datlechin\FilamentMenuBuilder\FilamentMenuBuilderPlugin::make()
                    ->usingResource(MenuResource::class)
                    ->addMenuPanels([
                        \Datlechin\FilamentMenuBuilder\MenuPanel\StaticMenuPanel::make()
                            ->addMany([
                                'Home' => url('/'),
                                '博客' => url('/blog'),
                            ])
                            ->description('默认菜单')
                            ->collapsed(true)
                            ->collapsible(true)
                            ->paginate(perPage: 5, condition: true)
                    ])
            ]);
    }
}

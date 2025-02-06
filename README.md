# 九午软件filamentphp后台脚手架

## 1. 安装
```sh
git clone https://github.com/jiuwu-software/filament-admin-panel.git
cd filament-admin-panel
cp .env.example .env
# 修改.env文件的数据库配置, 域名, 软件名称, 软件版本, 软件版本号
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
pnpm install
pnpm run build
```
## 2. nginx配置
```nginx
location = /livewire/livewire.js {
    expires off;
    try_files $uri $uri/ /index.php?$query_string;
}
location = /livewire/livewire.min.js {
    expires off;
    try_files $uri $uri/ /index.php?$query_string;
}
location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
```

## 3. 启动软件
```sh
php artisan serve
```

### 第三方软件包

#### 核心包
- [Filament Admin Panel v3](https://github.com/filamentphp/filament) - 强大的 Laravel 管理面板框架
- [Filament Shield](https://github.com/bezhansalleh/filament-shield) - Filament 的权限管理系统
  ```bash
  php artisan shield:install
  php artisan shield:generate
  ```

#### 认证相关
- [Filament Breezy](https://github.com/jeffgreco13/filament-breezy) - 增强的用户认证功能
  ```bash
  php artisan breezy:install
  ```
- [Filament Impersonate](https://github.com/stechstudio/filament-impersonate) - 用户模拟登录
  ```bash
  php artisan vendor:publish --tag="filament-impersonate-config"
  ```

#### 媒体管理
- [Spatie Media Library](https://github.com/spatie/laravel-medialibrary) - 媒体文件管理
  ```bash
  php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
  php artisan migrate
  ```
- [Filament Media Manager](https://github.com/tomatophp/filament-media-manager) - 文件管理器

#### 系统工具
- [Filament Exceptions](https://github.com/bezhansalleh/filament-exceptions) - 异常日志管理
  ```bash
  php artisan vendor:publish --tag="filament-exceptions-migrations"
  php artisan migrate
  ```
- [Filament Logger](https://github.com/z3d0x/filament-logger) - 系统操作日志
  ```bash
  php artisan vendor:publish --tag="filament-logger-migrations"
  php artisan migrate
  ```
- [Log Viewer](https://github.com/opcodesio/log-viewer) - 日志查看器
  ```bash
  php artisan vendor:publish --tag="log-viewer-config"
  ```
- [Filament Spatie Health](https://github.com/shuvroroy/filament-spatie-laravel-health) - 系统健康检查
  ```bash
  php artisan vendor:publish --provider="Spatie\Health\HealthServiceProvider" --tag="health-config"
  ```

#### 功能增强
- [Filament Menu Builder](https://github.com/datlechin/filament-menu-builder) - 动态菜单构建器
  ```bash
  php artisan vendor:publish --tag="filament-menu-builder-migrations"
  php artisan migrate
  ```
- [Filament Record Navigation](https://github.com/josespinal/filament-record-navigation) - 记录导航
- [Filament ACE Editor](https://github.com/riodwanto/filament-ace-editor) - 代码编辑器组件
- [Spatie Tags](https://github.com/spatie/laravel-tags) - 标签管理
  ```bash
  php artisan vendor:publish --provider="Spatie\Tags\TagsServiceProvider" --tag="tags-migrations"
  php artisan migrate
  ```
- [Spatie Settings](https://github.com/spatie/laravel-settings) - 系统设置管理
  ```bash
  php artisan vendor:publish --provider="Spatie\LaravelSettings\LaravelSettingsServiceProvider" --tag="migrations"
  php artisan migrate
  ```
- [Google Translate PHP](https://github.com/Stichoza/google-translate-php) - Google 翻译集成
- [Blade FluentUI System Icons](https://github.com/codeat3/blade-fluentui-system-icons) - FluentUI 图标集成
  ```bash
  php artisan vendor:publish --tag=blade-fluentui-system-icons-config
  ```

#### 开发工具
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) - 调试工具栏
  ```bash
  php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
  ```
- [Laravel Lang](https://github.com/Laravel-Lang/lang) - 多语言支持
  ```bash
  php artisan lang:update
  ```

### 注意事项
1. 安装完成后，请确保运行所有必要的数据库迁移命令
2. 部分包可能需要额外的配置，请参考各自的官方文档
3. 建议在开发环境下启用 Laravel Debugbar
4. 使用 Filament Shield 生成权限时，建议先规划好权限结构
5. 使用 Filament Impersonate 时，请注意配置相应的中间件和权限
6. 系统健康检查建议配置定时任务进行监控
7. 使用 Google Translate 时需要注意 API 限制和配额




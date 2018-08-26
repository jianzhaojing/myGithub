---
typora-copy-images-to: img
---

# 让phpstorm更友好支持laravel

PHP开发工具有很多，但是从开发效率和对laravel支持的友好度上来讲，**phpstorm**可以是最佳的选择，也是现在开发人员最受欢迎开发工具。

## 1、安装laravel插件
```
composer require barryvdh/laravel-ide-helper
```
## 2、laravel项目中修改config/app.php
```
# 添加以下内容到 providers 数组

Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
```
## 3、运行如下命令
```
php artisan ide-helper:generate
```


# composer 安装

```
composer require pl/hyperf-admin
```


# 配置

- 1、模板缓存
```
# runtime/view/目录不存在创建
```

- 2、静态资源

```
# 扩展包almasaeed2010的下的dist、plugins复制到public/vendor里面
# nprogress.js和nprogress.css发布到public/vendor/dist对应目录
# 添加font-awesome.min.css和对应fonts字体
```

- 3、配置静态资源
```php
return [
    'settings' => [
        ...
        // 静态资源
        'document_root' => BASE_PATH . '/public',
        'enable_static_handler' => true,
    ],
];
```

# 发布配置文件
```
php bin/hyperf.php vendor:publish pl/hyperf-admin
```
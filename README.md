# composer 安装

```
composer require pl/hyperf-admin
```


# 配置

- 1、模板缓存
```
# runtime/view/目录不存在创建
# session 配置-https://hyperf.wiki/2.0/#/zh-cn/session。(使用redis驱动session)

# 日志配置
'hyperfadmin' => [
    'handler' => [
        'class' => Monolog\Handler\RotatingFileHandler::class,
        'constructor' => [
            'filename' => BASE_PATH . '/runtime/logs/hyperfadmin/hyperfadmin.log',
            'level' => Monolog\Logger::DEBUG,
        ],
    ],
    'formatter' => [
        'class' => Monolog\Formatter\LineFormatter::class,
        'constructor' => [
            'format' => null,
            'dateFormat' => null,
            'allowInlineLineBreaks' => true,
        ],
    ],
],

# 在public创建目录
storage/download/excel/

# Success.php发布


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

迁移文件 
2020_07_16_102104_create_hyperf_admin_users
```

# 发布配置文件
```
php bin/hyperf.php vendor:publish pl/hyperf-admin
```

# 执行
- [参考](https://hyperf.wiki/2.0/#/zh-cn/quick-start/questions)
```
composer dump-autoload -o
```

# 待办
1.`Grid.php/setSearchHtml`方法优化
2.继续添加搜索方法
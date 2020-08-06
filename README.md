# composer 安装

```
composer require pl/hyperf-admin

```

# 扩展包

#### [导出安装](https://blog.csdn.net/qq_29755359/article/details/104575938)
```
composer require viest/php-ext-xlswriter-ide-helper:dev-master

```

#### [session配置](https://hyperf.wiki/2.0/#/zh-cn/session)
```
composer require hyperf/session
```


#### [视图配置](https://hyperf.wiki/2.0/#/zh-cn/view)
```
composer require hyperf/view
composer require hyperf/task
composer require duncan3dc/blade
```

# 配置

#### 日志配置
```
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
```

#### 导出目录创建
```$xslt
# 在public创建目录
storage/download/excel/
```

#### 静态资源

```
# 扩展包almasaeed2010的下的dist、plugins复制到public/vendor里面
# nprogress.js和nprogress.css发布到public/vendor/dist对应目录
# 添加font-awesome.min.css和对应fonts字体
```

#### 配置静态资源
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

#### 迁移文件 
```
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

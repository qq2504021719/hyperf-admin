## composer 安装
```
composer require pl/hyperf-admin

```

# 扩展包
#### [导出配置教程](https://blog.csdn.net/qq_29755359/article/details/104575938)
#### [session配置教程](https://hyperf.wiki/2.0/#/zh-cn/session)
#### [视图配置教程](https://hyperf.wiki/2.0/#/zh-cn/view)
#### [Task配置教程](https://hyperf.wiki/2.0/#/zh-cn/task)


## 配置

#### 日志配置
```php
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

#### 数据库填充内容
```SQL
INSERT INTO `hyperf_admin_users` (`id`, `username`, `password`, `name`, `avatar`, `created_at`, `updated_at`) VALUES ('1', 'admin', 'BOa24Yjd71KPvZWVTyIYGg==', 'admin', 'http://hyperf-admin.it/public/upload/15966093203947.png', '2020-08-05 13:58:08', '2020-08-05 14:35:22');
```

#### 默认后台地址
```
http://xxxx.xxx.xxx/admin/auth
账号:admin
密码:123456789
```

## 发布配置文件
```
php bin/hyperf.php vendor:publish pl/hyperf-admin
```

## 执行(更新代码)
- [参考](https://hyperf.wiki/2.0/#/zh-cn/quick-start/questions)
```
composer dump-autoload -o
```


License
------------
`hyperf-admin` is licensed under [The MIT License (MIT)](LICENSE).

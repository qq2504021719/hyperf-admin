## composer 安装
```
composer require pl/hyperf-admin

```

## 扩展包

> 不必须是在`发布配置文件`这一步已经发布了这些的配置文件。

#### [导出配置教程(必许)](https://blog.csdn.net/qq_29755359/article/details/104575938)
#### [session配置教程(不必许)](https://hyperf.wiki/2.0/#/zh-cn/session)
#### [Task配置教程(不必许)](https://hyperf.wiki/2.0/#/zh-cn/task)
#### [视图配置教程(不必许)](https://hyperf.wiki/2.0/#/zh-cn/view)
#### [validation验证器配置教程(不必许)](https://hyperf.wiki/2.0/#/zh-cn/validation)

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
        
        // Task Worker 数量，根据您的服务器配置而配置适当的数量
        'task_worker_num' => 8,
        // 因为 `Task` 主要处理无法协程化的方法，所以这里推荐设为 `false`，避免协程下出现数据混淆的情况
        'task_enable_coroutine' => false,
        
        // 静态资源
        'document_root' => BASE_PATH . '/public',
        'enable_static_handler' => true,
    ],
];
```

#### 默认后台地址
```
http://xxxx.xxx.xxx/admin/auth
账号:admin
密码:123456789
```

## 发布配置文件
```
# 基础配置文件(包含session、task、视图、验证器的配置)
php bin/hyperf.php vendor:publish pl/hyperf-admin
# 验证器语言文件
php bin/hyperf.php vendor:publish hyperf/validation
```

#### 数据库填充内容
```SQL
INSERT INTO `hyperf_admin_users` (`id`, `username`, `password`, `name`, `avatar`, `created_at`, `updated_at`) VALUES ('1', 'admin', 'BOa24Yjd71KPvZWVTyIYGg==', 'admin', 'http://hyperf-admin.it/public/upload/15966093203947.png', '2020-08-05 13:58:08', '2020-08-05 14:35:22');
```

## 执行(更新代码)
- [参考](https://hyperf.wiki/2.0/#/zh-cn/quick-start/questions)
```
composer dump-autoload -o
```

## 快速开始

#### 1.生成控制器示例

> 生成后重启,如果访问不存在，执行下更新代码命令，再重启

```
php bin/hyperf.php hyperf-admin:command Base/Prizes App/Model/Prizes  
```

## 注意

- 1.发布配置文件或生成控制器后，如果重启代码没有生效，执行下更新代码命令，再重启

License
------------
`hyperf-admin` is licensed under [The MIT License (MIT)](LICENSE).

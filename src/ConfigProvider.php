<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Pl\HyperfAdmin;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => '配置文件发布成功.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/hyperf-admin.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/hyperf-admin.php', // 复制为这个路径下的该文件
                ],
                [
                    'id' => 'command',
                    'description' => '命令文件发布成功.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/HyperfAdminCommand.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/app/Command/HyperfAdminCommand.php', // 复制为这个路径下的该文件
                ],
                [
                    'id' => 'migrations',
                    'description' => '迁移文件发布成功.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/migrations/2020_07_16_102104_create_hyperf_admin_users.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/migrations/2020_07_16_102104_create_hyperf_admin_users.php', // 复制为这个路径下的该文件
                ],
                [
                    'id' => 'middlewares',
                    'description' => 'middlewares文件发布成功.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/middlewares.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/middlewares.php', // 复制为这个路径下的该文件
                ],
                [
                    'id' => 'session',
                    'description' => 'session文件发布成功.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/session.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/session.php', // 复制为这个路径下的该文件
                ],
                [
                    'id' => 'view',
                    'description' => 'view文件发布成功.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/view.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/view.php', // 复制为这个路径下的该文件
                ],
                [
                    'id' => 'view',
                    'description' => 'exceptions文件发布成功.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/exceptions.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/exceptions.php', // 复制为这个路径下的该文件
                ],
            ],
        ];
    }
}

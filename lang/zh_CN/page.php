<?php

return [
    'general_settings' => [
        'title' => '常规设置',
        'heading' => '常规设置',
        'subheading' => '在此管理常规站点设置。',
        'navigationLabel' => '一般设置',
        'sections' => [
            'site' => [
                'title' => '地点',
                'description' => '管理基本设置。',
            ],
            'theme' => [
                'title' => '主题',
                'description' => '更改默认主题。',
            ],
            'ai' => [
                'title' => 'AI 设置',
                'description' => '配置 OpenAI API 相关设置',
            ]
        ],
        'fields' => [
            'brand_name' => 'Logo名称',
            'site_active' => '站点状态',
            'brand_logoHeight' => 'Logo高度',
            'brand_logo' => 'Logo图片(尽量PNG)',
            'site_favicon' => '网站图标(ico图标)',
            'primary' => '主要色',
            'secondary' => '次要色',
            'gray' => '中性色',
            'success' => '成功色',
            'danger' => '危险色',
            'info' => '信息提示色',
            'warning' => '警告提示色',
        ],
    ],
    'mail_settings' => [
        'title' => '邮件设置',
        'heading' => '邮件设置',
        'subheading' => '管理邮件配置。',
        'navigationLabel' => '邮件设置',
        'sections' => [
            'config' => [
                'title' => '配置',
                'description' => '描述',
            ],
            'sender' => [
                'title' => '来自（发件人）',
                'description' => '描述',
            ],
            'mail_to' => [
                'title' => '邮寄至',
                'description' => '描述',
            ],
        ],
        'fields' => [
            'placeholder' => [
                'receiver_email' => '收件人邮箱..',
            ],
            'driver' => '邮件驱动程序',
            'host' => '邮件服务器',
            'port' => '端口',
            'encryption' => '加密类型',
            'timeout' => '超时(单位:秒)',
            'username' => '邮箱用户名',
            'password' => '邮箱密码',
            'email' => '发件电子邮件',
            'name' => '发件人姓名',
            'mail_to' => '邮寄至',
        ],
        'actions' => [
            'send_test_mail' => '发送测试邮件',
        ],
    ]
    ];

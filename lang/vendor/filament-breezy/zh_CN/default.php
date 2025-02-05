<?php

return [
    'password_confirm' => [
        'heading' => '确认密码',
        'description' => '请确认您的密码以完成此操作。',
        'current_password' => '当前密码',
    ],
    'two_factor' => [
        'heading' => '两步验证挑战',
        'description' => '请输入您的身份验证器应用程序提供的代码以确认对您账户的访问。',
        'code_placeholder' => 'XXX-XXX',
        'recovery' => [
            'heading' => '两步验证挑战',
            'description' => '请输入您的紧急恢复码以访问您的账户。',
        ],
        'recovery_code_placeholder' => 'abcdef-98765',
        'recovery_code_text' => '设备丢失？',
        'recovery_code_link' => '使用恢复码',
        'back_to_login_link' => '返回登录',
    ],
    'profile' => [
        'account' => '账户',
        'profile' => '个人资料',
        'my_profile' => '我的个人资料',
        'subheading' => '在这里管理您的用户个人资料。',
        'personal_info' => [
            'heading' => '个人信息',
            'subheading' => '管理您的个人信息。',
            'submit' => [
                'label' => '更新',
            ],
            'notify' => '个人资料更新成功！',
        ],
        'password' => [
            'heading' => '密码',
            'subheading' => '长度必须至少为 8 个字符。',
            'submit' => [
                'label' => '更新',
            ],
            'notify' => '密码更新成功！',
        ],
        '2fa' => [
            'title' => '两步验证',
            'description' => '管理您账户的两步验证（推荐）。',
            'actions' => [
                'enable' => '启用',
                'regenerate_codes' => '重新生成恢复码',
                'disable' => '禁用',
                'confirm_finish' => '确认并完成',
                'cancel_setup' => '取消设置',
            ],
            'setup_key' => '设置密钥',
            'must_enable' => '您必须启用两步验证才能使用此应用程序。',
            'not_enabled' => [
                'title' => '您尚未启用两步验证。',
                'description' => '启用两步验证后，系统将在身份验证过程中提示您输入安全的随机 Token。您可以从手机的 Google Authenticator 应用程序中检索此 Token。',
            ],
            'finish_enabling' => [
                'title' => '完成启用两步验证。',
                'description' => '要完成启用两步验证，请使用手机的身份验证器应用程序扫描以下二维码，或输入设置密钥并提供生成的 OTP 代码。',
            ],
            'enabled' => [
                'notify' => '已启用两步验证。',
                'title' => '您已启用两步验证！',
                'description' => '现已启用两步验证。这有助于使您的账户更加安全。',
                'store_codes' => '如果您的设备丢失，这些代码可用于恢复对您账户的访问权限。警告！这些代码只会出现一次。',
            ],
            'disabling' => [
                'notify' => '两步验证已被禁用。',
            ],
            'regenerate_codes' => [
                'notify' => '新的恢复码已生成。',
            ],
            'confirmation' => [
                'success_notification' => '代码已验证。启用两步验证。',
                'invalid_code' => '您输入的代码无效。',
            ],
        ],
        'sanctum' => [
            'title' => 'API Token',
            'description' => '管理允许第三方服务代表您访问此应用程序的 API Token。',
            'create' => [
                'notify' => 'Token 创建成功！',
                'message' => '您的 Token 在创建时仅显示一次。如果您丢失了 Token，则需要将其删除并创建一个新 Token。',
                'submit' => [
                    'label' => '新增',
                ],
            ],
            'update' => [
                'notify' => 'Token 更新成功！',
            ],
            'copied' => [
                'label' => '我已经复制了我的 Token',
            ],
        ],
    ],
    'clipboard' => [
        'link' => '复制到剪贴板',
        'tooltip' => '已复制！',
    ],
    'fields' => [
        'avatar' => '头像',
        'email' => '电子邮件',
        'login' => '登录',
        'name' => '名称',
        'password' => '确认',
        'password_confirm' => '密码确认',
        'new_password' => '新密码',
        'new_password_confirmation' => '确认密码',
        'token_name' => 'Token 名称',
        'token_expiry' => 'Token 到期',
        'abilities' => '权限',
        '2fa_code' => '代码',
        '2fa_recovery_code' => '恢复码',
        'created' => '创建',
        'expires' => '到期',
    ],
    'or' => ' 或 ',
    'cancel' => '取消',
];

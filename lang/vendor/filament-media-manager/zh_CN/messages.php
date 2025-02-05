<?php

return [
    'empty' => [
        'title' => "未找到媒体或文件夹",
    ],
    'folders' => [
        'title' => '媒体管理器',
        'single' => '文件夹',
        'columns' => [
            'name' => '名称',
            'collection' => '集合',
            'description' => '描述',
            'is_public' => '是否公开',
            'has_user_access' => '是否有用户访问权限',
            'users' => '用户',
            'icon' => '图标',
            'color' => '颜色',
            'is_protected' => '是否受保护',
            'password' => '密码',
            'password_confirmation' => '确认密码',
        ],
        'group' => '媒体',
    ],
    'media' => [
        'title' => '媒体',
        'single' => '媒体',
        'columns' => [
            'image' => '图片',
            'model' => '模型',
            'collection_name' => '集合名称',
            'size' => '大小',
            'order_column' => '排序列',
        ],
        'actions' => [
            'sub_folder'=> [
              'label' => "创建子文件夹"
            ],
            'create' => [
                'label' => '添加媒体',
                'form' => [
                    'file' => '文件',
                    'title' => '标题',
                    'description' => '描述',
                ],
            ],
            'delete' => [
                'label' => '删除文件夹',
            ],
            'edit' => [
                'label' => '编辑文件夹',
            ],
        ],
        'notifications' => [
            'create-media' => '媒体创建成功',
            'delete-folder' => '文件夹删除成功',
            'edit-folder' => '文件夹编辑成功',
        ],
        'meta' => [
            'model' => '模型',
            'file-name' => '文件名',
            'type' => '类型',
            'size' => '大小',
            'disk' => '磁盘',
            'url' => 'URL',
            'delete-media' => '删除媒体',
        ],
    ],
];

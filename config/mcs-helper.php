<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Username of the file.
     |--------------------------------------------------------------------------
     |
    */
    'username'    => 'Hemant Saini',
    /*
     |
     |--------------------------------------------------------------------------
     | Overwrite existing files.
     |--------------------------------------------------------------------------
     | If true, it will regenerate all existing files that matches the include and exclude pattern.
     |
    */
    'overwrite'   => true,
    /*
     |--------------------------------------------------------------------------
     | Base path of the project.
     |--------------------------------------------------------------------------
    */
    'base_path'   => base_path(),


    /*
     |--------------------------------------------------------------------------
     | Excludes
     |--------------------------------------------------------------------------
     | Table that exists in excludes and includes both will be excluded. By default password_resets and migrations tables are excluded.
    */
    'excludes'    => [
        'password_resets', 'migrations',
    ],


    /*
     |--------------------------------------------------------------------------
     | Includes
     |--------------------------------------------------------------------------
     | Table that exists in excludes and includes both will be excluded. By default no table in includes.
    */
    'includes'    => [],


    /*
     |--------------------------------------------------------------------------
     | Contracts
     |--------------------------------------------------------------------------
     */
    'contract'    => [
        'path'            => 'app/Services/Contract',
        'namespace'       => 'App\Services\Contract',
        'overwrite'       => true,
        'exclude_table'   => [
            'password_resets'
        ],
        'types'           => [
            'Create', 'Update', 'List'
        ],
        'include'         => [],
        'exclude'         => [],
        'exclude_columns' => ['id', 'deleted_at', 'created_at', 'updated_at'],
    ],

    /*
     |--------------------------------------------------------------------------
     | Controllers
     |--------------------------------------------------------------------------
     */
    'controller'  => [
        'path'          => 'app/Api/V1/Controllers',
        'namespace'     => 'App\Api\V1\Controllers',
        'overwrite'     => true,
        'exclude_table' => [
            'password_resets', 'migrations',
        ],
        'include'       => [],
        'exclude'       => [],
    ],

    /*
     |--------------------------------------------------------------------------
     | Exception
     |--------------------------------------------------------------------------
     */
    'exception'   => [
        'path'          => 'app/Api/V1/Exceptions',
        'namespace'     => 'App\Api\V1\Exceptions',
        'overwrite'     => false,
        'parent'        => 'HttpException',
        'exclude_table' => [
            'password_resets', 'migrations',
        ],
        'include'       => [],
        'exclude'       => [],
    ],

    /*
     |--------------------------------------------------------------------------
     | Factory
     |--------------------------------------------------------------------------
     */
    'factory'     => [
        'path'          => 'database/factories',
        'overwrite'     => true,
        'exclude_table' => [
            'password_resets', 'migrations',
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Migrations
     |--------------------------------------------------------------------------
     */
    'migration'   => [
        'path'   => 'database/migrations',
        'prefix' => ''
    ],

    /*
     |--------------------------------------------------------------------------
     | Model
     |--------------------------------------------------------------------------
     */
    'model'       => [
        'path'          => 'app',
        'namespace'     => 'App',
        'overwrite'     => true,
        'parent'        => 'BaseModel',
        'exclude_table' => [
            'password_resets'
        ],
        'include'       => [],
        'exclude'       => [],
    ],

    /*
     |--------------------------------------------------------------------------
     | Request
     |--------------------------------------------------------------------------
     */
    'request'     => [
        'path'               => 'app/Api/V1/Requests',
        'namespace'          => 'App\Api\V1\Requests',
        'overwrite'          => true,
        'exclude_table'      => [
            'password_resets'
        ],
        'types'              => [
            'Create', 'Update', 'List'
        ],
        'include'            => [],
        'exclude'            => [],
        'skip_create_fields' => ['id', 'deleted_at', 'created_at', 'updated_at'],
        'skip_update_fields' => ['id', 'deleted_at', 'created_at', 'updated_at']
    ],

    /*
     |--------------------------------------------------------------------------
     | Seeder
     |--------------------------------------------------------------------------
     */
    'seeder'      => [
        'row_count'     => 10,
        'path'          => 'database/seeds',
        'overwrite'     => true,
        'exclude_table' => [
            'password_resets', 'migrations',
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Service
     |--------------------------------------------------------------------------
     */
    'service'     => [
        'path'               => 'app/Services',
        'namespace'          => 'App\Services',
        'overwrite'          => true,
        'exclude_table'      => [
            'password_resets'
        ],
        'include'            => [],
        'exclude'            => [],
        'skip_create_fields' => ['id', 'deleted_at', 'created_at', 'updated_at'],
        'skip_update_fields' => ['id', 'deleted_at', 'created_at', 'updated_at']
    ],

    /*
     |--------------------------------------------------------------------------
     | Transformer
     |--------------------------------------------------------------------------
     */
    'transformer' => [
        'path'            => 'app/Transformers',
        'namespace'       => 'App\Transformers',
        'overwrite'       => true,
        'exclude_table'   => [
            'password_resets'
        ],
        'exclude_columns' => ['password', 'deleted_at', 'user_id'],
    ]

];

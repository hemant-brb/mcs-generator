<?php

return [
    /*
   |--------------------------------------------------------------------------
   | Username of the file.
   |--------------------------------------------------------------------------
   |
  */
    'username'   => 'Hemant Saini',
    /*
     |--------------------------------------------------------------------------
     | Overwrite existing files.
     |--------------------------------------------------------------------------
     | If false, it will regenerate all existing files that matches the include and exclude pattern.
     |
    */
    'overwrite'  => false,
    /*
     |--------------------------------------------------------------------------
     | Base path of the project.
     |--------------------------------------------------------------------------
    */
    'base_path'  => base_path(),


    /*
     |--------------------------------------------------------------------------
     | Excludes
     |--------------------------------------------------------------------------
     | Table that exists in excludes and includes both will be excluded. By default no table in excluded.
    */
    'excludes'   => [
        'password_resets', 'migrations',
    ],


    /*
     |--------------------------------------------------------------------------
     | Includes
     |--------------------------------------------------------------------------
     | Table that exists in excludes and includes both will be excluded. By default no table in includes.
    */
    'includes'   => [],


    /**
     * Contracts
     */
    'contract'   => [
        'path'               => 'app/Services/Contract',
        'namespace'          => 'App\Services\Contract',
        'overwrite'          => false,
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

    /**
     * Controllers
     */
    'controller' => [
        'path'          => 'app/Api/V1/Controllers',
        'namespace'     => 'App\Api\V1\Controllers',
        'overwrite'     => false,
        'parent'        => 'BaseController',
        'exclude_table' => [
            'password_resets', 'migrations',
        ],
        'include'       => [],
        'exclude'       => [],
    ],

    /**
     * Exception
     */
    'exception'  => [
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

    'factory'     => [
        'path'          => 'database/factories',
        'overwrite'     => false,
        'exclude_table' => [
            'password_resets', 'migrations',
        ],
    ],

    /**
     * Migrations
     */
    'migration'   => [
        'path'   => 'database/migrations',
        'prefix' => '',
        ''
    ],

    /**
     * Model
     */
    'model'       => [
        'path'          => 'app',
        'namespace'     => 'App',
        'overwrite'     => false,
        'exclude_table' => [
            'password_resets'
        ],
        'include'       => [],
        'exclude'       => [],
    ],

    /**
     * Request
     */
    'request'     => [
        'path'               => 'app/Api/V1/Requests',
        'namespace'          => 'App\Api\V1\Requests',
        'overwrite'          => false,
        'parent'             => 'BaseRequest',
        'list_parent'        => 'Devslane\Generator\Requests\ListRequest',
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

    /**
     * Seeder
     */
    'seeder'      => [
        'row_count'     => 10,
        'path'          => 'database/seeds',
        'overwrite'     => false,
        'exclude_table' => [
            'password_resets', 'migrations',
        ],
    ],

    /**
     * Service
     */
    'service'     => [
        'path'               => 'app/Services',
        'namespace'          => 'App\Services',
        'overwrite'          => false,
        'exclude_table'      => [
            'password_resets'
        ],
        'include'            => [],
        'exclude'            => [],
        'skip_create_fields' => ['id', 'deleted_at', 'created_at', 'updated_at'],
        'skip_update_fields' => ['id', 'deleted_at', 'created_at', 'updated_at']
    ],

    /**
     * Transformer
     */
    'transformer' => [
        'path'          => 'app/Transformers',
        'namespace'     => 'App\Transformers',
        'overwrite'     => false,
        'exclude_table' => [
            'password_resets'
        ],
        'include'       => [],
        'exclude'       => ['password', 'deleted_at'],
    ]
];
<?php

class Role extends Model {

    protected $table = 'roles';
    protected $allowedColumns = [
        'role_name',
    ];

    public const ROLES = [
        'admin' => 2,
    ];

}
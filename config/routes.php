<?php

$configuration = [
    "user_list_all" => [
        "uri" => "^/user$",
        "controller" => "userController",
        "action" => "getAll",
        "method" => "GET"
    ],
    "user_list_id" => [
        "uri" => "^/user/(?<id>\d+)",
        "controller" => "userController",
        "action" => "getId",
        "method" => "GET"
    ],
    "user_update_id_role" => [
        "uri" => "^/user/(?<id>\d+)/setRole/(?<role>ADMIN|GUEST)$",
        "controller" => "userController",
        "action" => "updateRole",
        "method" => "GET"
    ]
];

return $configuration;

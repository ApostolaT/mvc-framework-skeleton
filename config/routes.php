<?php

use Framework\Router\Router;

$configuration = [
    "dispatcher" => [
        "controller_suffix" => "Controller",
        "controller_namespace" => "Framework\Controller"
    ],
    "routing" => [
        "routes" => [
            "user_list_all" => [
                Router::CONFIG_KEY_PATH => "/user",
                "controller" => "user",
                "action" => "getAll",
                "method" => "GET",
                "attributes" => []
            ],
                "user_list_id" => [
                Router::CONFIG_KEY_PATH => "/user/{id}",
                "controller" => "user",
                "action" => "getId",
                "method" => "GET",
                "attributes" => [
                    "id" => "\d+",
                ]
            ],
                "user_update_id_role" => [
                Router::CONFIG_KEY_PATH => "/user/{id}/setRole/{role}",
                "controller" => "user",
                "action" => "updateRole",
                "method" => "GET",
                "attributes" => [
                    "id" => "\d+",
                    "role" => "ADMIN|USER"
                ]
            ],
            "user_post_show" => [
                Router::CONFIG_KEY_PATH => "/user/{id}",
                "controller" => "user",
                "action" => "postAll",
                "method" => "POST",
                "attributes" => [
                    "id" => "\d+"
                ]
            ],
            "user_post_delete" => [
                Router::CONFIG_KEY_PATH => "/user/{id}",
                "controller" => "delete",
                "action" => "deleteUser",
                "method" => "DELETE",
                "attributes" => [
                    "id" => "\d+"
                ]
            ]
        ]
   ],
    "errors" => [
        "404" => "<h1>404 Page not found</h1>"
    ],
    "render" =>
        ["base_path" => "/var/www/mvc-framework-skeleton/renders/"]
];

return $configuration;

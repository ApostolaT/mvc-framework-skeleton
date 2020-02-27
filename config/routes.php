<?php

use Framework\Router\Router;

$configuration = [
    "dispatcher" => [
        "controller_suffix" => "Controller",
        "controller_namespace" => "ApplicationController\Controllers"
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
            ]
        ]
   ]
];

return $configuration;

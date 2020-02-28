<?php

namespace Framework\Regex;

use Framework\Router\Router;

class RegexBuilder
{
    public function createRegex(array $config): string
    {
        $string = $config[Router::CONFIG_KEY_PATH];

        foreach ($config["attributes"] as $key => $value) {
            $pattern = "{".$key."}";
            $attrValueReplace = "(?<".$key.">".$value.")";

            $string = str_replace($pattern, $attrValueReplace, $string);
        }

        return "/^". str_replace("/", "\/", $string) . "$/";
    }
}
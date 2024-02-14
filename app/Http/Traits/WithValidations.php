<?php

namespace App\Http\Traits;

trait WithValidations
{
    public $validations = [
        "text" => "string|max:255",
        "number" => "numeric|min:0|max:999999.99",
        "email" => "email|max:255",
        "textarea" => "string|max:65535",
        "file" => "file|max:10240",
        "tel" => "regex:/^[0-9]{10}$/",
        "color" => "string|max:7",

        "array" => "",
        "select" => "string|max:255",
        "password" => "string|min:8|max:255",
    ];
}

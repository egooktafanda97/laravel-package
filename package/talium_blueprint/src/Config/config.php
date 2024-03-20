<?php

return [
    "blueprint" => [
        "blueprint_path" => base_path("blueprint/"),
        "file_format" => "yml",
        "output_path" => [
            "controller" => app_path("Http/Controllers"),
            "model" => app_path("Models"),
            "repository" => app_path("Repositories"),
            "services" => app_path("Services"),
            "dto" => app_path("DTOs"),
        ]
    ]
];

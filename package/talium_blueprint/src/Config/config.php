<?php

return [
    "blueprint" => [
        "blueprint_path" => base_path("blueprint/"),
        "blueprint_format" => "yaml", // [yaml, json]
        "design-pattern" => "repository-pattern", //[repository-pattern],[simple-pattern],[mvc-pattern],[react-pattern]
        "router-type" => "talium_laravel_route", // if default laravel set false
        "rule-permission" => "talium_laravel_rule", // talium_laravel_rule by spatie,  if no rules set false
        "output_path" => [
            /**
             * ========================================
             * path output dari blueprint generator
             * - set false jika menggunakan exteded class kecuali controller dan model
             */
            "controller" => [
                "path" => app_path("Http/Controllers"), // null | false == default laravel
                "desain" => "talium" // [null=blank],[talium=desain talium]
            ],
            "model" => [
                "path" => app_path("Models"), // null | false == default laravel
                "desain" => "talium" // [null=blank],[talium=desain talium]
            ], // required
            /**
             * < config desain patren >
             * jika bernilai false maka akan menggunakan bawaan dari package
             */
            "form-request" => app_path("Http/Requests"), // false == extended
            "repository" => app_path("Repositories"), // false == extended
            "services" => app_path("Services"), // false == extended
            "dto" => app_path("DTOs"), // false == extended    
            /** 
             * </ end-point >
             */
            "view" => [
                /**
                 *  ========================================
                 * path output dari blueprint generator
                 */
                "blueprint-view-model" => "stub", // [stub, html, react, pug]
                "output-view-model" => "blade", // [blade, pug, react]
                /**
                 * ----------------------------------------
                 */
                /**
                 * path per page view
                 * [default=resources/views/pages]
                 * << path dari view per page >>
                 */
                "view-pages" => "pages",
                /**
                 * path blueprint ui
                 * [default=blueprint/UI]
                 * << path dari blueprint UI, kumpulan komponent-komponet [stub,...]>>
                 */
                "blueprint-components-path" => "blueprint/UI",
                /**
                 * blade-component, html-base, react-component
                 * << type dari component yang akan digunakan >>
                 */
                "blueprint-components-type" => "blade-component",
            ]
        ]
    ]
];

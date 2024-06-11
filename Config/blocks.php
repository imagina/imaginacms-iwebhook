<?php

$vAttributes = include(base_path() . '/Modules/Isite/Config/standardValuesForBlocksAttributes.php');

return [
    "hook-status" => [
        "title" => "Hook Status",
        "systemName" => "iwebhooks::hook-status",
        "nameSpace" => "Modules\Iwebhooks\View\Components\HookStatus",
        "contentFields" => [
            "title" => [
                "name" => "title",
                "type" => "input",
                "columns" => "col-12",
                "isTranslatable" => true,
                "props" => [
                    "label" => "Título",
                ]
            ],
        ],
        "attributes" => [
            "general" => [
                "title" => "General",
                "fields" => [
                    "classes" => [
                        "name" => "classes",
                        "value" => "",
                        "type" => "input",
                        "columns" => "col-12",
                        "props" => [
                            "label" => "Clases General",
                        ]
                    ],
                    "onlineLabelColor" => [
                        "name" => "onlineLabelColor",
                        "value" => "#28a745",
                        "type" => "inputColor",
                        "props" => [
                            "label" => "Online Color",
                        ]
                    ],
                    "offlineLabelColor" => [
                        "name" => "offlineLabelColor",
                        "value" => "#856404",
                        "type" => "inputColor",
                        "props" => [
                            "label" => "Offline Color",
                        ]
                    ],
                    "textLabelColor" => [
                        "name" => "textLabelColor",
                        "value" => "#ffffff",
                        "type" => "inputColor",
                        "props" => [
                            "label" => "Color del texto (Online Offline)",
                        ]
                    ],
                    "colorLink" => [
                        "name" => "colorLink",
                        "type" => "inputColor",
                        "props" => [
                            "label" => "Color de la Dirección",
                        ]
                    ],
                ]
            ],
            "flag" => [
              "title" => "Bandera",
              "fields" => [
                "iconWidth" => [
                  "name" => "iconWidth",
                  "value" => "15px",
                  "type" => "input",
                  "props" => [
                    "label" => "Ancho",
                  ]
                ],
                "iconPosition" => [
                  "name" => "iconPosition",
                  "value" => "left",
                  "type" => "select",
                  "props" => [
                    "label" => "Posición",
                    "options" => [
                      ["label" => "Izquierda", "value" => "left"],
                      ["label" => "Derecha", "value" => "right"]
                    ]
                  ]
                ],
                "iconStyle" => [
                  "name" => "iconStyle",
                  "columns" => "col-12",
                  "type" => "input",
                  "props" => [
                    "label" => "Estilo",
                    'type' => 'textarea',
                    'rows' => 4,
                  ]
                ],
              ]
            ],
            "table" => [
                "title" => "Tabla",
                "fields" => [
                    "tableClasses" => [
                        "name" => "tableClasses",
                        "type" => "input",
                        "columns" => "col-12",
                        "props" => [
                            "label" => "Clases (Table)",
                        ],
                        "help" => [
                            "description" => "Posibles: table-hover table-dark table-borderless table-striped",
                        ]
                    ],
                    "theadClasses" => [
                        "name" => "theadClasses",
                        "value" => "",
                        "type" => "input",
                        "columns" => "col-12",
                        "props" => [
                            "label" => "Clases head (Table)",
                        ],
                        "help" => [
                            "description" => "Posibles: thead-light thead-dark",
                        ]
                    ],
                    "tbodyClasses" => [
                        "name" => "tbodyClasses",
                        "value" => "",
                        "type" => "input",
                        "columns" => "col-12",
                        "props" => [
                            "label" => "Clases body (Table)",
                        ],
                        "help" => [
                            "description" => "Posibles: table-active table-primary table-secondary table-success table-danger table-warning table-info table-light table-dark ",
                        ]
                    ],
                    "theadStyles" => [
                        "name" => "theadStyles",
                        "type" => "input",
                        "columns" => "col-12",
                        "props" => [
                            "label" => "Style thead (Table)",
                            'type' => 'textarea',
                            'rows' => 4,
                        ],
                    ],
                    "tbodyStyles" => [
                        "name" => "tbodyStyles",
                        "type" => "input",
                        "columns" => "col-12",
                        "props" => [
                            "label" => "Style tbody (Table)",
                            'type' => 'textarea',
                            'rows' => 4,
                        ],
                    ],
                    "tableResponsive" => [
                        "name" => "tableResponsive",
                        "value" => "table-responsive",
                        "type" => "select",
                        "props" => [
                            "label" => "Tabla responsive",
                            "options" => [
                                ["label" => "Sin responsive", "value" => ""],
                                ["label" => "Normal", "value" => "table-responsive"],
                                ["label" => "xl", "value" => "table-responsive-xl"],
                                ["label" => "lg", "value" => "table-responsive-lg"],
                                ["label" => "md", "value" => "table-responsive-md"],
                                ["label" => "sm", "value" => "table-responsive-sm"],
                            ]
                        ]
                    ],
                    "tableSize" => [
                        "name" => "tableSize",
                        "value" => "",
                        "type" => "select",
                        "props" => [
                            "label" => "Tamaño Tabla",
                            "options" => [
                                ["label" => "Normal", "value" => ""],
                                ["label" => "Pequeña", "value" => "table-sm"],
                            ]
                        ]
                    ],
                    "datatables" => [
                        "name" => "datatables",
                        "value" => "0",
                        "type" => "select",
                        "props" => [
                            "label" => "Datatables",
                            "options" => $vAttributes["validation"]
                        ]
                    ],
                    "ordering" => [
                        "name" => "ordering",
                        "value" => "0",
                        "type" => "select",
                        "props" => [
                            "label" => "Ordenar",
                            "options" => $vAttributes["validation"]
                        ]
                    ],
                    "paging" => [
                        "name" => "paging",
                        "value" => "0",
                        "type" => "select",
                        "props" => [
                            "label" => "Paginacion",
                            "options" => $vAttributes["validation"]
                        ]
                    ],
                    "pagingType" => [
                        "name" => "pagingType",
                        "value" => "simple_numbers",
                        "type" => "select",
                        "props" => [
                            "label" => "Tipo de paginado",
                            "options" => [
                                ["label" => "simple", "value" => "simple"],
                                ["label" => "full", "value" => "full"],
                                ["label" => "full numbers", "value" => "full_numbers"],
                                ["label" => "numbers", "value" => "numbers"],
                                ["label" => "simple numbers no ellipses", "value" => "simple_numbers_no_ellipses"],
                                ["label" => "full numbers no ellipses", "value" => "full_numbers_no_ellipses"],
                                ["label" => "first last_numbers", "value" => "first_last_numbers"],
                                ["label" => "first last_numbers no_ellipses", "value" => "first_last_numbers_no_ellipses"],
                                ["label" => "simple numbers", "value" => "simple_numbers"]
                            ]
                        ]
                    ],
                    "searching" => [
                        "name" => "searching",
                        "value" => "0",
                        "type" => "select",
                        "props" => [
                            "label" => "searching",
                            "options" => $vAttributes["validation"]
                        ]
                    ],
                    "info" => [
                        "name" => "info",
                        "value" => "0",
                        "type" => "select",
                        "props" => [
                            "label" => "info",
                            "options" => $vAttributes["validation"]
                        ]
                    ],
                    "lengthChange" => [
                        "name" => "lengthChange",
                        "value" => "0",
                        "type" => "select",
                        "props" => [
                            "label" => "lengthChange",
                            "options" => $vAttributes["validation"]
                        ]
                    ],
                    "lengthMenu" => [
                        "name" => "lengthMenu",
                        "value" => [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                        "type" => "json",
                        'columns' => 'col-12',
                        "props" => [
                            "label" => "Limites Paginado"
                        ]
                    ],
                    "columnDefs" => [
                        "name" => "columnDefs",
                        "value" => [["width" => "auto", "targets" => "0"],["width" => "auto", "targets" => "1"],["width" => "auto", "targets" => "2"]],
                        "type" => "json",
                        'columns' => 'col-12',
                        "props" => [
                            "label" => "Ancho Columna"
                        ]
                    ],
                ]
            ],
            "texto" => [
                "title" => "Título",
                "fields" => [
                    "titleClasses" => [
                        "name" => "titleClasses",
                        "value" => "",
                        "type" => "input",
                        "columns" => "col-12",
                        "props" => [
                            "label" => "Clases (Titulo)",
                        ]
                    ],
                    "titleAlign" => [
                        "name" => "titleAlign",
                        "value" => "text-left",
                        "type" => "select",
                        "props" => [
                            "label" => "Alineación",
                            "options" => $vAttributes["align"]
                        ]
                    ],
                    "titleSize" => [
                        "name" => "titleSize",
                        "type" => "input",
                        "props" => [
                            "label" => "Tamaño Fuente (Titulo)",
                            "type" => "number"
                        ]
                    ],
                    "titleColorClasses" => [
                        "name" => "titleColorClasses",
                        "type" => "select",
                        "props" => [
                            "label" => "Color Clase (Titulo)",
                            "options" => $vAttributes["textColors"]
                        ]
                    ],
                    "titleColor" => [
                        "name" => "titleColor",
                        "type" => "inputColor",
                        "props" => [
                            "label" => "Color (Titulo)",
                        ]
                    ],
                    "titleWeight" => [
                        "name" => "titleWeight",
                        "value" => "font-weight-normal",
                        "type" => "select",
                        "columns" => "col-12",
                        "props" => [
                            "label" => "Negrita (Titulo)",
                            "options" => $vAttributes["textWeight"]
                        ]
                    ],
                    "titleTransform" => [
                        "name" => "titleTransform",
                        "type" => "select",
                        "props" => [
                            "label" => "Transformar (Titulo)",
                            "options" => $vAttributes["textTransform"]
                        ]
                    ],
                    "titleLetterSpacing" => [
                        "name" => "titleLetterSpacing",
                        "type" => "input",
                        "props" => [
                            "label" => "Espacio entre letras (Titulo)",
                            "type" => "number"
                        ]
                    ],
                ]
            ],
        ]
    ],
];

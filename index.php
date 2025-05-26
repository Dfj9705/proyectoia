<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');



$peso1 = $_POST['ejercicio'];
$peso2 = $_POST['horas'];
$umbral = $_POST['umbral'];
$aprendizaje = $_POST['aprendizaje'];
$tabla = $_POST['tablaVerdad'];


if ($tabla == '1') {
    $tablaVerdad = [
        [
            "x1" => 1,
            "x2" => 1,
            "x3" => -1,
            "T" => 1,
        ],
        [
            "x1" => 1,
            "x2" => -1,
            "x3" => -1,
            "T" => -1,
        ],
        [
            "x1" => -1,
            "x2" => 1,
            "x3" => -1,
            "T" => -1,
        ],
        [
            "x1" => -1,
            "x2" => -1,
            "x3" => -1,
            "T" => -1,
        ],
    ];
} else {
    $tablaVerdad = [
        [
            "x1" => 1,
            "x2" => 1,
            "x3" => -1,
            "T" => 1,
        ],
        [
            "x1" => 1,
            "x2" => -1,
            "x3" => -1,
            "T" => 1,
        ],
        [
            "x1" => -1,
            "x2" => 1,
            "x3" => -1,
            "T" => 1,
        ],
        [
            "x1" => -1,
            "x2" => -1,
            "x3" => -1,
            "T" => -1,
        ],
    ];
}

do {
    $multiplicacion1 = $peso1 * $tablaVerdad[0]['x1'] + $peso2 * $tablaVerdad[0]['x2'] + $umbral * $tablaVerdad[0]['x3'];
    $resultado1 = $multiplicacion1 > $umbral ? 1 : -1;

    $multiplicacion2 = $peso1 * $tablaVerdad[1]['x1'] + $peso2 * $tablaVerdad[1]['x2'] + $umbral * $tablaVerdad[1]['x3'];
    $resultado2 = $multiplicacion2 > $umbral ? 1 : -1;

    $multiplicacion3 = $peso1 * $tablaVerdad[2]['x1'] + $peso2 * $tablaVerdad[2]['x2'] + $umbral * $tablaVerdad[2]['x3'];
    $resultado3 = $multiplicacion3 > $umbral ? 1 : -1;

    $multiplicacion4 = $peso1 * $tablaVerdad[3]['x1'] + $peso2 * $tablaVerdad[3]['x2'] + $umbral * $tablaVerdad[3]['x3'];
    $resultado4 = $multiplicacion4 > $umbral ? 1 : -1;



    $resultados = [
        $resultado1,
        $resultado2,
        $resultado3,
        $resultado4,
    ];


    $indice = null;

    foreach ($tablaVerdad as $key => $valor) {
        if ($valor['T'] != $resultados[$key]) {
            $indice = $key;
            break;
        }
    }

    $recorridos[] = [
        "w1" => number_format(round($peso1, 2), 2, '.', ','),
        "w2" => number_format(round($peso2, 2), 2, '.', ','),
        "umbral" => number_format(round($umbral, 2), 2, '.', ','),
        "aprendizaje" => number_format(round($aprendizaje, 2), 2, '.', ','),
        "calculos" => [
            [
                $tablaVerdad[0]['x1'],
                number_format(round($peso1, 2), 2, '.', ','),
                $tablaVerdad[0]['x2'],
                number_format(round($peso2, 2), 2, '.', ','),
                $tablaVerdad[0]['x3'],
                number_format(round($umbral, 2), 2, '.', ','),
                number_format(round($multiplicacion1, 2), 2, '.', ','),
                $resultado1,
                $tablaVerdad[0]['T'] == $resultado1 ? 'SI' : 'NO',
            ],
            [
                $tablaVerdad[1]['x1'],
                number_format(round($peso1, 2), 2, '.', ','),
                $tablaVerdad[1]['x2'],
                number_format(round($peso2, 2), 2, '.', ','),
                $tablaVerdad[1]['x3'],
                number_format(round($umbral, 2), 2, '.', ','),
                number_format(round($multiplicacion2, 2), 2, '.', ','),
                $resultado2,
                $tablaVerdad[1]['T'] == $resultado2 ? 'SI' : 'NO',
            ],
            [
                $tablaVerdad[2]['x1'],
                number_format(round($peso1, 2), 2, '.', ','),
                $tablaVerdad[2]['x2'],
                number_format(round($peso2, 2), 2, '.', ','),
                $tablaVerdad[2]['x3'],
                number_format(round($umbral, 2), 2, '.', ','),
                number_format(round($multiplicacion3, 2), 2, '.', ','),
                $resultado3,
                $tablaVerdad[2]['T'] == $resultado3 ? 'SI' : 'NO',
            ],
            [
                $tablaVerdad[3]['x1'],
                number_format(round($peso1, 2), 2, '.', ','),
                $tablaVerdad[3]['x2'],
                number_format(round($peso2, 2), 2, '.', ','),
                $tablaVerdad[3]['x3'],
                number_format(round($umbral, 2), 2, '.', ','),
                number_format(round($multiplicacion4, 2), 2, '.', ','),
                $resultado4,
                $tablaVerdad[3]['T'] == $resultado4 ? 'SI' : 'NO',
            ],
        ]

    ];

    if ($indice !== null) {
        $peso1 = $peso1 + 2 * $aprendizaje * $tablaVerdad[$indice]['x1'] * $tablaVerdad[$indice]['T'];
        $peso2 = $peso2 + 2 * $aprendizaje * $tablaVerdad[$indice]['x2'] * $tablaVerdad[$indice]['T'];
        $umbral = $umbral + 2 * $aprendizaje * $tablaVerdad[$indice]['x3'] * $tablaVerdad[$indice]['T'];
    }
}
while ($indice !== null);

echo json_encode($recorridos);

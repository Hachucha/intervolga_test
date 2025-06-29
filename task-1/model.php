<?php

function getStudentScores(): array
{
    $data = [
        ['Иванов', 'Математика', 5],
        ['Иванов', 'Математика', 4],
        ['Иванов', 'Математика', 5],
        ['Петров', 'Математика', 5],
        ['Сидоров', 'Физика', 4],
        ['Иванов', 'Физика', 4],
        ['Петров', 'ОБЖ', 4],
    ];

    $result = [];

    foreach ($data as $entry) {
        $name = $entry[0];
        $subject = $entry[1];
        $score = $entry[2];

        // Инициализация массива для ученика, если он еще не существует
        if (!isset($result[$name])) {
            $result[$name] = [];
        }

        // Инициализация массива для предмета внутри массива для ученика, если он еще не существует
        if (!isset($result[$name][$subject])) {
            $result[$name][$subject] = 0;
        }

        // Суммирование баллов по предмету
        $result[$name][$subject] += $score;
    }

    return $result;
}
?>
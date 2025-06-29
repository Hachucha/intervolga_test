<?php
require_once __DIR__ . '/model.php';

$result = getStudentScores();
?>
<table border="1">
    <tr>
        <th>ФИО</th>
        <th>Математика</th>
        <th>OБЖ</th>
        <th>Физика</th>
    </tr>
    <?php foreach ($result as $name => $subjects): ?>
        <tr>
            <td><?php echo $name; ?></td>
            <td><?php echo isset($subjects['Математика']) ? $subjects['Математика'] : 0; ?></td>
            <td><?php echo isset($subjects['ОБЖ']) ? $subjects['ОБЖ'] : 0; ?></td>
            <td><?php echo isset($subjects['Физика']) ? $subjects['Физика'] : 0; ?></td>
        </tr>
    <?php endforeach; ?>
</table>



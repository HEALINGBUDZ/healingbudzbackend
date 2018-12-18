<?php foreach ($points as $point) { ?>
    <tr>
        <td><?= date("d-m-Y", strtotime($point->created_at)); ?></td>
        <td class="task-name"><i class="fa fa-star color green"></i> <?= $point->type ?></td>
        <td>
            <p class="color green">+<?= $point->points ?> pts</p>
        </td>
    </tr>
<?php } ?>
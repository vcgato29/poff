
<h1><?php echo $product['name'] ?></h1>

<?php echo $product['description'] ?>

<br /><br /><br />
<table border="1" cellpadding="10">
<?php foreach($parameters['txt'] as $name => $value): ?>
    <tr>
        <th><?php echo $name ?></th>
        <td><?php echo $value ?></td>
    </tr>
<?php endforeach; ?>
</table>

<script type="text/javascript">
javascript:print();
</script>
<?php
/**
 * @var array $products;
 */
?><h1 class="page-header">Products</h1>
<a class="btn btn-default" href="/product/add/" role="button">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    Create product
</a>
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Category</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($products as $product){ ?>
            <?php /**@var \Vovanmix\CustomAdmin\Models\Product $product*/ ?>
            <tr>
                <th scope="row"><?=$product->getId();?></th>
                <td><?=$product->getName();?></td>
                <td><?=$product->getCategory()?></td>
                <td><?=$product->getCreated_at();?></td>
                <td><?=$product->getUpdated_at();?></td>
                <td><a href="/product/edit/<?=$product->getId();?>">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        Edit
                    </a></td>
                <td><a href="/product/delete/<?=$product->getId();?>">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        Delete
                    </a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

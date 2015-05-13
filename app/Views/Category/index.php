<?php
/**
 * @var array $categories;
 */
?>
<a class="btn btn-default" href="/category/add/" role="button">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    Create category
</a>
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Created</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($categories as $category){ ?>
            <?php /**@var \Vovanmix\CustomAdmin\Models\Category $category*/ ?>
            <tr>
                <th scope="row"><?=$category->getId();?></th>
                <td><?=$category->getName();?></td>
                <td><?=$category->getParent()?></td>
                <td><?=$category->getCreated_at();?></td>
                <td><a href="/category/edit/<?=$category->getId();?>">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        Edit
                    </a></td>
                <td><a href="/category/delete/<?=$category->getId();?>">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        Delete
                    </a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

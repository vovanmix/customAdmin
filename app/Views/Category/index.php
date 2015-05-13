<?
/**
 * @var array $categories;
 */
?>
<a class="btn btn-default" href="/category/add/" role="button">Create category</a>
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
        <? foreach($categories as $category){ ?>
            <? /**@var \Vovanmix\CustomAdmin\Models\Category $category*/ ?>
            <tr>
                <th scope="row"><?=$category->getId();?></th>
                <td><?=$category->getName();?></td>
                <td><?=$category->getParent()?></td>
                <td><?=$category->getCreated_at();?></td>
                <td><a href="/category/edit/<?=$category->getId();?>">Edit</a></td>
                <td><a href="/category/delete/<?=$category->getId();?>">Delete</a></td>
            </tr>
        <? } ?>
    </tbody>
</table>

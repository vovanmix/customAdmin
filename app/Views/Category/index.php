<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        <? foreach($categories as $category){ ?>
            <? /**@var \Vovanmix\CustomAdmin\Models\Category $category*/ ?>
            <tr>
                <th scope="row"><?=$category->getId();?></th>
                <td><?=$category->getName();?></td>
                <td><?=$category->getCreatedAt();?></td>
            </tr>
        <? } ?>
    </tbody>
</table>

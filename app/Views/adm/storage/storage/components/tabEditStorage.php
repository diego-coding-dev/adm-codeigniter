<ul class="nav nav-tabs nav-tabs-bordered">

    <li class="nav-item">
        <a href="<?php echo route_to('storage.show', $storageId); ?>" class="nav-link <?php echo ($active === 'show') ? 'active' : ''; ?>">Visão geral</a>
    </li>

    <li class="nav-item">
        <a href="<?php echo route_to('storage.add', $storageId); ?>" class="nav-link <?php echo ($active === 'add') ? 'active' : ''; ?>">Adicionar ao estoque</a>
    </li>

</ul>
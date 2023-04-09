<ul class="nav nav-tabs nav-tabs-bordered">

    <li class="nav-item">
        <a href="<?php echo route_to('product.show', $productId); ?>" class="nav-link <?php echo ($active === 'show') ? 'active' : ''; ?>">Visão geral</a>
    </li>

    <li class="nav-item">
        <a href="<?php echo route_to('product.change-image', $productId); ?>" class="nav-link <?php echo ($active === 'image') ? 'active' : ''; ?>">Alterar imagem</a>
    </li>

</ul>
<ul class="nav nav-tabs nav-tabs-bordered">

    <li class="nav-item">
        <a href="<?php echo route_to('profile.edit'); ?>" class="nav-link <?php echo ($active === 'edit') ? 'active' : ''; ?>">Editar conta</a>
    </li>

    <li class="nav-item">
        <a href="<?php echo route_to('profile.password'); ?>" class="nav-link <?php echo ($active === 'password') ? 'active' : ''; ?>">Mudar senha</a>
    </li>

</ul>
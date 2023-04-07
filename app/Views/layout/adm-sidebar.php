<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="<?php echo route_to('home') ?>">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">RH</li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#employees" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Funcionários</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="employees" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?php echo route_to('employee.list-search'); ?>">
                        <i class="bi bi-circle"></i><span>Listar</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo route_to('employee.adding'); ?>">
                        <i class="bi bi-circle"></i><span>Adicionar novo</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#clients" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Clientes</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="clients" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?php echo route_to('client.list-search'); ?>">
                        <i class="bi bi-circle"></i><span>Listar</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo route_to('client.adding'); ?>">
                        <i class="bi bi-circle"></i><span>Adicionar novo</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-heading">Estoque e Produtos</li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#type_products" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Categorias de produto</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="type_products" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?php echo route_to('type-product.list-search'); ?>">
                        <i class="bi bi-circle"></i><span>Listar</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo route_to('type-product.adding'); ?>">
                        <i class="bi bi-circle"></i><span>Adicionar novo</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

    </ul>

</aside><!-- End Sidebar-->
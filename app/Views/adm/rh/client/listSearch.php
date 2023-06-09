<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-lg-12">

    <form class="user" method="get" action="<?php echo url_to('client.list-search'); ?>">
        <div class="form-group row">
            <div class="col-sm-5 col-md-4 mb-3 mb-sm-0">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-2 small" name="name" value="<?php echo isset($name) ? esc($name) : null ?>" placeholder="Buscar cliente..." aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <?php if (session()->has('errors')) : ?>
                    <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.name'); ?></h6>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <?php if (count($clientList) < 1) : ?>

        <h4 class="text-center mt-5">Nenhum registro foi encontrado!</h4>

    <?php else : ?>

        <div class="card" style="margin-top: 40px;">
            <div class="card-body">
                <!-- Default Table -->
                <table class="table" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th style="width: 150px;" scope="col">Registrado há</th>
                            <th class="text-center" scope="col" style="width: 100px;">Ação</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($clientList as $cliente) : ?>

                            <tr>
                                <td><?php echo esc($cliente->name); ?></td>
                                <td><?php echo esc($cliente->email); ?></td>
                                <td style="width: 150px;">
                                    <?php echo esc($cliente->created_at->humanize()); ?>
                                </td>
                                <th class="text-center" style="width: 100px;">
                                    <a href="<?php echo route_to('client.show', encrypt($cliente->id)); ?>" type="button" class="btn btn-primary btn-sm"><i class="ri-eye-fill"></i></a>
                                    <a href="<?php echo route_to('client.remove', encrypt($cliente->id)); ?>" type="button" class="btn btn-danger btn-sm"><i class="ri-delete-bin-6-fill"></i></a>
                                </th>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- End Default Table Example -->

                <?php echo $pager->links(); ?>

            </div>
        </div>
</div>

<?php endif; ?>

<?php echo $this->endSection(); ?>
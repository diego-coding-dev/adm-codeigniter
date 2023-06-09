<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-lg-12">

    <form class="user" method="get" action="<?php echo url_to('storage.list-search'); ?>">
        <div class="form-group row">
            <div class="col-sm-5 col-md-4 mb-3 mb-sm-0">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-2 small" name="description" value="<?php echo isset($description) ? esc($description) : null ?>" placeholder="Buscar produto..." aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <?php if (session()->has('errors')) : ?>
                    <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.description'); ?></h6>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <?php if (count($storageList) < 1) : ?>

        <h4 class="text-center mt-5">Nenhum registro foi encontrado!</h4>

    <?php else : ?>

        <div class="card" style="margin-top: 40px;">

            <div class="card-body">
                <!-- Default Table -->
                <table class="table" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th style="width: 150px;" scope="col">Quantidade</th>
                            <th class="text-center" scope="col" style="width: 100px;">Ação</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($storageList as $storage) : ?>

                            <tr>
                                <td>
        <!--                                    <img src="<?php // echo route_to('product.image', $storage->image);  ?>" alt="" width="50px;" height="50px;">&nbsp;-->
                                    <?php echo esc($storage->description); ?>
                                </td>
                                <td style="width: 150px;">
                                    <?php echo esc($storage->quantity); ?>&nbsp;un.
                                </td>
                                <th class="text-center" style="/*width: 100px*/;">
                                    <a style="/*margin-top: 10px;*/" href="<?php echo route_to('storage.show', encrypt($storage->id)); ?>" type="button" class="btn btn-primary btn-sm"><i class="ri-eye-fill"></i></a>
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
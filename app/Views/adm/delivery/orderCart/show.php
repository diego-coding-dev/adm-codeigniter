<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-xl-4">
    <a href="<?php echo route_to('order.list') ?>" type="button" class="btn btn-secondary btn-sm">Voltar</a>
    <a href="<?php echo route_to('order.list') ?>" type="button" class="btn btn-danger btn-sm">Cancelar</a>
    <div class="col-xl-12">

        <div class="card" style="margin-top: 20px;">
            <div class="card-body">
                <div class="tab-content">

                    <div class="tab-pane fade show active profile-overview">

                        <h5 class="card-title">Cliente</h5>

                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label ">Nome</div>
                            <div class="col-lg-9 col-md-8"><?php echo esc($client->name); ?></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label">Email</div>
                            <div class="col-lg-9 col-md-8"><?php echo esc($client->email); ?></div>
                        </div>

                    </div>

                </div><!-- End Bordered Tabs -->
            </div>
        </div>
    </div>
</div>


<div class="col-xl-8">

    <a href="<?php echo route_to('order.order-cart.adding-item', $orderId); ?>" type="button" class="btn btn-primary btn-sm">Adicionar item</a>

    <div class="col-xl-12">

        <div class="card" style="margin-top: 20px;">
            <div class="card-body">
                <div class="tab-content">

                    <div class="tab-pane fade show active profile-overview">

                        <h5 class="card-title"><i class="ri-shopping-bag-2-line"></i>&nbsp;Lista de itens&nbsp;</h5>

                        <?php if (count($cartItens) < 1): ?>

                            <h4 class="text-center">A lista está vazia!</h4>

                        <?php else: ?>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Iten</th>
                                        <th class="text-center" style="width: 150px;" scope="col">Qantidade</th>
                                        <th class="text-center" scope="col" style="width: 100px;">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($cartItens as $item): ?>
                                        <tr>
                                            <td><?php echo esc($item->description); ?></td>
                                            <td class="text-center" style="width: 150px;"><?php echo esc($item->quantity); ?></td>
                                            <td class="text-center" style="width: 100px;">
                                                <a href="<?php echo route_to('order.order-cart.remove-item', encrypt($item->id)); ?>" type="button" class="btn btn-danger btn-sm"><i class="ri-delete-bin-6-fill"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>

                        <?php endif; ?>

                    </div>

                </div><!-- End Bordered Tabs -->
            </div>
        </div>

    </div>
</div>


<?php echo $this->endSection(); ?>
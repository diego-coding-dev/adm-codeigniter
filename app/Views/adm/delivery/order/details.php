<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-xl-4">

    <a href="<?php echo route_to('order.list'); ?>" type="button" class="btn btn-secondary btn-sm">Voltar</a>

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

    <div class="col-xl-12">

        <div class="card" style="margin-top: 50px;">
            <div class="card-body">
                <div class="tab-content">

                    <div class="tab-pane fade show active profile-overview">

                        <h5 class="card-title"><i class="ri-shopping-bag-2-line"></i>&nbsp;Lista de itens&nbsp;</h5>

                        <?php if (count($orderItens) < 1): ?>

                            <h4 class="text-center">A lista está vazia!</h4>

                        <?php else: ?>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Iten</th>
                                        <th class="text-center" style="width: 150px;" scope="col">Qantidade</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($orderItens as $item): ?>
                                        <tr>
                                            <td><?php echo esc($item->description); ?></td>
                                            <td class="text-center" style="width: 150px;"><?php echo esc($item->quantity); ?></td>
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
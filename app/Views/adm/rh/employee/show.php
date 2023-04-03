<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="card">
    <div class="card-body">

        <a href="<?php echo route_to('employee.list-search') ?>" type="button" class="btn btn-secondary btn-sm">Voltar</a>

        <?php if ($employee->is_active === 't') : ?>

            <a href="<?php echo route_to('employee.disable', $employee->id) ?>" type="button" class="btn btn-danger btn-sm">Desativar conta</a>

        <?php else : ?>

            <a href="<?php echo route_to('employee.reactivate', $employee->id) ?>" type="button" class="btn btn-success btn-sm">Ativar conta</a>

        <?php endif; ?>


        <div class="tab-pane fade show active profile-overview" id="profile-overview">
            <!-- <h5 class="card-title">About</h5>
            <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> -->

            <h5 class="card-title">Detalhes:</h5>

            <div class="row">
                <div class="col-lg-3 col-md-4 label ">Nome completo</div>
                <div class="col-lg-9 col-md-8"><?php echo esc($employee->name); ?></div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8"><?php echo esc($employee->email); ?></div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 label">Data de registro</div>
                <div class="col-lg-9 col-md-8"><?php echo esc(date('d/m/Y', strtotime($employee->created_at))); ?></div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 label">Status</div>
                <div class="col-lg-9 col-md-8"><?php echo ($employee->is_active === 't') ? 'Ativado' : 'Não ativado'; ?></div>
            </div>

        </div>

    </div>
</div>

<?php echo $this->endSection(); ?>
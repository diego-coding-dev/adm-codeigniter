<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-lg-12">

    <form class="user" method="get" action="<?php echo url_to('employee.list-search') ?>">
        <div class="form-group row">
            <div class="col-sm-5 col-md-4 mb-3 mb-sm-0">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-2 small" name="name" value="<?php echo isset($name) ? esc($name) : null ?>" placeholder="Buscar funcionário..." aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <?php if (session()->has('errors')) : ?>
                    <h6 class="mt-1 text-danger" style="margin-bottom: -23px;">&nbsp;*&nbsp;<?php echo session()->get('errors.name'); ?></h6>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <?php if (count($employeeList) < 1) : ?>

        <h4 class="text-center mt-5">Nenhum registro foi encontrado!</h4>

    <?php else : ?>

        <div class="card" style="margin-top: 40px;">
            <div class="card-body">
                <!-- Default Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($employeeList as $employee) : ?>

                            <tr>
                                <td><?php echo esc($employee->name); ?></td>
                                <td><?php echo esc($employee->email); ?></td>
                                <td>
                                    <?php echo ($employee->is_active === 't') ? 'Ativado' : 'Não ativado'; ?>
                                </td>
                                <th>
                                    <a href="<?php echo route_to('employee.show', $employee->id) ?>" type="button" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
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
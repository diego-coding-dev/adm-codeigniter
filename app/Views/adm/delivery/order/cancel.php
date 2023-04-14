<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="card-body mt-5">

    <div class="pt-4 pb-2">
        <!-- <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5> -->
        <h5 class="text-center">Cancelar o pedido?</h5>

        <div class="text-center mt-4">

            <form class="user" method="post" action="<?php echo route_to('order.cancel-confirm', $orderId); ?>">

                <input type="hidden" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">

                <button type="submit" class="btn btn-danger" type="submit">Sim, cancelar</button>
                <a href="<?php echo route_to('order.order-cart-show', $orderId); ?>" type="button" class="btn btn-secondary" type="submit">Não, cancelar operação</a>

            </form>

        </div>
    </div>

</div>

<?php echo $this->endSection(); ?>
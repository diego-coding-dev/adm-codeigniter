<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php echo $this->renderSection('title'); ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php echo $this->include('layout/adm-style'); ?>

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <?php echo $this->include('layout/adm-navbar'); ?>

    <?php echo $this->include('layout/adm-sidebar'); ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1><?php echo $this->renderSection('dashboard'); ?></h1>
            <!-- <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav> -->
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- content -->
                <div class="col-lg-12">
                    <div class="row">

                        <?php echo $this->include('layout/adm-messages'); ?>

                        <?php echo $this->renderSection('content'); ?>

                    </div>
                </div><!-- End content -->

            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php echo $this->include('layout/adm-script'); ?>

</body>

</html>
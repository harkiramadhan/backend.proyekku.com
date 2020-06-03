<!doctype html>
<title>Site Maintenance</title>
<style>
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
</style>
<link rel="icon" href="<?= base_url('') ?>/assets/img/brand/favicon.png" type="image/png">
<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
<!-- Icons -->
<link rel="stylesheet" href="<?= base_url('') ?>/assets/vendor/nucleo/css/nucleo.css" type="text/css">
<link rel="stylesheet" href="<?= base_url('') ?>/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
<!-- Argon CSS -->
<link rel="stylesheet" href="<?= base_url('') ?>/assets/css/argon.css?v=1.2.0" type="text/css">

<article>
    <h1>Under Maintenace!</h1>
    <div>
        <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment.</p>
        <p>&mdash; <b><a href="<?= base_url() ?>"> Proyekku.com</a></b></p>
    </div>
</article>
<article>
    <button onclick="goBack()" class="btn btn-xl btn-success"><strong><i class="fas fa-arrow-left"></i></strong>&nbsp;&nbsp;&nbsp;&nbsp;Go Back</button>
</article>

<script>
function goBack() {
    window.history.back();
}
</script>

<!--
=========================================================
* Argon Dashboard - v1.2.0
=========================================================
* Product Page: https://www.creative-tim.com/product/argon-dashboard


* Copyright  Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com



=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Proyekku.com | <?= $title ?></title>
  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('') ?>/assets/img/brand/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url('') ?>/assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="<?= base_url('') ?>/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?= base_url('') ?>/assets/css/argon.css?v=1.2.0" type="text/css">

  <?php if($this->uri->segment(1) == "project"): ?>
    <link rel="stylesheet" href="<?= base_url('') ?>/assets/css/bootstrap-datetimepicker.min.css">
  <?php endif; ?>
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          Proyekku.com
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?php if($this->uri->segment(1) == "dashboard"){echo "active";} ?>" href="<?= site_url('dashboard') ?>">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item text-center pr-2 pl-2">
              <button class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#addProject">&nbsp;&nbsp;+ Add Project&nbsp;&nbsp;</button>
            </li>
            <li class="nav-item ml--2">
              <a class="nav-link" data-toggle="collapse" data-target="#navbar-dashboards" aria-expanded="false" aria-controls="navbar-dashboards">
                  <i class="fas fa-calendar text-primary text-center mr-2"></i>
                  <span class="nav-link-text" style="cursor:pointer">Projects</span>
              </a>
              <div class="collapse <?php if($this->uri->segment(1) == "project"){echo "show";} ?>" id="navbar-dashboards">
                  <ul class="nav nav-sm flex-column">
                    <?php
                      $idpt = $this->session->userdata('iduser');
                      $getProject = $this->db->get_where('project', ['idpt' => $idpt])->result();
                      foreach($getProject as $p){
                    ?>
                    <li class="nav-item">
                      <a class="nav-link <?php if($this->uri->segment(1) == "project" && $this->uri->segment(2) == $p->id){echo "active";} ?>" href="<?= site_url('project/'.$p->id) ?>">
                        <i class="ni ni-bold-right text-primary text-capitalize"></i> <?= $p->project_name ?></a>
                    </li>
                    <?php } ?>
                  </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('Discussion') ?>">
                <i class="ni ni-chat-round text-blue"></i>
                <span class="nav-link-text">Diskusi</span>
              </a>
            </li>
          </ul>
          <hr class="p-0 m-2">
          <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php if($this->uri->segment(1) == "division"){echo "active";} ?>" href="<?= site_url('division') ?>">
                  <i class="fas fa-user-friends text-blue"></i>
                  <span class="nav-link-text">Division</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if($this->uri->segment(1) == "user"){echo "active";} ?>" href="<?= site_url('user') ?>">
                  <i class="ni ni-single-02 text-blue"></i>
                  <span class="nav-link-text">User</span>
                </a>
              </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->
          <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
            <div class="form-group mb-0">
              <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Search" type="text">
              </div>
            </div>
            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </form>
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-bell-55"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
                <!-- Dropdown header -->
                <div class="px-3 py-3">
                  <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">n</strong> notifications.</h6>
                </div>
                <!-- List group -->
                <div class="list-group list-group-flush">
                  <div class="container">
                    <article>
                        <h1>Under Maintenace!</h1>
                        <div>
                            <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment.</p>
                        </div>
                    </article>
                  </div>
                </div>
                <!-- View all -->
                <!-- <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a> -->
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-ungroup"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default  dropdown-menu-right ">
                <div class="row shortcuts px-4">
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                      <i class="ni ni-calendar-grid-58"></i>
                    </span>
                    <small>Calendar</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                      <i class="ni ni-email-83"></i>
                    </span>
                    <small>Email</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                      <i class="ni ni-credit-card"></i>
                    </span>
                    <small>Payments</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                      <i class="ni ni-books"></i>
                    </span>
                    <small>Reports</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-purple">
                      <i class="ni ni-pin-3"></i>
                    </span>
                    <small>Maps</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">
                      <i class="ni ni-basket"></i>
                    </span>
                    <small>Shop</small>
                  </a>
                </div>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="<?= base_url('') ?>/assets/img/theme/icon.png">
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold"><?= $username." - ".$role ?></span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>Settings</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-calendar-grid-58"></i>
                  <span>Activity</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-support-16"></i>
                  <span>Support</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= site_url('logout') ?>" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->

    <!-- Modal -->
    <div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="<?= site_url('project/action') ?>" method="post">
          <input type="hidden" name="type" value="add">
          <div class="modal-body bg-secondary">
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Project Name <small class="text-warning"><strong>*</strong></small></label>
                    <input type="text" name="project_name" class="form-control form-control-alternative form-control-sm" placeholder="Project Name " required>
                  </div>
                  <div class="form-group">
                    <label for="">Division <small class="text-warning"><strong>*</strong></small></label>
                    <select name="iddiv" class="form-control form-control-alternative form-control-sm" required>
                      <option value="">- Select Division -</option>
                      <?php
                        $idpt = $this->session->userdata('iduser');
                        $getdiv = $this->db->get_where('division', ['idpt' => $idpt])->result();
                        foreach($getdiv as $d){
                      ?>
                      <option value="<?= $d->id ?>"><?= $d->division ?></option>
                      <?php } ?>
                    </select>
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Start Date <small class="text-danger">*</small></label>
                  <input type="date" class="form-control form-control-alternative form-control-sm" name="start" required > 
                </div>
                <div class="form-group">
                  <label for="">End Date <small class="text-danger">*</small></label>
                  <input type="date" class="form-control form-control-alternative form-control-sm" name="end" required > 
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>


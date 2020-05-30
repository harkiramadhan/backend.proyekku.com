<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                  <h6 class="h2 text-white d-inline-block mb-0">Default</h6>
                  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                      <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                      <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Default</li>
                  </ol>
                  </nav>
              </div>
              <div class="col-lg-6 col-5 text-right">
                  <a href="#" class="btn btn-sm btn-neutral">New</a>
                  <a href="#" class="btn btn-sm btn-neutral">Filters</a>
              </div>
            </div>
            <!-- Card stats -->
            <div class="row">
              <div class="col-xl-4">
                  <div class="card card-stats">
                  <!-- Card body -->
                  <div class="card-body">
                      <div class="row">
                      <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">Total Users</h5>
                          <span class="h2 font-weight-bold mb-0"><?= $user ?></span>
                      </div>
                      <div class="col-auto">
                          <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                          <i class="ni ni-active-40"></i>
                          </div>
                      </div>
                      </div>
                  </div>
                  </div>
              </div>
              <div class="col-xl-4">
                  <div class="card card-stats">
                  <!-- Card body -->
                  <div class="card-body">
                      <div class="row">
                      <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
                          <span class="h2 font-weight-bold mb-0"><?= $userPending ?></span>
                      </div>
                      <div class="col-auto">
                          <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                          <i class="ni ni-chart-pie-35"></i>
                          </div>
                      </div>
                      </div>
                  </div>
                  </div>
              </div>
              <div class="col-xl-4">
                  <div class="card card-stats">
                  <!-- Card body -->
                  <div class="card-body">
                      <div class="row">
                      <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">Total Project</h5>
                          <span class="h2 font-weight-bold mb-0"><?= $totalProject->num_rows(); ?></span>
                      </div>
                      <div class="col-auto">
                          <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                          <i class="ni ni-money-coins"></i>
                          </div>
                      </div>
                      </div>
                  </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header bg-transparent">
          <div class="row align-items-center">
            <div class="col">
              <h5 class="h3 mb-0">Project Execution KPIs</h5>
            </div>
          </div>
        </div>
        <div class="card-body">
          <!-- Chart -->
          <div class="chart">
            <canvas id="chart-2" class="chart-canvas"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-12">
      <div class="card bg-default">

        <div class="card-header bg-transparent">
          <div class="row align-items-center">
            <div class="col">
              <h5 class="h3 text-white mb-0">Project Overview</h5>
            </div>
          </div>
        </div>

        <div class="card-body">
          <!-- Chart -->
          <div class="chart">
            <!-- Chart wrapper -->
            <canvas id="chart-3" class="chart-canvas"></canvas>
          </div>
        </div>

      </div>
    </div>
  </div>
  <hr class="mt-2">
  <div class="card mb-3" style="box-shadow: none">
    <div class="card-header border-0 bg-default">
      <h3 class="mb-0 text-white"><strong>Work Overview</strong></h3>
    </div>
    <div class="card-body" style="background-color: #f8f9fe">
      <div class="row">
        <?php foreach($totalProject->result() as $p){
          $tasks = $this->db->order_by('timestamp', "DESC")->get_where('task', ['idproject' => $p->id]); 
          $delay = $this->db->get_where('task', ['idproject' => $p->id, 'progressValue !=' => "100%", 'status' => 'Pending'])->num_rows(); 
          $jumtas = $tasks->num_rows();
          
          $start = strtotime($p->start);
          $end = strtotime($p->end);
          $datediff = $end - $start;
          $planed = round($datediff / (60 * 60 * 24));

          if($jumtas > 0){
            $this->db->select_sum('progressValue');
            $this->db->where('idproject', $p->id);
            $sum = $this->db->get('task');
            $perc = substr($sum->row()->progressValue / $jumtas, 0, 4);
            
            $tot = strtotime($tasks->row()->timestamp);
            $difftot = $tot - $start;
            $actual = round($difftot / (60 * 60 * 24));
          }else{
            $perc = 0;
            $actual = 0;
          }
        ?>
        <div class="col-xl-12">
          <div class="card p-0 mb-3">
            <div class="card-header bg-default border-0">
              <div class="row">
                <div class="col-6">
                  <h5 class="h3 mb-0 text-white"><i class="fas fa-angle-double-right"></i> &nbsp;<?= $p->project_name ?></h5>
                </div>
                <div class="col-6 text-right">
                  <h5 class="h3 mb-0 text-white"><?= date('d-m-Y', strtotime($p->start))." - ".date('d-m-Y', strtotime($p->end)) ?></h5>
                </div>
              </div>
            </div>
            <div class="card-body pb-0 bg-secondary">
              <div class="row">
                <div class="col-3">
                  <div class="card card-stats">
                    <div class="card-body p-2 bg-success">
                        <div class="row">
                          <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0 text-white">Complete</h5>
                              <span class="h2 font-weight-bold mb-0 text-white"><?= $perc ?> %</span>
                          </div>
                          <div class="col-auto">
                              <div class="icon icon-shape text-white rounded-circle shadow">
                              <i class="fas fa-check"></i>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="card card-stats">
                    <div class="card-body p-2 bg-primary">
                        <div class="row">
                          <div class="col">
                              <h5 class="card-title text-uppercase text-muted text-white mb-0">Planed</h5>
                              <span class="h2 font-weight-bold mb-0 text-white"><?= $planed ?> Days</span>
                          </div>
                          <div class="col-auto">
                              <div class="icon icon-shape text-white rounded-circle shadow">
                              <i class="fas fa-calendar-alt"></i>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="card card-stats">
                    <?php if($actual > $planed): ?>
                    <div class="card-body p-2 bg-danger">
                    <?php else: ?>
                    <div class="card-body p-2 bg-info">
                    <?php endif; ?>
                        <div class="row">
                          <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0 text-white">Actual</h5>
                              <span class="h2 font-weight-bold mb-0 text-white"><?= $actual ?> Days</span>
                          </div>
                          <div class="col-auto">
                              <div class="icon icon-shape text-white rounded-circle shadow">
                              <i class="fas fa-clock"></i>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="card card-stats">
                    <div class="card-body p-2 bg-warning">
                        <div class="row">
                          <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0 text-white">Delayed Task</h5>
                              <span class="h2 font-weight-bold mb-0 text-white"><?= $delay ?></span>
                          </div>
                          <div class="col-auto">
                              <div class="icon icon-shape text-white rounded-circle shadow">
                              <i class="fas fa-stopwatch"></i>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-12 text-center mb-3">
                  <h4>
                    <i class="fas fa-circle text-success"></i> <small class="text-default">Task Complete</small>
                    <i class="fas fa-circle text-primary ml-2"></i> <small class="text-default">Planed</small>
                    <i class="fas fa-circle text-info ml-2"></i> <small class="text-default"> < Planed</small>
                    <i class="fas fa-circle text-danger ml-2"></i> <small class="text-default"> > Planed</small>
                    <i class="fas fa-circle text-warning ml-2"></i> <small class="text-default">Delayed Task</small>
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
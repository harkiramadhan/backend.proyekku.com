      <!-- Footer -->
      <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center  text-lg-left  text-muted">
              &copy; 2020 proyekku.com
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">proyekku Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="<?= base_url('') ?>/assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="<?= base_url('') ?>/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('') ?>/assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="<?= base_url('') ?>/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="<?= base_url('') ?>/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="<?= base_url('') ?>/assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="<?= base_url('') ?>/assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <!-- Argon JS -->
  <script src="<?= base_url('') ?>/assets/js/argon.js?v=1.2.0"></script>
  <script>var base_url = '<?= base_url() ?>';</script>
  <script src="<?= base_url('') ?>/assets/js/argon.js?v=1.2.0"></script>
  <?php if($this->uri->segment(1) == "project"): ?>
    <script>
      var idproject = $('#idproject').val();
      var idpt = $('#idpt').val();
      var iddiv = $('#iddiv').val();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="<?= base_url('') ?>/assets/js/bootstrap-datetimepicker.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-bundle.min.js"></script>
    <script src="<?= base_url('assets/js/ganttJs.js') ?>"></script>
    <script type="text/javascript">
      $(function() {
        $('.datetimepicker').datetimepicker({
          format: 'YYYY-MM-DD',
          // format: 'MM-DD-YYYY',
          icons: {
            time: "fa fa-clock",
            date: "fa fa-calendar-day",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
          },
          minDate: '<?= date('m-d-Y', strtotime($project->start)) ?>',
          maxDate: '<?= date('m-d-Y', strtotime("1 day", strtotime($project->end)) ) ?>'
        });

        $("#startDatetimepicker").on("dp.change", function (e) {
              $('#endDatetimepicker').data("DateTimePicker").minDate(e.date);
          });
        $("#endDatetimepicker").on("dp.change", function (e) {
            $('#startDatetimepicker').data("DateTimePicker").maxDate(e.date);
        });
      });

      $('.taskList').click(function(){
        var selectedTaskId = $(this).attr('id');
        var type = 'detailTask';
        $.ajax({
          url: base_url + "project/modal",
          type: 'get',
          data: {selectedTaskId : selectedTaskId, type : type},
          beforeSend:function(){

          },
          success: function(data){
              $('.isiDetailTask').html(data);   
              $('html, body').animate({
                  scrollTop: $(".isiDetailTask").offset().top
              }, 1000);
          }
        });
      });

      $('#nameTaskAdd').keyup(function (e) {
          var keyCode = e.which;
          var task = $(this).val();
          var type = 'addTask';
          if (keyCode == 13) {
            $.ajax({
              url: base_url + 'project/action',
              type: 'post',
              data: {iddiv : iddiv, idproject : idproject,  task : task, type : type},
              success: function(){
                location.reload();
              },
            });
          }
      });

      $('.nav-link').click(function(){
        $('.isiDetailTask').html("<div class='card-header bg-transparent border-0'><h4 class='mb-0 text-capitalize'id='editTitle'>Detail Task</h4></div><div class='card-body bg-secondary'><button type='button' class='btn btn-block btn-sm btn-default' style='cursor: default'>Click The Task For Detail</button></div>");
        var id = $(this).attr('id');
        if(id === "tabs-icons-text-1-tab"){
          $('.dt-1').addClass('isiDetailTask');
          $('.dt-2').removeClass('isiDetailTask');
        }else{
          $('.dt-2').addClass('isiDetailTask');
          $('.dt-1').removeClass('isiDetailTask');
        }
      });
    </script>
    <script>
      $(document).ready(function(){
        $('.dt-1').addClass('isiDetailTask');
        $('.dt-2').removeClass('isiDetailTask');
        
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
          localStorage.setItem('activeTab', $(e.target).attr('id'));
          var selectedTab = e.target.id;
          if(selectedTab === "tabs-icons-text-1-tab"){
            $('.dt-1').addClass('isiDetailTask');
            $('.dt-2').removeClass('isiDetailTask');
          }else if(selectedTab === "tabs-icons-text-2-tab"){
            $('.dt-2').addClass('isiDetailTask');
            $('.dt-1').removeClass('isiDetailTask');
          }
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
          $('#tabs-icons-text a[id="' + activeTab + '"]').tab('show');
        }
      });
    </script>
    <script>
      $('.editReport').click(function(){
        var idreport = $(this).attr('data-id');
        var type = "editReport";
        var idproject = '<?= $this->uri->segment(2) ?>';
        $.ajax({
          url : '<?= site_url('project/modal') ?>',
          type : 'get',
          data: {idreport : idreport, type : type, idproject : idproject},
          success: function(data){
            $('#detailReport').modal('show');
            $('.isiReport').html(data);
          }
        });
      });
      $('.editIssue').click(function(){
        var idissue = $(this).attr('data-id');
        var type = "editIssue";
        var idproject = '<?= $this->uri->segment(2) ?>';
        $.ajax({
          url : '<?= site_url('project/modal') ?>',
          type : 'get',
          data: {idissue : idissue, type : type, idproject : idproject},
          success: function(data){
            $('#detailIssue').modal('show');
            $('.isiIssue').html(data);
          }
        });
      });
    </script>
  <?php elseif($this->uri->segment(1) == "dashboard"): ?>
  <script>
    var chartData = {
      labels: <?= $project ?>,
      datasets: [{
          label: "Total Task",
          backgroundColor: 'rgba(255, 99, 132, 1)',
          data: <?= $tot ?>
      },{
          label: "Task Complete",
          backgroundColor: "rgba(54, 162, 235, 1)",
          data: <?= $compl ?>
      }, {
          label: "Delayed Task",
          backgroundColor: "rgba(255, 206, 86, 1)",
          data: <?= $del ?>
      }, {
          label: "Missed Deadlines",
          backgroundColor: "rgba(75, 192, 192, 1)",
          data: <?= $miss ?>
      }],
      
    };

    var canvas = document.getElementById('chart-2');
    var myBarChart = new Chart(canvas, {
      type: "bar",
      data: chartData,
      options: {
          legend: {display: true, position:'bottom', labels:{fontSize:13, padding:15,boxWidth:12},},
          title: {display: false},
          scales: {
              xAxes: [{
                  display: true,
                  ticks: {
                      suggestedMin: 0
                  }
              }]
          }
      }
    });
  </script>
  <script>
    var SalesChart = (function() {
      var $chart = $('#chart-3');
      function init($chart) {

        var salesChart = new Chart($chart, {
          type: 'line',
          options: {
            scales: {
              yAxes: [{
                gridLines: {
                  lineWidth: 1,
                  color: Charts.colors.gray[900],
                  zeroLineColor: Charts.colors.gray[900]
                },
                ticks: {
                  callback: function(value) {
                    if (!(value % 10)) {
                      return value + '%';
                    }
                  }
                }
              }]
            },
            tooltips: {
              callbacks: {
                label: function(item, data) {
                  var label = data.datasets[item.datasetIndex].label || '';
                  var yLabel = item.yLabel;
                  var content = '';

                  if (data.datasets.length > 1) {
                    content += 'Progress ' + label + '%';
                  }

                  content +=  'Progress ' + yLabel + '%';
                  return content;
                }
              }
            }
          },
          data: {
            labels: <?= $project ?>,
            datasets: [{
              label: 'Performance',
              data: <?= $perc ?>
            }]
          }
        });
        $chart.data('chart', salesChart);
      };
      if ($chart.length) {
        init($chart);
      }
    })();
  </script>
  <?php endif; ?>
</body>

</html>
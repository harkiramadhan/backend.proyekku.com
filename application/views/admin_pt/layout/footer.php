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
        format: 'YYYY-MM-DD HH:mm',
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
        }
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
        }
    });
    });

    $('#nameTaskAdd').keyup(function (e) {
        var keyCode = e.which;
        var isi = $(this).val();
        console.log("keyup ("+keyCode+")")
        if (keyCode == 13) {
          alert(isi);
            // console.log("enter");
            // return false;
        }
    });
    
  </script>
  <?php endif; ?>
</body>

</html>
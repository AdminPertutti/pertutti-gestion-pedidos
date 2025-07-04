<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.9.1  
  </div>
  <strong>  Copyright &copy; 2018-2021 Hernán Quatraro</a>.</strong> All rights
  reserved.
</footer>
<div class="control-sidebar-bg"></div>
</div>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>
</body>
</html>

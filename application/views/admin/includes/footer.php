

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>CG</b> Admin System | Version 12.6
        </div>
        <strong>Copyright &copy; 2020 <a href="<?php echo base_url(); ?>"><?=$this->config->item('app_name')?></a>.</strong> All rights reserved.
    </footer>
    <script src="<?php echo base_url(); ?>assets/admin/js/datatables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/dist/js/app.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/validation.js" type="text/javascript"></script>


	<script src="https://ckeditor.com/latest/ckeditor.js"></script>

	<script>
	
		if($("#editor1").length != 0) 
		{
			CKEDITOR.replace( 'editor1' );
		}
		if($("#editor2").length != 0) 
		{
			CKEDITOR.replace( 'editor2' );
		}
		if($("#editor").length != 0) 
		{
			CKEDITOR.replace( 'editor' );
			
			CKEDITOR.editorConfig = function( config ) {
				config.toolbar = [
					{ name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
					{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
					{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
					'/',
					{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
					{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
					{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
					{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak' ] },
					'/',
					{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
					{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
					{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] }
				];
			};
		}
	</script>
    <script type="text/javascript">
		$('.data_table').DataTable();
		$('.select2').select2();
		
		var url = window.location;
		// for sidebar menu but not for treeview submenu
		$('ul.sidebar-menu a').filter(function() {
			return this.href == url;
		}).parent().siblings().removeClass('active').end().addClass('active');
		// for treeview which is like a submenu
		$('ul.treeview-menu a').filter(function() {
			return this.href == url;
		}).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active menu-open').end().addClass('active menu-open');
		
    </script>
  </body>
</html>
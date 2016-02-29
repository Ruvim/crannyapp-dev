</div>
    </div>
    <div class="copy-right">2015 Cranny Application</div>
  </div>
  	<div id="dialog-message" title="Delete" style="display:none;"><p>Do you really want to remove this image ?</p></div>
	<div id="dialog-confirm" title="Delete" style="display:none;"><p>Are you sure you want to delete this?</p></div>
    <div id="dialog-status" title="Status" style="display:none;"><p>Are you sure you want to change the status?</p></div>
	<div id="delete-alert" title="Warning" style="display:none;"><p>Please select records</p></div>  
    
  <!--  <script type="text/javascript">
		    function open_image()
			{
				$('.imgView').css('display', 'block');
				$('.imgView').addClass('showimage');
			}
			function close_image(){
				$('.imgView').css('display', 'none');
				$('.imgView').removeClass('showimage');
			}
    </script>
    -->
    <script type="text/javascript">
		$('.open_image').click(function(){
			$(this).next('.imgView').addClass('showimage')	
		});
		function close_image(){
			$('.imgView').removeClass('showimage');
		}
    </script>
</body>
</html>
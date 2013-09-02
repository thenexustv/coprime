<?php

	$episode = Nexus_Episode::factory($post);
	$url = urlencode($episode->get_permalink());
	$title = urlencode($episode->get_title());

?>
<!-- share -->
<div class="share">
	<div class="box">
		<h4>Share</h4>

		<div class="container">
		
			<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo $url; ?>&amp;send=false&amp;layout=box_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=90" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:62px; display:inline;" allowTransparency="true"></iframe>
														
			<!-- Place this tag where you want the +1 button to render -->
			<div style="display:inline; padding: 0 5px 0 5px;"><g:plusone size="tall" href="<?php echo $url; ?>"></g:plusone></div>

			<!-- Place this render call where appropriate -->
			<script type="text/javascript">
			(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'http://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			})();
			</script>

			<iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/tweet_button.html#via=thenexustv&url=<?php echo $url; ?>&counturl=<?php echo $url; ?>&text=The-Nexus.tv: <?php $title; ?>&count=vertical" width="55" height="62" style="display:inline;"></iframe>
		
		</div>
	</div>
</div>
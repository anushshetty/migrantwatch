<!doctype html>
<html lang="en">
<head>
	<title>jQuery UI Tabs - Content via Ajax</title>
	<link type="text/css" href="development-bundle/themes/base/ui.all.css" rel="stylesheet" />
	<script type="text/javascript" src="development-bundle/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="development-bundle/ui/ui.core.js"></script>
	<script type="text/javascript" src="development-bundle/ui/ui.tabs.js"></script>
	<link type="text/css" href="development-bundle/demos/demos.css" rel="stylesheet" />
	<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
	</script>
</head>
<body>

<div class="demo">

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Nunc tincidunt</a></li>
		<li><a href="http://localhost/migwatch/trackspecies2.php">Ajax Tab 1</a></li>
		<li><a href="test.php">Ajax Tab 2</a></li>
	</ul>
	<div id="tabs-1">
		<p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
	</div>
</div>

</div><!-- End demo -->

<div class="demo-description">

<p>Fetch external content via Ajax for the tabs by setting an href value in the tab links.  While the Ajax request is waiting for a response, the tab label changes to say "Loading...", then returns to the normal label once loaded.</p>

</div><!-- End demo-description -->

</body>
</html>

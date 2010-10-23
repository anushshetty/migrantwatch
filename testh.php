<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>history plugin demo</title>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="jquery.history.js"></script>
	<script type="text/javascript">
	var $j = jQuery.noConflict();
	var $ = {};
	// PageLoad function
	// This function is called when:
	// 1. after calling $.historyInit();
	// 2. after calling $.historyLoad();
	// 3. after pushing "Go Back" button of a browser
	function pageload(hash) {
		// hash doesn't contain the first # character.
		if(hash) {
        
			// restore ajax loaded state
			$j("#load").load(hash + ".php");
        alert(hash);
		} else {
			// start page
			$j("#load").empty();
		}
	}
	
	$j(document).ready(function(){
		// Initialize history plugin.
		// The callback is called at once by present location.hash. 
		$j.history.init(pageload);
		
		// set onlick event for buttons
		$j("a[@rel='history']").click(function(){
			// 
			var hash = this.href;
        
			hash = hash.replace(/^.*#/, '');
			// moves to a new page. 
			// pageload is called at once. 
			$j.history.load(hash);
			return false;
		});
	});
	</script>
</head>

<body>
	Ajax load<br>
	<a href="#1" rel="history">load 1</a><br>
	<a href="#2" rel="history">load 2</a><br>
	<a href="#3" rel="history">load 3</a><br>
	
	<hr>
	Loaded html:<br>

	<div id="load"></div>
	<hr>
</body>
</html>


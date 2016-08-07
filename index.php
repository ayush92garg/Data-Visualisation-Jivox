<?php

	// $menu_types = array("Population","Profession","Education");
	$menu_types = array("Education");
	$sub_menu_types = array("City","State");

?>
<!DOCTYPE html>
<html>
	<head>
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
		<link rel="stylesheet" href="static/jivox.css">
		<script src="static/sweetalert.min.js"></script> <link rel="stylesheet" type="text/css" href="static/sweetalert.css">
	</head>
	<body>
		<div class="header">
			<div class="row">
				<div class="col s12 z-depth-1 center-align offset-s1"><span class="flow-text">Indian Education Based Census Report</span></div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col s3">
					<ul id="nav-mobile" class="side-nav fixed">
						<div class="row">
							<div class="col s12 offset-s4"><span class="flow-text">Menu</span></div>
						</div>
						<div class="menu-header">
							
						</div>
						<?php foreach ($menu_types as $main_menu) { ?>
						<li class="no-padding">
							<ul class="collapsible collapsible-accordion">
								<li>
									<a class="collapsible-header waves-effect waves-teal"><?php echo $main_menu;?></a>
									<div class="collapsible-body">
										<ul>
											<?php foreach ($sub_menu_types as $sub_menu) { ?>
												<li><a class="<?php echo strtolower($sub_menu);?>"><?php echo $sub_menu;?></a></li>
											<?php } ?>
										</ul>
									</div>
								</li>
							</ul>
						</li>
						<?php  } ?>
					</ul>
				</div>
				<div class="col s9 chart_sec">
					<div class="input-field col s4 hide state_select">
						<select>
							<option value="" disabled selected>Select State</option>
						</select>
					</div>
					<div class="input-field col s4 hide city_select">
						<select>
							<option value="" disabled selected>Select City</option>
						</select>
					</div>
					<div class="input-field col s4 hide type_select">
						<select>
							<option value="" disabled selected>Select Type</option>
							<option value="Age">Age</option>
							<option value="Gender">Gender</option>
							<option value="Type">Qualification</option>
						</select>
					</div>
					<!-- <div class="chart"><svg width="800" height="500"></svg></div> -->
					<div id="container"></div>
					<!-- <div id='map' class='map'> </div> -->
					<!-- <a class="waves-effect waves-light waves-red btn-large">Gio Graph</a> -->
					<a class="waves-effect waves-light waves-red btn-large hide" id="bar_graph" data-type="column">Bar Chart</a>
					<a class="waves-effect waves-light waves-red btn-large hide" id="pie_graph" data-type="pie">Pie Chart</a>
				</div>
				<div class="preloader-wrapper big active hide">
					<div class="spinner-layer spinner-blue">
						<div class="circle-clipper left">
							<div class="circle"></div>
						</div>
						<div class="gap-patch">
							<div class="circle"></div>
						</div>
						<div class="circle-clipper right">
							<div class="circle"></div>
						</div>
					</div>

					<div class="spinner-layer spinner-red">
						<div class="circle-clipper left">
							<div class="circle"></div>
						</div>
						<div class="gap-patch">
							<div class="circle"></div>
						</div>
						<div class="circle-clipper right">
							<div class="circle"></div>
						</div>
					</div>

					<div class="spinner-layer spinner-yellow">
						<div class="circle-clipper left">
							<div class="circle"></div>
						</div>
						<div class="gap-patch">
							<div class="circle"></div>
						</div>
						<div class="circle-clipper right">
							<div class="circle"></div>
						</div>
					</div>

					<div class="spinner-layer spinner-green">
						<div class="circle-clipper left">
							<div class="circle"></div>
						</div>
						<div class="gap-patch">
							<div class="circle"></div>
						</div>
						<div class="circle-clipper right">
							<div class="circle"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="static/jivox.js"></script>
	</body>
</html>
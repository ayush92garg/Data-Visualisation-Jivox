/**
	Author: Harish, Ayush
	All the js events and chart definitions
	Uses : highcharts.js for charts and materializecss.js for UI, REST framework followed for ajax requests
*/

// global variables, site url needs to be changed
server_url = "http://192.168.5.106/";
var chart_data=null;

// initialize side nav menu
$('.collapsible').collapsible({
	accordion : true
});

// change chart type
$("#bar_graph,#pie_graph,#line_graph").click(function(){
	drawBarChart(chart_data,$(this).data("type"),$(".type_select").hasClass("compare_call"));
});
// click of secondary navs
$(".analyze_city,.analyze_state").click(function(){
	$(".state_select,.city_select,.type_select,.city_select_2,.city_select_1").addClass("hide");
	$(".type_select").removeClass("compare_call");
	// cleanup pre loaded dropdown options
	$(".city_select select,.state_select select").find(".dynamic_list").remove();
	// in case of city selection, show city dropdown along with type and state
	// or show only state dropdown
	if($(this).hasClass("analyze_city")){
		$(".state_select,.city_select,.type_select").removeClass("hide");
		$(".state_select").removeClass("onlyState");
	}else{
		$(".state_select").removeClass("hide").addClass("onlyState");
		$(".type_select").removeClass("hide");
		$(".city_select").addClass("hide");
	}
	// start loader and hide chart container
	$(".preloader-wrapper,.chart_sec").toggleClass("hide");
	// Make REST call to get list of states
	// and preload into the drop down
	$.ajax({
		"url": server_url+"jivox/state/list",
		"method":"GET",
		"dataType":"jsonp",
		"jsonpCallback": 'callback',
		"success":function(state_list){
			$.each(state_list,function(key,value){
				$(".state_select select").append("<option class='dynamic_list' value="+value.stateId+">"+value.stateName+"</option>");
			});
			$('select').material_select();
			$(".preloader-wrapper,.chart_sec").toggleClass("hide");
		}
	});
});
// on change of state dropdown
// load city in case of city section
// or load state related data
$(document).on("change",".state_select select",function(){
	// alert message in the case of no state option gets picked or changed back to null
	if($(".state_select select").find("option:selected").attr("value")==""){
		swal({   title: "Error!",   text: "Please select state!",   type: "error",   confirmButtonText: "Got it!" });
		return false;
	}
	// clean up pre loaded contents from city
	$(".city_select select").find(".dynamic_list").remove();
	// loader
	$(".preloader-wrapper,.chart_sec").toggleClass("hide");
	// in case of state call
	// directly call chart
	// if not get the list of tickers and load dropdown
	if($(".state_select").hasClass("onlyState")){
		// use age as default type
		type = $(".type_select select").find("option:selected").attr("value");
		if($(".type_select select").find("option:selected").attr("value")==""){
			type = "Age";
		}
		// ajax call to get date to draw chart
		$.ajax({
			"url": server_url+"jivox/state/"+$(".state_select select").find("option:selected").attr("value")+"/"+type,
			"method":"GET",
			"dataType":"jsonp",
			"jsonpCallback": 'callback',
			"success":function(data){
				drawBarChart(data,"column");
				$(".preloader-wrapper,.chart_sec").toggleClass("hide");
			}
		});
	}else{
		// ajax call to get all the city list and populate into dropdown
		$.ajax({
			"url": server_url+"jivox/state/"+$(".state_select select").find("option:selected").attr("value")+"/list",
			"method":"GET",
			"dataType":"jsonp",
			"jsonpCallback": 'callback',
			"success":function(city_list){
				$.each(city_list,function(key,value){
					$(".city_select select").append("<option class='dynamic_list' value="+value.cityId+">"+value.cityName+"</option>");
				});
				$('select').material_select();
				$(".preloader-wrapper,.chart_sec").toggleClass("hide");
			}
		});
	}
		
});
// change of city of type dropdowns
$(document).on("change",".city_select select,.type_select select",function(){
	if($(".type_select").hasClass("compare_call")){
		// empty/missing fields alert
		if($(".city_select_1 select").find("option:selected").attr("value")=="" || $(".city_select_1 select").find("option:selected").attr("value")==""){
			swal({   title: "Error!",   text: "Please select city!",   type: "error",   confirmButtonText: "Got it!" });
			return false;
		}
	}else{
		// empty/missing fields alert
		if($(".city_select select").find("option:selected").attr("value")=="" && !$(".state_select").hasClass("onlyState")){
			swal({   title: "Error!",   text: "Please select city!",   type: "error",   confirmButtonText: "Got it!" });
			return false;
		}
	}
	
	// use age type as default type
	type = $(".type_select select").find("option:selected").attr("value");
	if($(".type_select select").find("option:selected").attr("value")==""){
		type = "Age";
	}
	// differect REST urls for city and states
	if($(".state_select").hasClass("onlyState")){
		url = "jivox/state/"+$(".state_select select").find("option:selected").attr("value")+"/"+type;
	}else if($(".type_select").hasClass("compare_call")){
		url ="jivox/compare/"+$(".city_select_1 select").find("option:selected").attr("value")+"/"+$(".city_select_2 select").find("option:selected").attr("value")+"/"+type;
	}else{
		url = "jivox/city/"+$(".state_select select").find("option:selected").attr("value")+"/"+$(".city_select select").find("option:selected").attr("value")+"/"+type;
	}
	console.log($(".type_select").hasClass("compare_call"));
	$(".preloader-wrapper,.chart_sec").toggleClass("hide");
	$.ajax({
		"url": server_url+url,
		"method":"GET",
		"dataType":"jsonp",
		"jsonpCallback": 'callback',
		"success":function(data){
			// draw graph on sucess
			drawBarChart(data,"column",$(".type_select").hasClass("compare_call"));
			$(".preloader-wrapper,.chart_sec").toggleClass("hide");
		}
	});

});

// COMPARE TWO CITIES OR STATES
$(".compare_city,.compare_state").click(function(){
	$(".state_select").removeClass("onlyState");
	$(".state_select,.city_select,.type_select,.city_select_2,.city_select_1").addClass("hide");
	$(".city_select_1 select,.city_select_2 select").find(".dynamic_list").remove();
	// Make REST call to get list of states
	// and preload into the drop down
	$(".preloader-wrapper,.chart_sec").toggleClass("hide");
	$.ajax({
		"url": server_url+"jivox/city/list",
		"method":"GET",
		"dataType":"jsonp",
		"jsonpCallback": 'callback',
		"success":function(city_list){
			$.each(city_list,function(key,value){
				$(".city_select_1 select,.city_select_2 select").append("<option class='dynamic_list' value="+value.cityName+">"+value.cityName+"</option>");
			});
			$('select').material_select();
			$(".city_select_1,.city_select_2,.type_select").removeClass("hide");
			$(".type_select").addClass("compare_call");
			$(".preloader-wrapper,.chart_sec").toggleClass("hide");
		}
	});
});
$(document).on("change",".city_select_1 select,.city_select_2 select",function(){
	// empty/missing fields alert
	if($(".city_select_1 select").find("option:selected").attr("value")=="" || $(".city_select_2 select").find("option:selected").attr("value")==""){
		return false;
	}
	if($(".city_select_1 select").find("option:selected").attr("value")==$(".city_select_2 select").find("option:selected").attr("value")){
		swal({   title: "Error!",   text: "Please select two different cities to compare!",   type: "error",   confirmButtonText: "Got it!" });
		return false;
	}
	// use age type as default type
	type = $(".type_select select").find("option:selected").attr("value");
	if($(".type_select select").find("option:selected").attr("value")==""){
		type = "Age";
	}
	// Make REST call to get list of states
	// and preload into the drop down
	$(".preloader-wrapper,.chart_sec").toggleClass("hide");
	$.ajax({
		"url": server_url+"jivox/compare/"+$(".city_select_1 select").find("option:selected").attr("value")+"/"+$(".city_select_2 select").find("option:selected").attr("value")+"/"+type,
		"method":"GET",
		"dataType":"jsonp",
		"jsonpCallback": 'callback',
		"success":function(data){
			drawBarChart(data,"column",true);
			$(".preloader-wrapper,.chart_sec").toggleClass("hide");
		}
	});
});
// draw graph
// uses highcharts api to draw charts
function drawBarChart(data,chart_type,multi_graph){
	chart_data = data;
	$("#bar_graph,#pie_graph,#line_graph").removeClass("hide");
	if(typeof multi_graph == 'undefined' || !multi_graph){
		arr = $.map(data[1], function(el) { return el });
		series_arr = [{
			"name":"Population",
			data:arr
		}];
	}else{
		series_arr = data[1];
		$("#pie_graph").addClass("hide");
	}
	$('#container').highcharts({
		chart: {
			type: chart_type
		},
		xAxis: {
			categories: data[0]
		},
		yAxis: {
			min: 0
		},
		legend: {
			reversed: false
		},
		plotOptions: {
			series: {
			// stacking: 'normal'
			},
			"pie":{
				allowPointSelect: false,
				cursor: 'pointer',
				showInLegend: false,
				dataLabels: {
					enabled: false,
				}
			}
		},
		series: series_arr
	});
}
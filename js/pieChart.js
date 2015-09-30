function drawPieChart(cons){
	
/* 
var Beispieldatensatz = [
	{"value": 100, "name": "alpha"},
	{"value": 70, "name": "beta"},
	{"value": 40, "name": "gamma"},
	{"value": 15, "name": "delta"},
	{"value": 5, "name": "epsilon"},
	{"value": 1, "name": "zeta"}
];*/
		
	var width = $("#graph1").parent("div").width();
	var height = $("#graph1").parent("div").height();
	
	d3plus.viz()
		.container("#graph1")
		.data(cons)
		.type("pie")
		.id("geraet")
		.size("verbrauch")
		.width(width/2)
		.height(height/2.5)
		.color({
		  "heatmap": ["#C5E1A5", "#AED581", "#9CCC65", "#8BC34A", "#7CB342", "#689F38"],
		  "value": "verbrauch"
		})
		.draw();
}


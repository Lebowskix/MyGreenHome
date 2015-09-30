function drawLineChart(dailyCons){
/* 
var Beispieldatensatz = [   
	{"datum": 22.09, "name":"verb", "verbrauch":2.07},
    {"datum": 21.09, "name":"verb", "verbrauch":1.57},
    {"datum": 20.09, "name":"verb", "verbrauch":0.97},
    {"datum": 19.09, "name":"verb", "verbrauch":3.12}
]; 
*/
	
	var width = $("#graph1").parent("div").width();
	var height = $("#graph1").parent("div").height();

	var attributes = [
		{"name": "Tages-Verbrauch", "hex": "#A1CD39"},
	]
  // instantiate d3plus
	d3plus.viz()
		.container("#graph2")  // container DIV to hold the visualization
		.data(dailyCons)  // data to use with the visualization
		.type("line")       // visualization type
		.id("name")         // key for which our data is unique on
		.text("name")       // key to use for display text 
		.y("verbrauch")         // key to use for y-axis
		.x("datum") 			// key to use for x-axis
		.width(width)
		.height(height/2.5)
		.attrs(attributes)
		.color("hex")
		.draw();             // draw the visualization
}


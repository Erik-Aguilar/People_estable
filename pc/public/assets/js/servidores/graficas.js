
    
function graf() {
    var chart = new CanvasJS.Chart("VentasTotales",
    {
      title:{
        text: "Top Oil Reserves"    
      },
      animationEnabled: true,
      axisY: {
        title: "Reserves(MMbbl)"
      },
      legend: {
        verticalAlign: "bottom",
        horizontalAlign: "center"
      },
      theme: "theme2",
      data: [

      {        
        type: "column",  
        showInLegend: true, 
        legendMarkerColor: "grey",
        legendText: "MMbbl = one million barrels",
        dataPoints: [      
        {y: 297571, label: "Venezuela"},
        {y: 267017,  label: "Saudi" },
        {y: 175200,  label: "Canada"},
        {y: 154580,  label: "Iran"},
        {y: 116000,  label: "Russia"},
        {y: 97800, label: "UAE"},
        {y: 20682,  label: "US"},        
        {y: 20350,  label: "China"}        
        ]
      }   
      ]
    });

    chart.render();
  



    var chartDos = new CanvasJS.Chart("MarcacionContactacion",
    {
      title:{
      text: "Coal Reserves of Countries"   
      },
      axisY:{
        title:"Coal (mn tonnes)"   
      },
      animationEnabled: true,
      data: [
      {        
        type: "stackedColumn",
        toolTipContent: "{label}<br/><span style='\"'color: {color};'\"'><strong>{name}</strong></span>: {y}mn tonnes",
        name: "Anthracite and Bituminous",
        showInLegend: "true",
        dataPoints: [
        {  y: 111338 , label: "USA"},
        {  y: 49088, label: "Russia" },
        {  y: 62200, label: "China" },
        {  y: 90085, label: "India" },
        {  y: 38600, label: "Australia"},
        {  y: 48750, label: "SA"}
        
        ]
      },  {        
        type: "stackedColumn",
        toolTipContent: "{label}<br/><span style='\"'color: {color};'\"'><strong>{name}</strong></span>: {y}mn tonnes",
        name: "SubBituminous and Lignite",
        showInLegend: "true",
        dataPoints: [
        {  y: 135305 , label: "USA"},
        {  y: 107922, label: "Russia" },
        {  y: 52300, label: "China" },
        {  y: 3360, label: "India" },
        {  y: 39900, label: "Australia"},
        {  y: 0, label: "SA"}
        
        ]
      }            
      ]
      ,
      legend:{
        cursor:"pointer",
        itemclick: function(e) {
          if (typeof (e.dataSeries.visible) ===  "undefined" || e.dataSeries.visible) {
	          e.dataSeries.visible = false;
          }
          else
          {
            e.dataSeries.visible = true;
          }
          chartDos.render();
        }
      }
    });

    chartDos.render();
 
    var chartTres = new CanvasJS.Chart("Conversion",
    {
      title:{
        text: "Top Oil Reserves"    
      },
      animationEnabled: true,
      axisY: {
        title: "Reserves(MMbbl)"
      },
      legend: {
        verticalAlign: "bottom",
        horizontalAlign: "center"
      },
      theme: "theme2",
      data: [

      {        
        type: "column",  
        showInLegend: true, 
        legendMarkerColor: "grey",
        legendText: "MMbbl = one million barrels",
        dataPoints: [      
        {y: 297571, label: "Venezuela"},
        {y: 267017,  label: "Saudi" },
        {y: 175200,  label: "Canada"},
        {y: 154580,  label: "Iran"},
        {y: 116000,  label: "Russia"},
        {y: 97800, label: "UAE"},
        {y: 20682,  label: "US"},        
        {y: 20350,  label: "China"}        
        ]
      }   
      ]
    });

    chartTres.render();
  }    
    

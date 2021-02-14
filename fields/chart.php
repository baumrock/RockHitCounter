<div id="rockchart"></div>
<script>
var chart = 'rockchart';
let line = {x:[],y:[],type:'scatter'};
let data = [line];
let layout = {
  yaxis: {
    rangemode: 'tozero',
    autorange: true
  },
};
var config = {responsive: true};
Plotly.newPlot(chart, data, layout, config);
</script>
<div id="rockhits"></div>
<script>
var table = new Tabulator("#rockhits", {
  data:ProcessWire.config.RockHits,
  layout:"fitColumns",
  autoColumns:true,
  autoColumnsDefinitions:function(definitions) {
    definitions.forEach((column) => {
      if(column.field == 'date') {
        column.width = 100;
      }
      else if(column.field == 'count') {
        column.width = 90;
        column.hozAlign = 'right';
      }
      else if(column.field == 'id') {
        column.visible = false;
      }
      column.headerFilter = true; // add heQader filter to every column
    });
    return definitions;
  },
  pagination:"local",
  paginationSize:10,
  dataFiltered:function(filters, rows){
    //filters - array of filters currently applied
    //rows - array of row components that pass the filters
    let hits = {};
    rows.forEach(row => {
      let data = row.getData();
      if(typeof hits[data.date] == 'undefined') hits[data.date] = data.count*1;
      else hits[data.date] = 1*hits[data.date]+1*data.count;
    });
    let x = [], y = [];
    let keys = Object.keys(hits);
    let day = new Date(keys[0]);
    let last = new Date(keys[keys.length-1]);
    for (day; day <= last; day.setDate(day.getDate() + 1)) {
      var datestring = day.getFullYear()
        +"-"+("0"+(day.getMonth()+1)).slice(-2)
        +"-"+("0" + day.getDate()).slice(-2);
      x.push(datestring);
      y.push(hits[datestring] || 0);
    }
    Plotly.restyle(chart, 'x', [x]);
    Plotly.restyle(chart, 'y', [y]);
  },
});
$(document).on('opened', '#rockhitcounter_details', function(e) {
  console.log('fired');
  table.redraw(true);
});
</script>

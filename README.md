# RockHitCounter

RockHitcounter extends PageHitCounter to show historical page hit statistics.

## Configuration (not yet)

At the moment there are no options for limiting the size of the DB table or for loading only portions of the data into the presentation view.

### Known issues / possible issues

* The module might not work on multilang setups at the moment because it relies on the core pagePaths module! See https://github.com/baumrock/RockHitCounter/issues/1

## Important notes

### External CDN

**Note that the external resources (tabulator and plotly) are at the moment simply loaded from CDN. Feel free to improve that. But the important think is to STORE data in the custom table. The presentation layer of this module will evolve after time.**

### Statistic

**Also note that this module can only show statistics from the time of installation of RockHitCounter forward, because PageHitCounter only saves total counts and RockHitCounter creates a new table in the DB that stores the page id and a timestamp of the visit. Even though there is no configuration yet you might want to install the module already in order to use the full functionality with historical data.**

## Screenshot

![image](https://user-images.githubusercontent.com/8488586/116569790-00049700-a90a-11eb-8d19-dbfd4efd1fd5.png)

<?php namespace ProcessWire;
/**
 * Statistics for RockHitCounter
 *
 * @author Bernhard Baumrock, 10.12.2020
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class ProcessRockHitCounter extends Process {
  public static function getModuleInfo() {
    return [
      'title' => 'Statistics for RockHitCounter',
      'version' => '0.0.1',
      'summary' => '',
      'icon' => 'line-chart',
      'requires' => ['RockHitCounter'],
      'installs' => [],

      'permission' => 'rockhitcounter',
      'permissions' => ['rockhitcounter' => 'May see page hit statistics'],

      // page that you want created to execute this module
      'page' => [
        'name' => 'rockhitcounter',
        'parent' => 'setup',
        'title' => 'Page Hit Statistics'
      ],
    ];
  }

  public function init() {
    parent::init(); // always remember to call the parent init
  }

  /**
   *
   */
  public function execute() {
    $this->headline($this->_('Page Hit Statistics'));
    $this->browserTitle($this->_('Page Hit Statistics'));
    /** @var InputfieldForm $form */
    $form = $this->modules->get('InputfieldForm');

    $query = $this->wire->database->prepare("SELECT
        DATE_FORMAT(ts, '%Y-%m-%d') AS 'date'
        ,count(page_id) AS 'count'
        ,CONCAT('/', `pages_paths`.`path`) AS `path`
        ,pages_id AS id
      FROM `rockhitcounter`
      LEFT JOIN `pages_paths` ON `pages_paths`.`pages_id` = page_id
      group by
        DATE_FORMAT(ts, '%Y-%m-%d')
        ,page_id
      ");
    $query->execute();
    $hits = $query->fetchAll(\PDO::FETCH_OBJ);
    $this->wire->config->js('RockHits', $hits);
    $this->wire->config->styles->add('https://unpkg.com/tabulator-tables@4.9.3/dist/css/tabulator.min.css');
    $this->wire->config->scripts->add('https://unpkg.com/tabulator-tables@4.9.3/dist/js/tabulator.min.js');
    $this->wire->config->scripts->add('https://cdn.plot.ly/plotly-latest.min.js');

    $form->add([
      'type' => 'markup',
      'label' => 'Chart',
      'value' => $this->wire->files->render(__DIR__."/fields/chart.php"),
    ]);
    $form->add([
      'type' => 'markup',
      'id' => 'rockhitcounter_details',
      'label' => 'Details',
      'value' => $this->wire->files->render(__DIR__."/fields/table.php"),
      'collapsed' => Inputfield::collapsedNo,
    ]);

    return $form->render();
  }
}

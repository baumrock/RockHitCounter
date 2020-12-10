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

      // optional extra navigation that appears in admin
      // if you change this, you'll need to a Modules > Refresh to see changes
      // 'nav' => [
      //   [
      //     'url' => '',
      //     'label' => 'Hello',
      //     'icon' => 'smile-o',
      //   ],[
      //     'url' => 'something/',
      //     'label' => 'Something',
      //     'icon' => 'beer',
      //   ],
      // ]
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

    $form->add([
      'type' => 'markup',
      'label' => 'foo',
      'value' => 'bar',
    ]);

    return $form->render();
  }
}

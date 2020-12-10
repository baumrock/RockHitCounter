<?php namespace ProcessWire;
/**
 * ProcessWire module that extends PageHitCounter to show historical page hit
 * statistics.
 *
 * @author Bernhard Baumrock, 10.12.2020
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class RockHitCounter extends WireData implements Module, ConfigurableModule {

  const tableName = 'rockhitcounter';

  public static function getModuleInfo() {
    return [
      'title' => 'RockHitCounter',
      'version' => '0.0.1',
      'summary' => 'ProcessWire module that extends PageHitCounter to show
        historical page hit statistics.',
      'autoload' => true,
      'singular' => true,
      'icon' => 'line-chart',
      'requires' => [
        'PageHitCounter',
        'PagePaths',
      ],
      'installs' => [
        'ProcessRockHitCounter',
      ],
    ];
  }

  public function init() {
    $this->addHookAfter("PageHitCounter::pageViewTracked", $this, "trackPageView");
  }

  /**
   * Create database table
   */
  protected function createTable() {
    $sql = "CREATE TABLE IF NOT EXISTS " . self::tableName . " ( "
        ."page_id int unsigned NOT NULL"
        .",ts timestamp NULL DEFAULT CURRENT_TIMESTAMP"
      .")";
    $this->wire->database->exec($sql);
  }

  /**
   * Drop database table
   */
  protected function dropTable() {
    $this->wire->database->exec("DROP TABLE IF EXISTS ".self::tableName);
  }

  /**
   * Track a single pageview
   */
  public function trackPageView(HookEvent $event) {
    $id = $event->arguments(0);
    $table = self::tableName;
    $sql = "INSERT INTO $table(page_id) VALUES($id)";
    $this->wire->database->exec($sql);
  }

  /** ### module methods ### */

  /**
  * Config inputfields
  * @param InputfieldWrapper $inputfields
  */
  public function getModuleConfigInputfields($inputfields) {
    return $inputfields;
  }

  /**
   * Install this module
   */
  public function ___install() {
    $this->createTable();
  }

  /**
   * Uninstall this module
   */
  public function ___uninstall() {
    $this->dropTable();
  }
}

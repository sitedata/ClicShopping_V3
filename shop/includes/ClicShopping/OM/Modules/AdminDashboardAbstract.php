<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\OM\Modules;

  use ClicShopping\OM\Registry;

  abstract class AdminDashboardAbstract implements \ClicShopping\OM\Modules\AdminDashboardInterface
  {
    public $code;
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;

    protected $db;

    abstract protected function init();

    abstract public function getOutput();

    abstract public function install();

    abstract public function keys();

    final public function __construct()
    {
      $this->code = (new \ReflectionClass($this))->getShortName();

      $this->db = Registry::get('Db');

      $this->init();
    }

    public function isEnabled()
    {
      return $this->enabled;
    }

    public function check()
    {
      return isset($this->sort_order);
    }

    public function remove()
    {
      return $this->db->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }
  }

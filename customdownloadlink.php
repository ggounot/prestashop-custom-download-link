<?php   
if (!defined('_PS_VERSION_')) {
  exit;
}

define('VP_TPL_FILENAME', 'virtualproduct.tpl');
define('OVERRIDE_PRODUCTS_DIR', 'override/controllers/admin/templates/products/');

class CustomDownloadLink extends Module
{
  protected $module_vp_tpl_path;
  protected $ps_override_products_dir;
  protected $ps_override_vp_tpl_path;

  public function __construct()
  {
    $this->name = 'customdownloadlink';
    $this->tab = 'administration';
    $this->version = '1.0';
    $this->author = 'Gérald Gounot';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    $this->bootstrap = true;

    parent::__construct();

    $this->displayName = $this->l('Custom Download Link');
    $this->description = $this->l('Set a custom download link for virtual products.');
    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

    $this->module_vp_tpl_path = $this->getLocalPath().OVERRIDE_PRODUCTS_DIR.VP_TPL_FILENAME;
    $this->ps_override_products_dir = _PS_ROOT_DIR_.'/'.OVERRIDE_PRODUCTS_DIR;
    $this->ps_override_vp_tpl_path = $this->ps_override_products_dir.VP_TPL_FILENAME;
  }

  public function install()
  {
    if (!parent::install()) {
      return false;
    }

    // Copy override virtualproduct admin template
    if(!is_dir($this->ps_override_products_dir))
        mkdir($this->ps_override_products_dir, 0755, true);
    copy($this->module_vp_tpl_path, $this->ps_override_vp_tpl_path);

    // Add column for custom link
    Db::getInstance()->execute('ALTER TABLE '._DB_PREFIX_.'product_download ADD custom_link VARCHAR(2048) DEFAULT NULL');

    return true;
  }

  public function uninstall()
  {
    if (!parent::uninstall()) {
      return false;
    }

    // Remove override virtualproduct admin template
    unlink($this->ps_override_vp_tpl_path);

    return true;
  }
}

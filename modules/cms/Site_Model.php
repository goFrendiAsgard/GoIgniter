<?php
namespace Modules\Cms;
use \Modules\Cms\CMS_Model;
use \Site;

class Site_Alias extends CMS_Model
{
    protected $_table = 'cms_site_alias';
    protected $_site_id = '';
    protected $_site_model = '';
    protected $_columns = ['alias', 'site_id'];
    protected $_unique_columns = ['alias']

    protected $_parents = array(
        'site' => array(
            'model' => '\Modules\Cms\Site_Model',
            'foreign_key' => 'site_id',
        ),
    );
}

class Site_Model extends CMS_Model
{
    protected $_table = 'cms_site';
    protected $_site_id    = '';
    protected $_site_model = '';
    protected $_columns = ['code'];
    protected $_unique_columns = ['code'];

    protected $real_old_site_code = NULL;

    protected $_children = array(
        'aliases' => array(
            'model' => '\Modules\Cms\Site_Alias',
            'foreign_key', => 'site_id',
        )
    );

    public static function get_current_site()
    {
        $site = new Site();
        $site_code = $site->get_current_code();
        if($site_code != NULL)
        {
            return static::find_where('code', $site_code);
        }
        return NULL;
    }

    protected function get_real_old_site_code()
    {
        $this->real_old_site_code = NULL;
        if($this->id != NULL)
        {
            $old_site = Site_Model::find_by_id($this->id);
            $this->real_old_site_code = $old_site->code;
        }
    }

    protected function delete_old_site()
    {
        if($this->real_old_site_code != NULL)
        {
            $site = new Site();
            $site->delete_site($this->real_old_site_code);
        }
    }

    public function before_save(&$success, &$error_message)
    {
        parent::before_save(&$success, &$error_message);
        $this->get_real_old_site_code();
    }

    public function before_delete(&$success, &$error_message)
    {
        parent::before_delete(&$success, &$error_message);
        $this->get_real_old_site_code();
    }

    public function before_purge(&$success, &$error_message)
    {
        parent::before_purge(&$success, &$error_message);
        $this->get_real_old_site_code();
    }

    public function after_save(&$success, &$error_message)
    {
        parent::after_save(&$success, &$error_message);
        $this->delete_old_site();

        $alises = array();
        foreach($this->aliases as $alias)
        {
            $aliases[] = $alias->alias;
        }

        $site = new Site();
        $site->add_site($this->code, $aliases);
    }

    public function after_delete(&$success, &$error_message)
    {
        parent::after_delete(&$success, &$error_message);
        $this->delete_old_site();
    }

    public function after_purge(&$success, &$error_message)
    {
        parent::after_purge(&$success, &$error_message);
        $this->delete_old_site();
    }

}

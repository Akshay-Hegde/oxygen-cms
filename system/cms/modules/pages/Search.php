<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search_Pages
{
    protected $ci;

    protected static $results;
    protected static $added;

    public function __construct()
    {
        $this->ci =& get_instance();
        Search::register('admin_search', array($this, 'admin_search'));
    }

    public function admin_search($query_string='')
    {

        self::$added    = [];       
        self::$results  =
        [
            'total-results'=>0,
            'results'=> []
        ];   

        $terms = explode ( ' ', $query_string );

        foreach($terms as $term) {
            $this->list_all_pages($term);
        }

        return self::$results;
    }


    private function list_all_pages($term) {

        $this->search_pages_table($term);
    }

    private function search_pages_table($term) {

        $pages = get_instance()->db->like('title',''.$term.'')->or_like('meta_description',$term)->get('pages')->result();

        foreach($pages as $page) 
        {

            if(isset(self::$added[$page->id])) {
                //pass this page is already added
                continue; 
            }

            //add the index
            self::$added[$page->id]= $page->id;

            $this->_add_result($page);
        }   
    }

    private function _add_result($page)
    {
        self::$results['total-results'] = self::$results['total-results'] + 1;
        self::$results['results'][] = 
        [
            'title'=>$page->title,
            'module'  => 'Page',
            'icon'=> 'fa fa-book',
            'description'=>$page->title,
            'url'=>$page->uri,
            'admin_url'=>site_url('admin/pages/edit/'.$page->id),
        ];
    }


}
/* End of file Search.php */
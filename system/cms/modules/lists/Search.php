<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search_Lists
{
    protected $ci;

    protected $results;
    protected $added;

    
    public function __construct()
    {
        $this->ci =& get_instance();
        Search::register('admin_search', array($this, 'admin_search'));
    }

    public function admin_search($query_string='')
    {

        $this->added    = [];       
        $this->results  =
        [
            'total-results'=> 0,
            'results'=> []
        ];  

        $this->ci->load->helper('array');

        $terms = xplode( [' ',',','|',';'], $query_string );

        foreach($terms as $term) {
            $term = ''.$term.'';
            if($term==='') {
                continue;
            }
            $this->search_lists_table(trim($term));
        }

        return $this->results;
    }


    private function search_lists_table($term) 
    {
        /**
         * only get the lists namespace
         */
        $lists = get_instance()->db
                ->where('stream_namespace','lists') 
                ->like('stream_name',$term)
                ->or_like('stream_slug',$term)        
                ->or_like('about',$term)   

                ->get('data_streams')->result();
    
        foreach($lists as $list) 
        {

            if(isset($this->added[$list->id])) {
                //pass this page is already added
                continue; 
            }

            //add the index
            $this->added[$list->id]= $list->id;

            $this->results['total-results'] = $this->results['total-results'] + 1;
            $this->results['results'][] = 
            [
                'title' => $list->stream_name,
                'module'  => 'List',
                'icon'  => 'fa fa-list',
                'description'=>'List',
                'url'   => '',
                'admin_url'=>site_url('admin/lists/entries/view/'.$list->stream_slug),
            ];
        }   
    }

}
/* End of file Search.php */
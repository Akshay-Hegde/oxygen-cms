<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search_Users
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
            $this->search_users_table(trim($term));
        }

        return $this->results;
    }

    private function search_users_table($term) 
    {

        $users = get_instance()->db
                ->like('username',$term)
                ->or_like('email',$term)        
                ->get('users')->result();
    
        foreach($users as $user) 
        {
            if(isset($this->added[$user->id])) {
                //pass this page is already added
                continue; 
            }

            //add the index
            $this->added[$user->id]= $user->id;

            $this->results['total-results'] = $this->results['total-results'] + 1;
            $this->results['results'][] = 
            [
                'title'=>$user->username,
                'module'  => 'User',
                'icon'=> 'fa fa-user',
                'description'=>'User of site',
                'url'=>site_url('user/'.$user->id),
                'admin_url'=>site_url('admin/users/edit/'.$user->id),
            ];
        }   
    }

}
/* End of file Search.php */
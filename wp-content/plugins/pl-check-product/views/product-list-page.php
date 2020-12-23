<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class TableCodeProduct extends WP_List_Table {
	public function __construct()
    {
        parent::__construct(array(
            'singular' => 'singular_form',
            'plural' => 'plural_form',
            'ajax' => true
        ));
        // $this->set_order();
        // $this->set_orderby();
        $this->prepare_items();
        $this->display();
    }

    function column_default( $item, $column_name ) {
	  // switch( $column_name ) { 
	  //   case 'id':
	  //   case 'id_product':
	  //   case 'code':
	  //   case 'create_date':
	  //     return $item[ $column_name ];
	  //   default:
	  //     return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
	  // }
    	return $item[ $column_name ];
	}

	public function get_columns(){
	  $columns = array(
	  	'cb' => '<input type="checkbox" />', 
	    'id' => __('ID', 'ux') ,
	    'code'      => __('Product Code', 'ux'),
	    'create_date' => __('Created Date', 'ux')
	  );
	  return $columns;
	}

	public function prepare_items() {
	  	$columns =  $this->get_columns();
	  	$hidden = array();
	  	$sortable =  $this->get_sortable_columns();

	  	$this->process_bulk_action();
	    $per_page = $this->get_items_per_page('records_per_page', 10);
	    $current_page = $this->get_pagenum();
	    $total_items = self::record_count();
	    $data = $this->get_records($per_page, $current_page);
	    usort( $data, array( &$this, 'sort_data' ) );
	    $this->set_pagination_args(
	                      ['total_items' => $total_items, 
	                   'per_page' => $per_page 
	                  ]);
	    $this->_column_headers = array( $columns, $hidden, $sortable );
	    $this->items =  $data;
	}

	public function get_records($per_page = 10, $page_number = 1)
	{
	    global $wpdb;
	    $sql = "SELECT id, code, create_date FROM pl_code_product ";

	    $sql.= " LIMIT $per_page";
	    $sql.= ' OFFSET ' . ($page_number - 1) * $per_page;
	    $result = $wpdb->get_results($sql, 'ARRAY_A');

	    return $result;
	}

 	private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'title';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }


        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc')
        {
            return $result;
        }

        return -$result;
    }

	public function get_sortable_columns()
	{
	    $sortable_columns = array(
	        'id' => array('id',false ) ,
	        'code' => array('code',false ) ,
	        'create_date' => array('create_date',false ) 
	    );
	    return $sortable_columns;
	}

	public function record_count()
	{
	    global $wpdb;
	    $sql = "SELECT COUNT(*) FROM pl_code_product";
	    return $wpdb->get_var($sql);
	}
//
	public function column_cb($item)
	{
	    return sprintf('<input type="checkbox" name="id[]" value="%s" />', $item['id']);
	}
	 
	/** 
	* Returns an associative array containing the bulk action 
	* * @return array */
	public function get_bulk_actions()
	{
	    $actions = ['delete' => 'Delete'];
	    return $actions;
	}
	public function process_bulk_action()
	{
	    global $wpdb;
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);
            if (!empty($ids)) {
                $wpdb->query("DELETE FROM pl_code_product WHERE id IN($ids)");
            }
        }
	}

	public function no_items()
	{
	    _e('No record found in the database.', 'bx');
	}
}
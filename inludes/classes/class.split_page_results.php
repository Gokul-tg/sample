<?php
  class MsplitPageResults {
    var $sql_query, $number_of_rows, $current_page_number, $number_of_pages, $number_of_rows_per_page, $page_name;

/* class constructor */

    function MsplitPageResults($query, $max_rows, $count_key = '*', $page_holder = 'page') {
	
      global $_GET, $_POST;
	
      $this->sql_query = $query;
      $this->page_name = $page_holder;

      if (isset($_REQUEST[$page_holder])) {
        $page = $_REQUEST[$page_holder];
      } elseif (isset($_REQUEST[$page_holder])) {
        $page = $_REQUEST[$page_holder];
      } else {
        $page = '';
      }
	//echo 'sffsf';
	
      if (empty($page) || !is_numeric($page)) $page = 1;
      $this->current_page_number = $page;

     $this->number_of_rows_per_page = $max_rows;

      $pos_to = strlen($this->sql_query);
      $pos_from = strpos($this->sql_query, ' from', 0);

      $pos_group_by = strpos($this->sql_query, ' group by', $pos_from);
      if (($pos_group_by < $pos_to) && ($pos_group_by != false)) $pos_to = $pos_group_by;

      $pos_having = strpos($this->sql_query, ' having', $pos_from);
      if (($pos_having < $pos_to) && ($pos_having != false)) $pos_to = $pos_having;

      $pos_order_by = strpos($this->sql_query, ' order by', $pos_from);
      if (($pos_order_by < $pos_to) && ($pos_order_by != false)) $pos_to = $pos_order_by;

      if (strpos($this->sql_query, 'distinct') || strpos($this->sql_query, 'group by')) {
       // $count_string = 'distinct ' . db_input($count_key);
     		$count_query = mysql_query($this->sql_query);
			$count = mysql_num_rows($count_query);
			 $this->number_of_rows = $count;
      } else {
        //$count_string = db_input($count_key);
        	$count_string = db_input($count_key);
        //	echo substr($this->sql_query, $pos_from, ($pos_to - $pos_from));
			$count_query = mysql_query("select count(" . $count_string . ") as total " . substr($this->sql_query, $pos_from, ($pos_to - $pos_from))) or db_error($query, mysql_errno(), mysql_error());
			$count = mysql_fetch_array($count_query);
		$this->number_of_rows = $count['total'];
      }
	//echo "select count(" . $count_string . ") as total " . substr($this->sql_query, $pos_from, ($pos_to - $pos_from));
     // $count_query = mysql_query("select count(" . $count_string . ") as total " . substr($this->sql_query, $pos_from, ($pos_to - $pos_from))) or db_error($query, mysql_errno(), mysql_error());
      //$count = mysql_fetch_array($count_query);
    
     //$this->number_of_rows = $count['total'];

      $this->number_of_pages = ceil($this->number_of_rows / $this->number_of_rows_per_page);

      if ($this->current_page_number > $this->number_of_pages) {
        $this->current_page_number = $this->number_of_pages;
      }

      $offset = ($this->number_of_rows_per_page * ($this->current_page_number - 1));
	
     $this->sql_query .= " limit " . max($offset, 0) . ", " . $this->number_of_rows_per_page;

    }

/* class functions */

// display split-page-number-links
    function display_links($max_page_links, $parameters = '') {
      global $PHP_SELF, $request_type;

      $display_links_string = '';

      $class = 'class="title"';

      if (not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';
		//echo $parameters;
// previous button - not displayed on first page
      if ($this->current_page_number > 1) $display_links_string .= '<a href="' . href_link(basename($PHP_SELF), $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) .'&cat_id='.$_REQUEST['cat_id'].'&subcat_id='.$_REQUEST['subcat_id'].'&color='.$_REQUEST['color'].'&size='.$_REQUEST['size'].'&Ident='.$_REQUEST['Ident'].'&pLimit='.$_REQUEST['pLimit'].'&flag='.$_REQUEST['flag'].'' . '" class="title" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' " style= "color: #3C3C3C;"><u  class=blog_title >' . 'Prev' . '</u></a>&nbsp;&nbsp;';

// check if number_of_pages > $max_page_links
      $cur_window_num = intval($this->current_page_number / $max_page_links);
      if ($this->current_page_number % $max_page_links) $cur_window_num++;

      $max_window_num = intval($this->number_of_pages / $max_page_links);
      if ($this->number_of_pages % $max_page_links) $max_window_num++;

// previous window of pages
      if ($cur_window_num > 1) $display_links_string .= '<a href="' . href_link(basename($PHP_SELF), $parameters . $this->page_name . '=' . (($cur_window_num - 1) * $max_page_links), $request_type) .'&cat_id='.$_REQUEST['cat_id'].'&subcat_id='.$_REQUEST['subcat_id'].'&color='.$_REQUEST['color'].'&size='.$_REQUEST['size'].'&Ident='.$_REQUEST['Ident'].'&pLimit='.$_REQUEST['pLimit'].'&flag='.$_REQUEST['flag'].'' . '" class="title" title=" ' . sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, $max_page_links) . ' " style= "color: #3C3C3C;"></a>';

// page nn button
      for ($jump_to_page = 1 + (($cur_window_num - 1) * $max_page_links); ($jump_to_page <= ($cur_window_num * $max_page_links)) && ($jump_to_page <= $this->number_of_pages); $jump_to_page++) {
        if ($jump_to_page == $this->current_page_number) {
          //$display_links_string .= '&nbsp;<b>' . $jump_to_page . ' of '. $max_window_num.'</b>&nbsp;';
          $display_links_string .= '&nbsp;<b>' . $jump_to_page . '</b>&nbsp;';
        } else {
          $display_links_string .= '&nbsp;<a href="' . href_link(basename($PHP_SELF), $parameters . $this->page_name . '=' . $jump_to_page, $request_type) .'&cat_id='.$_REQUEST['cat_id'].'&subcat_id='.$_REQUEST['subcat_id'].'&color='.$_REQUEST['color'].'&size='.$_REQUEST['size'].'&Ident='.$_REQUEST['Ident'].'&pLimit='.$_REQUEST['pLimit'].'&flag='.$_REQUEST['flag'].'' . '" class="title" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' " style= "color: #3C3C3C;"><u  class=blog_title>' . $jump_to_page . '</u></a>&nbsp;';
        }
      }

// next window of pages
      if ($cur_window_num < $max_window_num) $display_links_string .= '<a href="' . href_link(basename($PHP_SELF), $parameters . $this->page_name . '=' . (($cur_window_num) * $max_page_links + 1), $request_type) .'&cat_id='.$_REQUEST['cat_id'].'&subcat_id='.$_REQUEST['subcat_id'].'&size='.$_REQUEST['size'].'&color='.$_REQUEST['color'].'&Ident='.$_REQUEST['Ident'].'&pLimit='.$_REQUEST['pLimit'].'&flag='.$_REQUEST['flag'].'' . '" class="title" title=" ' . sprintf(PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE, $max_page_links) . ' " style= "color: #3C3C3C;"></a>&nbsp;';

// next button

      if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1))
	   $display_links_string .= '&nbsp;<a href="' . href_link(basename($PHP_SELF), $parameters . 'page=' . ($this->current_page_number + 1), $request_type) .'&cat_id='.$_REQUEST['cat_id'].'&subcat_id='.$_REQUEST['subcat_id'].'&color='.$_REQUEST['color'].'&size='.$_REQUEST['size'].'&Ident='.$_REQUEST['Ident'].'&pLimit='.$_REQUEST['pLimit'].'&flag='.$_REQUEST['flag'].'' . '" class="title" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' " style= "color: #3C3C3C;"><u class=blog_title >' . 'Next'  . '</u></a>&nbsp;';
      
	  $display_links_string;
	  $request_type;
      return $display_links_string;
    }

// display number of total products found
    function display_count($text_output) {

      $to_num = ($this->number_of_rows_per_page * $this->current_page_number);
      if ($to_num > $this->number_of_rows) $to_num = $this->number_of_rows;

      $from_num = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

      if ($to_num == 0) {
        $from_num = 0;
      } else {
        $from_num++;
      }
    $this->number_of_rows;
	
      return sprintf($text_output, $from_num, $to_num, $this->number_of_rows);
    }
  }
?>

<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Calendar Class
 *
 * This class enables the creation of calendars
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Rick Ellis
 * @link		http://www.codeigniter.com/user_guide/libraries/calendar.html
 */
class CI_Calendar_Persian {

	var $CI;
	var $lang;
	var $local_time;
	var $template		= '';
	var $start_day		= 'saturday';
	var $month_type 	= 'long';
	var $day_type		= 'abr';
	var $show_next_prev	= FALSE;
	var $next_prev_url	= '';
	var $jd;

	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 *
	 * @access	public
	 */
	function CI_Calendar_Persian($config = array())
	{		
		$this->CI =& get_instance();
		
		if ( ! in_array('calendar_lang'.EXT, $this->CI->lang->is_loaded, TRUE))
		{
			$this->CI->lang->load('calendar');
		}
		$this->CI->load->library('multi_calendar');

		$this->local_time = time();
		$date=getdate($this->local_time);
		$this->jd=$this->CI->multi_calendar->gregorian_to_jd($date['year'], $date['mon'], $date['mday']);
		
		if (count($config) > 0)
		{
			$this->initialize($config);
		}
		
		log_message('debug', "Calendar Class Initialized");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Initialize the user preferences
	 *
	 * Accepts an associative array as input, containing display preferences
	 *
	 * @access	public
	 * @param	array	config preferences
	 * @return	void
	 */	
	function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Generate the calendar
	 *
	 * @access	public
	 * @param	integer	the year
	 * @param	integer	the month
	 * @param	array	the data to be shown in the calendar cells
	 * @return	string
	 */
	function generate($year = '', $month = '', $data = array())
	{
    $today=$this->CI->multi_calendar->jd_to_persian($this->jd);
    
    // Set and validate the supplied month/year
		if ($year == '')
			$year  = $today[0];
			
		if ($month == '')
			$month  = $today[1];
			
 		if (strlen($year) == 1)
			$year = '138'.$year;
		
 		if (strlen($year) == 2)
			$year = '13'.$year;

 		if (strlen($month) == 1)
			$month = '0'.$month;
		
		$adjusted_date = $this->adjust_date($month, $year);

		$month	= $adjusted_date['month'];
		$year	= $adjusted_date['year'];
		
		// Determine the total days in the month
		$total_days = $this->get_total_days($month, $year);
						
		// Set the starting day of the week
		$start_days	= array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
		$start_day = ( ! isset($start_days[$this->start_day])) ? 6 : $start_days[$this->start_day];
		
		// Set the starting day number
		$day1jd = $this->CI->multi_calendar->persian_to_jd($year, $month, 1);
		$day  = $start_day + 1 - $this->CI->multi_calendar->jwday($day1jd);

		while ($day > 1)
		{
			$day -= 7;
		}
		
		// Set the current month/year/day
		// We use this to determine the "today" date
		$cur_year	= $today[0];
		$cur_month	= $today[1];
		$cur_day	= $today[2];
		
		$is_current_month = ($cur_year == $year AND $cur_month == $month) ? TRUE : FALSE;
	
		// Generate the template data array
		$this->parse_template();
	
		// Begin building the calendar output						
		$out = $this->temp['table_open'];
		$out .= "\n";	

		$out .= "\n";		
		$out .= $this->temp['heading_row_start'];
		$out .= "\n";
		
		// "previous" month link
		if ($this->show_next_prev == TRUE)
		{ 
			// Add a trailing slash to the  URL if needed
			$this->next_prev_url = preg_replace("/(.+?)\/*$/", "\\1/",  $this->next_prev_url);
		
			$adjusted_date = $this->adjust_date($month - 1, $year);
			$out .= str_replace('{previous_url}', $this->next_prev_url.$adjusted_date['year'].'/'.$adjusted_date['month'], $this->temp['heading_previous_cell']);
			$out .= "\n";
		}

		// Heading containing the month/year
		$colspan = ($this->show_next_prev == TRUE) ? 5 : 7;
		
		$this->temp['heading_title_cell'] = str_replace('{colspan}', $colspan, $this->temp['heading_title_cell']);
		$this->temp['heading_title_cell'] = str_replace('{heading}', $this->get_month_name($month)."&nbsp;".$year, $this->temp['heading_title_cell']);
		
		$out .= $this->temp['heading_title_cell'];
		$out .= "\n";

		// "next" month link
		if ($this->show_next_prev == TRUE)
		{		
			$adjusted_date = $this->adjust_date($month + 1, $year);
			$out .= str_replace('{next_url}', $this->next_prev_url.$adjusted_date['year'].'/'.$adjusted_date['month'], $this->temp['heading_next_cell']);
		}

		$out .= "\n";		
		$out .= $this->temp['heading_row_end'];
		$out .= "\n";

		// Write the cells containing the days of the week
		$out .= "\n";	
		$out .= $this->temp['week_row_start'];
		$out .= "\n";

		$day_names = $this->get_day_names();

		for ($i = 0; $i < 7; $i ++)
		{
			$out .= str_replace('{week_day}', $day_names[($start_day + $i) %7], $this->temp['week_day_cell']);
		}

		$out .= "\n";
		$out .= $this->temp['week_row_end'];
		$out .= "\n";

		// Build the main body of the calendar
		while ($day <= $total_days)
		{
			$out .= "\n";
			$out .= $this->temp['cal_row_start'];
			$out .= "\n";

			for ($i = 0; $i < 7; $i++)
			{
				$out .= ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_start_today'] : $this->temp['cal_cell_start'];
			
				if ($day > 0 AND $day <= $total_days)
				{ 					
					if (isset($data[$day]))
					{	
						// Cells with content
						$temp = ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_content_today'] : $this->temp['cal_cell_content'];
						$out .= str_replace('{day}', $day, str_replace('{content}', $data[$day], $temp));
					}
					else
					{
						// Cells with no content
						$temp = ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_no_content_today'] : $this->temp['cal_cell_no_content'];
						$out .= str_replace('{day}', $day, $temp);
					}
				}
				else
				{
					// Blank cells
					$out .= $this->temp['cal_cell_blank'];
				}
				
				$out .= ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_end_today'] : $this->temp['cal_cell_end'];					  	
				$day++;
			}
			
			$out .= "\n";		
			$out .= $this->temp['cal_row_end'];
			$out .= "\n";		
		}

		$out .= "\n";		
		$out .= $this->temp['table_close'];

		return $out;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get Month Name
	 *
	 * Generates a textual month name based on the numeric
	 * month provided.
	 *
	 * @access	public
	 * @param	integer	the month
	 * @return	string
	 */
	function get_month_name($month)
	{
		if ($this->month_type == 'short')
		{
			$month_names = array('01'=>'فروردین' , '02'=>'اردیبهشت' , '03'=>'خرداد' , '04'=>'تیر' , '05'=>'مرداد' , '06'=>'شهریور' , '07'=>'مهر' , '08'=>'آبان' , '09'=>'آذر' , '10'=>'دی' , '11'=>'بهمن' , '12'=>'اسفند' );
		}
		else
		{
			$month_names = array('01'=>'فروردین' , '02'=>'اردیبهشت' , '03'=>'خرداد' , '04'=>'تیر' , '05'=>'مرداد' , '06'=>'شهریور' , '07'=>'مهر' , '08'=>'آبان' , '09'=>'آذر' , '10'=>'دی' , '11'=>'بهمن' , '12'=>'اسفند' );
		}
		
		$month = $month_names[$month];
		
		if ($this->CI->lang->line($month) === FALSE)
		{
			return ucfirst(str_replace('cal_', '', $month));
		}

		return $this->CI->lang->line($month);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get Day Names
	 *
	 * Returns an array of day names (Sunday, Monday, etc.) based
	 * on the type.  Options: long, short, abrev
	 *
	 * @access	public
	 * @param	string
	 * @return	array
	 */
	function get_day_names($day_type = '')
	{
		if ($day_type != '')
			$this->day_type = $day_type;
	
		if ($this->day_type == 'long')
		{
			$day_names = array('یکشنبه' , 'دوشنبه' , 'سه شنبه' , 'چهار شنبه' , 'پنج شنبه' , 'جمعه' , 'شنبه' );
		}
		elseif ($this->day_type == 'short')
		{
			$day_names = array('یک' , 'دو' , 'سه' , 'چهار' , 'پنج' , 'جمعه' , 'شنبه' );
		}
		else
		{
			$day_names = array('ی' , 'د' , 'س' , 'چ' , 'پ' , 'ج' , 'ش' );
		}
	
		$days = array();
		foreach ($day_names as $val)
		{			
			$days[] = ($this->CI->lang->line('cal_'.$val) === FALSE) ? ucfirst($val) : $this->CI->lang->line('cal_'.$val);
		}
	
		return $days;
	}
 	
	// --------------------------------------------------------------------

	/**
	 * Adjust Date
	 *
	 * This function makes sure that we have a valid month/year.
	 * For example, if you submit 13 as the month, the year will
	 * increment and the month will become January.
	 *
	 * @access	public
	 * @param	integer	the month
	 * @param	integer	the year
	 * @return	array
	 */
	function adjust_date($month, $year)
	{
		$date = array();

		$date['month']	= $month;
		$date['year']	= $year;

		while ($date['month'] > 12)
		{
			$date['month'] -= 12;
			$date['year']++;
		}

		while ($date['month'] <= 0)
		{
			$date['month'] += 12;
			$date['year']--;
		}

		if (strlen($date['month']) == 1)
		{
			$date['month'] = '0'.$date['month'];
		}

		return $date;
	}
 	
	// --------------------------------------------------------------------

	/**
	 * Total days in a given month
	 *
	 * @access	public
	 * @param	integer	the month
	 * @param	integer	the year
	 * @return	integer
	 */
	function get_total_days($month, $year)
	{
		$days_in_month	= array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

		if ($month < 1 OR $month > 12)
		{
			return 0;
		}

		// Is the year a leap year?
		if ($month == 12)
		{
			if ($this->CI->multi_calendar->leap_persian($year))
			{
				return 30;
			}
		}

		return $days_in_month[$month - 1];
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set Default Template Data
	 *
	 * This is used in the event that the user has not created their own template
	 *
	 * @access	public
	 * @return array
	 */
	function default_template()
	{
		return  array (
						'table_open' 				=> '<table border="0" cellpadding="4" cellspacing="0">',
						'heading_row_start' 		=> '<tr>',
						'heading_previous_cell'		=> '<th><a href="{previous_url}">&lt;&lt;</a></th>',
						'heading_title_cell' 		=> '<th colspan="{colspan}">{heading}</th>',
						'heading_next_cell' 		=> '<th><a href="{next_url}">&gt;&gt;</a></th>',
						'heading_row_end' 			=> '</tr>',
						'week_row_start' 			=> '<tr>',
						'week_day_cell' 			=> '<td>{week_day}</td>',
						'week_row_end' 				=> '</tr>',
						'cal_row_start' 			=> '<tr>',
						'cal_cell_start' 			=> '<td>',
						'cal_cell_start_today'		=> '<td>',
						'cal_cell_content'			=> '<a href="{content}">{day}</a>',
						'cal_cell_content_today'	=> '<a href="{content}"><strong>{day}</strong></a>',
						'cal_cell_no_content'		=> '{day}',
						'cal_cell_no_content_today'	=> '<strong>{day}</strong>',
						'cal_cell_blank'			=> '&nbsp;',
						'cal_cell_end'				=> '</td>',
						'cal_cell_end_today'		=> '</td>',
						'cal_row_end'				=> '</tr>',
						'table_close'				=> '</table>'
					);	
	}
	
	// --------------------------------------------------------------------

	/**
	 * Parse Template
	 *
	 * Harvests the data within the template {pseudo-variables}
	 * used to display the calendar
	 *
	 * @access	public
	 * @return	void
	 */
 	function parse_template()
 	{
		$this->temp = $this->default_template();
 	
 		if ($this->template == '')
 		{
 			return;
 		}
 		
		$today = array('cal_cell_start_today', 'cal_cell_content_today', 'cal_cell_no_content_today', 'cal_cell_end_today');
		
		foreach (array('table_open', 'table_close', 'heading_row_start', 'heading_previous_cell', 'heading_title_cell', 'heading_next_cell', 'heading_row_end', 'week_row_start', 'week_day_cell', 'week_row_end', 'cal_row_start', 'cal_cell_start', 'cal_cell_content', 'cal_cell_no_content',  'cal_cell_blank', 'cal_cell_end', 'cal_row_end', 'cal_cell_start_today', 'cal_cell_content_today', 'cal_cell_no_content_today', 'cal_cell_end_today') as $val)
		{
			if (preg_match("/\{".$val."\}(.*?)\{\/".$val."\}/si", $this->template, $match))
			{
				$this->temp[$val] = $match['1'];
			}
			else
			{
				if (in_array($val, $today, TRUE))
				{
					$this->temp[$val] = $this->temp[str_replace('_today', '', $val)];
				}
			}
		} 	
 	}
 	
 	

}

// END CI_Calendar class
?>
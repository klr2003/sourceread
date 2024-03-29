<?php /* CALENDAR $Id: calendar.class.php 5588 2007-12-20 11:06:21Z ajdonnison $ */
if (!defined('DP_BASE_DIR')) {
	die('You should not access this file directly.');
}

##
## Calendar classes
##

require_once ($AppUI->getLibraryClass('PEAR/Date'));
require_once ($AppUI->getSystemClass ('dp'));
require_once $AppUI->getSystemClass('libmail');
require_once $AppUI->getSystemClass('date');

/**
* Displays a configuration month calendar
*
* All Date objects are based on the PEAR Date package
*/
class CMonthCalendar {
/**#@+
* @var Date
*/
	var $this_month;
	var $prev_month;
	var $next_month;
	var $prev_year;
	var $next_year;
/**#@-*/

/** @var string The css style name of the Title */
	var $styleTitle;

/** @var string The css style name of the main calendar */
	var $styleMain;

/** @var string The name of the javascript function that a 'day' link should call when clicked */
	var $callback;

/** @var boolean Show the heading */
	var $showHeader;

/** @var boolean Show the previous/next month arrows */
	var $showArrows;

/** @var boolean Show the day name column headings */
	var $showDays;

/** @var boolean Show the week link (no pun intended) in the first column */
	var $showWeek;

/** @var boolean Show the month name as link */
	var $clickMonth;

/** @var boolean Show events in the calendar boxes */
	var $showEvents;

/** @var string */
	var $dayFunc;

/** @var string */
	var $weekFunc;

/** @var boolean Show highlighting in the calendar boxes */
	var $showHighlightedDays;

/**
* @param Date $date
*/
 function CMonthCalendar($date=null) {
		$this->setDate($date);

		$this->classes = array();
		$this->callback = '';
		$this->showTitle = true;
		$this->showArrows = true;
		$this->showDays = true;
		$this->showWeek = true;
		$this->showEvents = true;
		$this->showHighlightedDays = true;
		

		$this->styleTitle = '';
		$this->styleMain = '';

		$this->dayFunc = '';
		$this->weekFunc = '';

		$this->events = array();
		$this->highlightedDays = array();
	}

// setting functions

/**
 * CMonthCalendar::setDate()
 *
 * { Description }
 *
 * @param [type] $date
 */
	 function setDate($date=null) {
		$this->this_month = new CDate($date);

		$d = $this->this_month->getDay();
		$m = $this->this_month->getMonth();
		$y = $this->this_month->getYear();

		$this->prev_year = new CDate($date);
		$this->prev_year->setYear($this->prev_year->getYear()-1);

		$this->next_year = new CDate($date);
		$this->next_year->setYear($this->next_year->getYear()+1);
		
		setlocale(LC_TIME, 'en_AU');
		$date = Date_Calc::beginOfPrevMonth($d, $m, $y, FMT_TIMESTAMP_DATE);
		setlocale(LC_ALL, $AppUI->user_lang);
		
		$this->prev_month = new CDate($date);
		
		setlocale(LC_TIME, 'en_AU');
		$date = Date_Calc::beginOfNextMonth($d, $m, $y, FMT_TIMESTAMP_DATE);
		setlocale(LC_ALL, $AppUI->user_lang);
		$this->next_month =  new CDate($date);
	}

/**
 * CMonthCalendar::setStyles()
 *
 * { Description }
 *
 */
	 function setStyles($title, $main) {
		$this->styleTitle = $title;
		$this->styleMain = $main;
	}

/**
 * CMonthCalendar::setLinkFunctions()
 *
 * { Description }
 *
 * @param string $day
 * @param string $week
 */
	function setLinkFunctions($day='', $week='') {
		$this->dayFunc = $day;
		$this->weekFunc = $week;
	}

/**
 * CMonthCalendar::setCallback()
 *
 * { Description }
 *
 */
	function setCallback($function) {
		$this->callback = $function;
	}

/**
 * CMonthCalendar::setEvents()
 *
 * { Description }
 *
 */
 function setEvents($e) {
		$this->events = $e;
	}
	
/**
 * CMonthCalendar::setHighlightedDays()
 * ie 	['20040517'] => '#ff0000',
 *
 * { Description }
 *
 */
 function setHighlightedDays($hd) {
		$this->highlightedDays = $hd;
	}
	
// drawing functions
/**
 * CMonthCalendar::show()
 *
 * { Description }
 *
 */
	 function show() {
		$s = '';
		if ($this->showTitle) {
			$s .= $this->_drawTitle();
		}
		$s .= '<table border="0" cellspacing="1" cellpadding="2" width="100%" class="' . $this->styleMain . "\">\n";

		if ($this->showDays) {
			$s .= $this->_drawDays() . "\n";
		}

		$s .= $this->_drawMain();

		$s .= "</table>\n";

		return $s;
	}

/**
 * CMonthCalendar::_drawTitle()
 *
 * { Description }
 *
 */
	 function _drawTitle() {
		global $AppUI, $m, $a, $locale_char_set;
		$url = 'index.php?m=' . $m . (($a) ? ('&a=' . $a) : '') . (isset($_GET['dialog']) ? '&dialog=1' : '');

		$s = "\n" . '<table border="0" cellspacing="0" cellpadding="3" width="100%" class="' . $this->styleTitle . '">';
		$s .= "\n\t<tr>";

		if ($this->showArrows) {
			$href = ($url . '&date=' . $this->prev_month->format(FMT_TIMESTAMP_DATE) 
					 . (($this->callback) ? ('&callback=' . $this->callback) : '') 
					 . ((count($this->highlightedDays) > 0) ? ('&uts=' . key($this->highlightedDays)) : ''));
			$s .= "\n\t\t" . '<td align="left">';
			$s .= ('<a href="' . $href . '">' 
				   . dPshowImage(dPfindImage('prev.gif'), 16, 16, $AppUI->_('previous month')) . '</a>');
			$s .= '</td>';

		}


		$s .= "\n\t" . '<th width="99%" align="center">';
		if ($this->clickMonth) {
			$s .= '<a href="index.php?m=' . $m . '&date=' . $this->this_month->format(FMT_TIMESTAMP_DATE) . '">';
		}
		$s .= $this->this_month->format("%B %Y") . (($this->clickMonth) ? '</a>' : '');
		$s .= "</th>";

		if ($this->showArrows) {
			$href = ($url . '&date='  .$this->next_month->format(FMT_TIMESTAMP_DATE) 
					 . (($this->callback) ? ('&callback='.$this->callback) : '') 
					 . ((count($this->highlightedDays)>0) ? ('&uts='.key($this->highlightedDays)) : ''));
			$s .= "\n\t\t" . '<td align="right">';
			$s .= ('<a href="' . $href . '">' . dPshowImage(dPfindImage('next.gif'), 16, 16, $AppUI->_('next month')) 
				   . '</a>');
			$s .= "</td>";
		}

		$s .= "\n\t</tr>";
		$s .= "\n</table>";

		return $s;
	}
/**
* CMonthCalendar::_drawDays()
*
* { Description }
*
* @return string Returns table a row with the day names
*/
	function _drawDays() {
		global $AppUI;
		
		setlocale(LC_TIME, 'en_AU');
		$wk = Date_Calc::getCalendarWeek(null, null, null, '%a', LOCALE_FIRST_DAY);
		setlocale(LC_ALL, $AppUI->user_lang);
		
		$s = (($this->showWeek) ? ("\n\t\t" . '<th>&nbsp;</th>') : '');
		foreach($wk as $day) {
			$s .= ("\n\t\t" . '<th width="14%">' . $AppUI->_($day) . '</th>');
		}

		return ("\n<tr>" . $s . "\n</tr>");
	}

/**
 * CMonthCalendar::_drawMain()
 *
 * { Description }
 *
 */
	 function _drawMain() {
		GLOBAL $AppUI;
		$today = new CDate();
		$today = $today->format('%Y%m%d%w');

		$date = $this->this_month;
		$this_day = intval($date->getDay());
		$this_month = intval($date->getMonth());
		$this_year = intval($date->getYear());
		setlocale(LC_TIME, 'en_AU');
		$cal = Date_Calc::getCalendarMonth($this_month, $this_year, '%Y%m%d%w', LOCALE_FIRST_DAY);
		setlocale(LC_ALL, $AppUI->user_lang);

		$df = $AppUI->getPref('SHDATEFORMAT');

		$html = '';
		foreach ($cal as $week) {
			$html .= "\n<tr>";
			if ($this->showWeek) {
				$html .= ("\n\t" . '<td class="week">');
				$html .= (($this->dayFunc) ? ('<a href="javascript:' . $this->weekFunc . "('" .$week[0] . "')" . '">') 
						  : '');
				$html .= dPshowImage(dPfindImage('view.week.gif'), 16, 15, $AppUI->_('Week View'));
				$html .= (($this->dayFunc) ? ('</a>') : '');
				$html .= "</td>";
			}

			foreach ($week as $day) {
				$this_day = new CDate($day);
				$y = intval(substr($day, 0, 4));
				$m = intval(substr($day, 4, 2));
				$d = intval(substr($day, 6, 2));
				$dow = intval(substr($day, 8, 1));

				if ($m != $this_month) {
					$class = 'empty';
				} else if ($day == $today) {
					$class = 'today';
				} else if ($dow == 0 || $dow == 6) {
					$class = 'weekend';
				} else {
					$class = 'day';
				}
				$day = substr($day, 0, 8);
				$html .= "\n\t" . '<td class="' . $class . '"';
				if($this->showHighlightedDays && isset($this->highlightedDays[$day])) {
					$html .= ' style="border: 1px solid ' . $this->highlightedDays[$day] . '"';
				}
				$html .= ' onclick="' . $this->dayFunc . "('" . $day . "','" . $this_day->format($df) . "')" . '">';
				if ($m == $this_month) {
					if ($this->dayFunc) {
						$html .= ('<a href="javascript:' 
								  .  $this->dayFunc . "('" . $day . "','" . $this_day->format($df) . "')" 
								  . '" class="' . $class . '">');
				    }
					$html .=  $d . (($this->dayFunc) ? '</a>' : '');
					
					
				    if ($this->showEvents) {
						$html .= $this->_drawEvents(substr($day, 0, 8));
					}
				}
				$html .= "</td>";
			}
			$html .= "\n</tr>";
		}
		return $html;
	}

/**
 * CMonthCalendar::_drawWeek()
 *
 * { Description }
 *
 */
	 function _drawWeek($dateObj) {
		GLOBAL $AppUI;
		
		$w = "\t\t".'<td class="week">';
		if ($this->dayFunc) {
			$w .= ('<a href="javascript:' . $this->weekFunc . "(" . $dateObj->getTimestamp() . ",'" 
				   . $dateObj->toString() . "')" . '">');
		}
		$w .= dPshowImage(dPfindImage('view.week.gif'), 16, 15, $AppUI->_('Week View'));
		$w .= (($this->dayFunc) ? '</a>' : '');
		$w .= "</td>\n";
		return $w;
	}

/**
 * CMonthCalendar::_drawEvents()
 *
 * { Description }
 *
 */
	 function _drawEvents($day) {
		GLOBAL $AppUI;
		
		$s = '';
		if (!(isset($this->events[$day]))) {
			return '';
		}
		$events = $this->events[$day];
		foreach ($events as $e) {
			$href = isset($e['href']) ? $e['href'] : null;
			$alt = isset($e['alt']) ? str_replace("\n",' ',$e['alt']) : null;

			$s .= "<br />\n";
			$s .= (($href) ? ('<a href="' . $href . '" class="event" title="' . $alt .'">') : '');
			$s .= $e['text'];
			$s .= (($href) ? '</a>' : '');
		}
		return $s;
	}
}

/**
* Event Class
*
* { Description }
*
*/
class CEvent extends CDpObject {
/** @var int */
	var $event_id = NULL;

/** @var string The title of the event */
	var $event_title = NULL;

	var $event_start_date = NULL;
	var $event_end_date = NULL;
	var $event_parent = NULL;
	var $event_description = NULL;
	var $event_times_recuring = NULL;
	var $event_recurs = NULL;
	var $event_remind = NULL;
	var $event_icon = NULL;
	var $event_owner = NULL;
	var $event_project = NULL;
	var $event_private = NULL;
	var $event_type = NULL;
	var $event_notify = null;
	var $event_cwd = null;

	function CEvent() {
		$this->CDpObject('events', 'event_id');
	}

// overload check operation
	function check() {
	// ensure changes to check boxes and select lists are honoured
		$this->event_private = intval($this->event_private);
		$this->event_type = intval($this->event_type);
		$this->event_cwd = intval($this->event_cwd);
		return NULL;
	}


 /**
     *	Overloaded delete method
     *
     *	@author gregorerhardt
     *	@return null|string null if successful otherwise returns and error message
     */
	function delete() {
		global $AppUI;
		// call default delete method first
		$deleted = parent::delete($this->event_id);
		
		// if object deletion succeeded then iteratively delete relationships
		if (empty($deleted)) {
			// delete user_events relationship
			$q  = new DBQuery;
			$q->setDelete('user_events');
			$q->addWhere('event_id = '. $this->event_id);
			$deleted = ((!$q->exec())? $AppUI->_('Could not delete Event-User relationship').'. '.db_error():null);
			$q->clear;
		} 

		return $deleted;
	}

/**
* Calculating if an recurrent date is in the given period
* @param Date Start date of the period
* @param Date End date of the period
* @param Date Start date of the Date Object
* @param Date End date of the Date Object
* @param integer Type of Recurrence
* @param integer Times of Recurrence
* @param integer Time of Recurrence
* @return array Calculated Start and End Dates for the recurrent Event for the given Period
*/
	function getRecurrentEventforPeriod($start_date, $end_date, $event_start_date, $event_end_date
										 , $event_recurs, $event_times_recuring, $j) {

		//this array will be returned
		$transferredEvent = array();

		//create Date Objects for Event Start and Event End
		$eventStart = new CDate($event_start_date);
		$eventEnd = new CDate($event_end_date);

		//Time of Recurence = 0 (first occurence of event) has to be checked, too.
		if ($j>0) {
			switch ($event_recurs) {
				case 1:
					$eventStart->addSpan(new Date_Span(3600 * $j));
					$eventEnd->addSpan(new Date_Span(3600 * $j));
					break;
				case 2:
					$eventStart->addDays($j);
					$eventEnd->addDays($j);
					break;
				case 3:
					$eventStart->addDays(7 * $j);
					$eventEnd->addDays(7 * $j);
					break;
				case 4:
					$eventStart->addDays(14 * $j);
					$eventEnd->addDays(14 * $j);
					break;
				case 5:
					$eventStart->addMonths($j);
					$eventEnd->addMonths($j);
					break;
				case 6:
					$eventStart->addMonths(3 * $j);
					$eventEnd->addMonths(3 * $j);
					break;
				case 7:
					$eventStart->addMonths(6 * $j);
					$eventEnd->addMonths(6 * $j);
					break;
				case 8:
					$eventStart->addMonths(12 * $j);
					$eventEnd->addMonths(12 * $j);
					break;
				default:
					break;
			}
		}

		if ($start_date->compare ($start_date, $eventStart) <= 0 &&
			$end_date->compare ($end_date, $eventEnd) >= 0)
        {
		// add temporarily moved Event Start and End dates to returnArray
		$transferredEvent = array($eventStart, $eventEnd);
		}

		// return array with event start and end dates for given period (positive case)
		// or an empty array (negative case)
		return $transferredEvent;
	}


/**
* Utility function to return an array of events with a period
* @param Date Start date of the period
* @param Date End date of the period
* @return array A list of events
*/
	function getEventsForPeriod($start_date, $end_date, $filter = 'all', $user_id = null, $project_id = 0) {
		global $AppUI;
		
		// the event times are stored as unix time stamps, just to be different
		
		// convert to default db time stamp
		$db_start = $start_date->format(FMT_DATETIME_MYSQL);
		$db_end = $end_date->format(FMT_DATETIME_MYSQL);
		if (! isset($user_id)) {
			$user_id = $AppUI->user_id;
		}

		
		$project =& new CProject;
		if ($project_id) {
			$p =& $AppUI->acl();

			if ($p->checkModuleItem('projects', 'view', $project_id, $user_id)) {
				$allowedProjects = array('p.project_id = ' . $project_id);
			} else {
				$allowedProjects = array('1=0');
			}
		} else {
			$allowedProjects = $project->getAllowedSQL($user_id, 'event_project');
		}
		
		//do similiar actions for recurring and non-recurring events
		$queries = array('q'=>'q', 'r'=>'r');
		
		foreach ($queries as $query_set) {
			
			$$query_set  = new DBQuery;
			$$query_set->addTable('events', 'e');
			$$query_set->addQuery('e.*');
			$$query_set->addOrder('e.event_start_date, e.event_end_date ASC');
			
			$$query_set->addJoin('projects', 'p', 'p.project_id =  e.event_project');
			if (($AppUI->getState('CalIdxCompany'))) {
				$$query_set->addWhere('project_company = ' . $AppUI->getState('CalIdxCompany'));
			}
			
			if (count($allowedProjects)) {
				$$query_set->addWhere('((' . implode(' AND ',  $allowedProjects) . ') ' 
					. (($AppUI->getState('CalIdxCompany'))?'':$project_id?'':' OR event_project = 0 ').')');
			}
			
			switch ($filter) {
				case 'my':
					$$query_set->addJoin('user_events', 'ue'
										 , 'ue.event_id = e.event_id AND ue.user_id =' . $user_id);
					$$query_set->addWhere('(ue.user_id = '.$user_id.') AND (event_private=0 OR event_owner=' 
										  . $user_id.')');
					break;
				case 'own':
					$$query_set->addWhere('event_owner =' . $user_id);
					break;
				case 'all':
					$$query_set->addWhere('(event_private=0 OR event_owner=' . $user_id . ')');
					break;
			}
			
			if ($query_set == 'q') { // assemble query for non-recursive events
				$$query_set->addWhere('(event_recurs <= 0)');
				// following line is only good for *non-recursive* events
				$$query_set->addWhere("(event_start_date <= '$db_end' AND event_end_date >= '$db_start' "
									  ."OR event_start_date BETWEEN '$db_start' AND '$db_end')");
				$eventList = $$query_set->loadList();
			} else if ($query_set == 'r') { // assemble query for recursive events
				$$query_set->addWhere('(event_recurs > 0)');
				$eventListRec = $$query_set->loadList();
			}
		}
        
		
		//Calculate the Length of Period (Daily, Weekly, Monthly View)
		setlocale(LC_TIME, 'en_AU');
		$periodLength = Date_Calc::dateDiff($start_date->getDay(), $start_date->getMonth(), $start_date->getYear(), 
											$end_date->getDay(), $end_date->getMonth(), $end_date->getYear());
		setlocale(LC_ALL, $AppUI->user_lang);
		
		// AJD: Should this be going off the end of the array?  I don't think so.
		// If it should then a comment to that effect would be nice.
		// for ($i=0; $i < sizeof($eventListRec)+1;  $i++) {
		for ($i=0, $sz=sizeof($eventListRec); $i < $sz;  $i++) {
            
            //note from merlinyoda: j=0 is the original event according to getRecurrentEventforPeriod
            // So, since the event is *recurring* x times, the loop condition should be j <= x, not j < x.
            // This way the original and all recurrances are covered.
			//for ($j=0; $j < intval($eventListRec[$i]['event_times_recuring']); $j++) {
            for ($j=0, $end= intval($eventListRec[$i]['event_times_recuring']);$j<$end; $j++) {
				if ($periodLength == 1) { 
					// Daily View: show all
					$recEventDate = CEvent::getRecurrentEventforPeriod($start_date, $end_date
																	   , $eventListRec[$i]['event_start_date']
																	   , $eventListRec[$i]['event_end_date']
																	   , $eventListRec[$i]['event_recurs']
																	   , $eventListRec[$i]['event_times_recuring'], $j);
				} elseif ($periodLength > 1 && $eventListRec[$i]['event_recurs'] == 1 && $j==0) {
					// Weekly or Monthly View and Hourly Recurrent Events: show one time and add string 'hourly'
					$recEventDate = CEvent::getRecurrentEventforPeriod($start_date, $end_date
																	   , $eventListRec[$i]['event_start_date']
																	   , $eventListRec[$i]['event_end_date']
																	   , $eventListRec[$i]['event_recurs']
																	   , $eventListRec[$i]['event_times_recuring'], $j);
					$eventListRec[$i]['event_title'] = ($eventListRec[$i]['event_title'] 
														. ' (' . $AppUI->_('Hourly') . ')');
				} elseif ($periodLength > 1 && $eventListRec[$i]['event_recurs'] > 1) {
					//Weekly and Monthly View and higher recurrence mode: show all events of recurrence > 1
					$recEventDate = CEvent::getRecurrentEventforPeriod($start_date, $end_date
																	   , $eventListRec[$i]['event_start_date']
																	   , $eventListRec[$i]['event_end_date']
																	   , $eventListRec[$i]['event_recurs']
																	   , $eventListRec[$i]['event_times_recuring'], $j);
				}
				
				//add values to the eventsArray if check for recurrent event was positive
				if (sizeof($recEventDate) > 0) {
					$eList[0] = $eventListRec[$i];
					$eList[0]['event_start_date'] = $recEventDate[0]->format(FMT_DATETIME_MYSQL);
					$eList[0]['event_end_date'] = $recEventDate[1]->format(FMT_DATETIME_MYSQL);
					$eventList = array_merge($eventList,$eList);
				}
				// clear array of positive recurrent events for the case that next loop recEventDate is empty in order to avoid double display
				$recEventDate = array();
			}

		}

		//return a list of non-recurrent and recurrent events
		return $eventList;
	}


	function &getAssigned() {
		$q  = new DBQuery;
		$q->addTable('users', 'u');
		$q->addTable('user_events', 'ue');
		$q->addTable('contacts', 'con');
		$q->addQuery('u.user_id, CONCAT_WS(" ",contact_first_name, contact_last_name)');
		$q->addWhere('ue.event_id = ' . $this->event_id);
		$q->addWhere('user_contact = contact_id');
		$q->addWhere('ue.user_id = u.user_id');
		$assigned = $q->loadHashList();
		return $assigned;
	}

	function updateAssigned($assigned) {
		// First remove the assigned from the user_events table
		global $AppUI;
		
		$q = new DBQuery;
		$q->setDelete('user_events');		
		$q->addWhere('event_id = ' . $this->event_id);
		$q->exec();
		$q->clear();
		
		if (is_array($assigned) && count($assigned)) {
			
			foreach ($assigned as $uid) {
				if ($uid) {
					$q->addTable('user_events', 'ue');
					$q->addInsert('event_id', $this->event_id);
					$q->addInsert('user_id', $uid);
					$q->exec();
					$q->clear();
			    }
			}
			
			if ($msg = db_error()) {
				$AppUI->setMsg($msg, UI_MSG_ERROR);
			}
		}
	}

	function notify($assignees, $update = false, $clash = false) {
		global $AppUI, $locale_char_set, $dPconfig;
		
		$mail_owner = $AppUI->getPref('MAILALL');
		$assignee_list = explode(",", $assignees);
		$owner_is_assigned = in_array($this->event_owner, $assignee_list);
		if ($mail_owner && ! $owner_is_assigned && $this->event_owner) {
	  		array_push($assignee_list, $this->event_owner);
		}
		// Remove any empty elements otherwise implode has a problem
		foreach ($assignee_list as $key => $x) {
			if (! $x) {
				unset($assignee_list[$key]);
			}
		}
		if (! count($assignee_list)) {
	  		return;
		}
		
		$q  = new DBQuery;
		$q->addTable('users','u');
		$q->addTable('contacts','con');
		$q->addQuery('user_id, contact_first_name,contact_last_name, contact_email');
		$q->addWhere('u.user_contact = con.contact_id');
		$q->addWhere("user_id in (" . implode(',', $assignee_list) . ")");
		$users = $q->loadHashList('user_id');
		
		$date_format = $AppUI->getPref('SHDATEFORMAT');
		$time_format = $AppUI->getPref('TIMEFORMAT');
		$fmt = $date_format . ' ' . $time_format;
		
		$start_date =& new CDate($this->event_start_date);
		$end_date =& new CDate($this->event_end_date);
		
		$mail =& new Mail;
		$type = (($update) ? $AppUI->_('Updated') : $AppUI->_('New'));
		$subject_title = (($clash) ? ($AppUI->_('Requested Event')) : ($type . " " . $AppUI->_('Event')));
		
		$mail->Subject($subject_title . ": " . $this->event_title, $locale_char_set);
		$mail->From('"' . $AppUI->user_first_name . " " . $AppUI->user_last_name . '" <' . $AppUI->user_email . '>');
		
		$body = '';
		
		if ($clash) {
			$body .= ('You have been invited to an event by ' 
					  . $AppUI->user_first_name .' ' . $AppUI->user_last_name . "\n");
			$body .= 'However, either you or another intended invitee has a competing event'."\n";
			$body .= ($AppUI->user_first_name . ' ' . $AppUI->user_last_name 
					  . ' has requested that you reply to this message' . "\n");
			$body .= 'and confirm if you can or can not make the requested time.' . "\n\n";
		}
		
		$body .= $AppUI->_('Event') . ":\t" . $this->event_title . "\n";
		if (! $clash) {
			$body .= ($AppUI->_('URL') . ":\t" . $dPconfig['base_url'] . "/index.php?m=calendar&a=view&event_id=" 
					  . $this->event_id . "\n");
		}
		
		$body .= $AppUI->_('Starts') . ":\t" . $start_date->format($fmt) . "\n";
		$body .= $AppUI->_('Ends') . ":\t" . $end_date->format($fmt) . "\n";
		
		// Find the project name.
		if ($this->event_project) {
			$prj = array();
			$q  = new DBQuery;
			$q->addTable('projects','p');
			$q->addQuery('project_name');
			$q->addWhere('p.project_id ='.$this->event_project);
			$sql = $q->prepare();
			$q->clear();
			if (db_loadHash($sql, $prj)) {
				$body .= $AppUI->_('Project') . ":\t". $prj['project_name'] . "\n";
			}
		}
		
		$types = dPgetSysVal('EventType');
		
		$body .= $AppUI->_('Type') . ":\t" . $AppUI->_($types[$this->event_type]) . "\n";
		$body .= $AppUI->_('Attendees') . ":\t";
		
		$body_attend = '';
		foreach ($users as $user) {
			$body_attend .= ((($body_attend) ? ', ' : '') 
							 . $user['contact_first_name'] . ' ' . $user['contact_last_name']);
		}
		
		$body .= $body_attend . "\n\n" . $this->event_description . "\n";
		
		$mail->Body($body, $locale_char_set);
		
		foreach ($users as $user) {
			if (! $mail_owner && $user['user_id'] == $this->event_owner) {
				continue;
			}
			$mail->To($user['contact_email'], true);
			$mail->Send();
		}
	}
	
	function checkClash($userlist = null) {
		global $AppUI;
		if (! isset($userlist)) {
			return false;
		}
		$users = explode(',', $userlist);
		
		// Now, remove the owner from the list, as we will always clash on this.
		$key = array_search($AppUI->user_id, $users);
		if (isset($key) && $key !== false) {// Need both for change in php 4.2.0
			unset($users[$key]);
		}
		
		if (! count($users)) {
			return false;
		}
		
		$start_date =& new CDate($this->event_start_date);
		$end_date =& new CDate($this->event_end_date);
		
		// Now build a query to find matching events.
		$q  = new DBQuery;
		$q->addTable('events', 'e');
		$q->addQuery('e.event_owner, ue.user_id, e.event_cwd, e.event_id, e.event_start_date, e.event_end_date');
		$q->addJoin('user_events', 'ue', 'ue.event_id = e.event_id');
		$q->addWhere("event_start_date <= '" . $end_date->format(FMT_DATETIME_MYSQL) . "'");
		$q->addWhere("event_end_date >= '" . $start_date->format(FMT_DATETIME_MYSQL) . "'");
		$q->addWhere("(e.event_owner IN (" . implode(',', $users) 
					 . ") OR ue.user_id IN (" . implode(',', $users) ."))");
		$q->addWhere('e.event_id != ' . $this->event_id);
		
		$result = $q->exec();
		if (! $result) {
			return false;
		}
		
		$clashes = array();
		while ($row = db_fetch_assoc($result)) {
			array_push($clashes, $row['event_owner']);
			if ($row['user_id']) {
				array_push($clashes, $row['user_id']);
			}
		}
		$clash = array_unique($clashes);
		$q->clear();
		
		if (count($clash)) {  
			$q->addTable('users','u');
			$q->addTable('contacts','con');
			$q->addQuery('user_id');
			$q->addQuery('CONCAT_WS(" ",contact_first_name,contact_last_name)');
			$q->addWhere("user_id in (" . implode(",", $clash) . ")");
			$q->addWhere('user_contact = contact_id');
			return $q->loadHashList();
		} else {
			return false;
		}
		
	}
	
	function getEventsInWindow($start_date, $end_date, $start_time, $end_time, $users = null) {
		global $AppUI;
		
		if (! isset($users)) {
			return false;
		}
		if (! count($users)) {
			return false;
		}
		
		// Now build a query to find matching events. 
		$q  = new DBQuery;
		$q->addTable('events', 'e');
		$q->addQuery('e.event_owner, ue.user_id, e.event_cwd, e.event_id, e.event_start_date, e.event_end_date');
		$q->addJoin('user_events', 'ue', 'ue.event_id = e.event_id');
		$q->addWhere("event_start_date >= '$start_date'" 
					 . " AND event_end_date <= '$end_date'" 
					 . " AND EXTRACT(HOUR_MINUTE FROM e.event_end_date) >= '$start_time'" 
					 . " AND EXTRACT(HOUR_MINUTE FROM e.event_start_date) <= '$end_time'" 
					 . ' AND (e.event_owner IN (' . implode(',', $users) . ')' 
					 . ' OR ue.user_id IN (' . implode(',', $users) .'))');
		$result = $q->exec();
		if (! $result) {
			return false;
		}
		
		$eventlist = array();
		while ($row = db_fetch_assoc($result)) {
			$eventlist[] = $row;
		}
		$q->clear();
		
		return $eventlist;
	}
	
}

$event_filter_list = array ('my' => 'My Events',
							'own' => 'Events I Created',
							'all' => 'All Events');

?>

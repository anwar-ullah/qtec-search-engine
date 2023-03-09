<?php
	function documentUrl($value){
		return !empty($value) ? url('/'.$value) : false;
	}

	function apiUrl($value){
		return !empty($value) ? url('api/'.$value) : false;
	}
	
	function formatExcelDate($value){
		return date('d-m-y', strtotime(\Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))));
	}
	
	function sendEmail($email,$type,$message)
	{
		$mail=\Mail::send('emails.message', ['msg' => $message,'type'=>$type], function ($msg) use ($email){
			$msg
			->to($email->email,$email->name)
			->subject($email->subject);
		});
		
		return $message->id;
	}
	
	function genders(){
		return array(
        'Male',
        'Female',
        'Others',
		);
	}
	
	function gendersbn(){
		return array(
        	'মহিলা',
        	'পুরুষ',
        	'অন্যান্য',
		);
	}
	
	function maritalStatus(){
		return array(
	        'Single',
	        'Married',
	        'Divorced',
		);
	}
	
	function bloodGroups(){
		return array(
	        'N/A',
	        'A+',
	        'A-',
	        'B+',
	        'B-',
	        'O+',
	        'O-',
	        'AB+',
	        'AB-',
		);
	}
	
	function weekDays(){
		return array(
	        "Monday",
	        "Tuesday",
	        "Wednesday",
	        "Thursday",
	        "Friday",
	        "Saturday",
	        "Sunday",
		);
	}
	
	function weekDaysIndex(){
		return array(
	        "Monday" => 0,
	        "Tuesday" => 1,
	        "Wednesday" => 2,
	        "Thursday" => 3,
	        "Friday" => 4,
	        "Saturday" => 5,
	        "Sunday" => 6,
		);
	}
	
	function minutesDifference($from,$to)
	{
		$start_date = new DateTime($from);
		$since_start = $start_date->diff(new DateTime($to));
		$minutes = $since_start->days * 24 * 60;
		$minutes += $since_start->h * 60;
		$minutes += $since_start->i;
		return $minutes;
	}
	
	function freeLinks()
	{
		$links = array();
		$freeLinks=\Modules\Setups\Entities\FreeLink::where('status',1)->get();
		if(isset($freeLinks[0])){
			foreach ($freeLinks as $key => $link) {
				array_push($links, $link->route);
			}
		}
		return $links;
	}
	
	function this_url(){
		return request()->route()->uri;
	}
	
	function getModule($url)
	{
		$module=\Modules\Setups\Entities\Module::where('route',trim($url))->first();
		if(isset($module->id)){
			return $module;
		}
		return false;
	}
	
	function getMenu($url)
	{
		$menu=\Modules\Setups\Entities\Menu::where('route',trim($url))->first();
		if(isset($menu->id)){
			return $menu;
		}
		return false;
	}
	
	function getSubmenu($url)
	{
		$submenu=\Modules\Setups\Entities\Submenu::where('route',trim($url))->first();
		if(isset($submenu->id)){
			return $submenu;
		}
		return false;
	}
	
	function checkPermission($needle,$haystack,$option){
		
		if(isset(json_decode($haystack,true)[$option])){
			$haystack=json_decode($haystack,true)[$option];
			if(isset($haystack[0])){
				if(in_array($needle, $haystack)){
					return true;
				}
			}
		}
		
		return false;
	}
	
	function isOptionPermitted($route,$option_name){
		$links = explode('/',$route);
		$menu_id = getMenu($links[1]) ? getMenu($links[1])->id : false;
		$submenu_id = getSubmenu($links[1]) ? getSubmenu($links[1])->id : false;
		
		$option = \Modules\Setups\Entities\Option::where('name','LIKE','%'.$option_name.'%')
		->when($menu_id,function($query) use($menu_id){
			return $query->where('menu_id',$menu_id);
		})
		->when($submenu_id,function($query) use($submenu_id){
			return $query->where('submenu_id',$submenu_id);
		})
		->first();
		if(isset($option->id)){
			return checkPermission($option->id,auth()->user()->role->permissions,'options');
		}
		
		return false;
	}
	
	function shiftTypes($key=false){
		$types=array(
	        '7 hours (+1 hour Lunch)',
	        '8 hours (+1 hour Lunch)',
		);
		
		if($key){
			if(array_key_exists($key, $types)){
				return $types[$key];
			}
		}
		
		return $types;
	}
	
	function nameWithoutUID($employee){
		return $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name; 
	}
	
	function nameWithUID($employee){
		return $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.' ('.$employee->uid.')'; 
	}
	
	function dateRange($from, $to, $format = "Y-m-d")
	{
		$range = [];
		if(strtotime($from) && strtotime($to)){
			$begin = new \DateTime($from);
			$end = new \DateTime($to);
			
			$interval = new DateInterval('P1D');
			$dateRange = new DatePeriod($begin, $interval, $end);
			
			
			foreach ($dateRange as $date) {
				$range[] = $date->format($format);
			}
			array_push($range, date('Y-m-d',strtotime($to)));
		}
		
		return $range;
	}
	
	function timeDiff($from,$to)
	{
		$start_date=new \DateTime($from);
		$end_date=new \DateTime($to);
		$difference=$end_date->diff($start_date);
		return json_decode(json_encode($difference),true);
	}
	
	function payTypes($key=false){
		$types=array(
	        'Cash',
	        'Cheque',
		);
		
		if($key){
			if(array_key_exists($key, $types)){
				return $types[$key];
			}
		}
		
		return $types;
	}
	
	function getCreditorId($value){
		if($value == "choose"){
			return 0;
		}
		
		$creditor_id = (int)($value);
		if($creditor_id == 0){
			$creditor = \Modules\Accounts\Entities\Creditor::where('name',strtolower($value))->where('status',1)->first();
			if(!isset($creditor->id)){
				$creditor = \Modules\Accounts\Entities\Creditor::create([
                'name' => $value,
                'address' => '...',
                'phone' => '...',
                'email' => '...',
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'status' => 1,
				]);
			}
			
			return $creditor->id;
			}else{
			return $creditor_id;
		}
	}
	
	function getDebitorId($value){
		if($value == "choose"){
			return 0;
		}
		
		$debitor_id = (int)($value);
		if($debitor_id == 0){
			$debitor = \Modules\Accounts\Entities\Debitor::where('name',strtolower($value))->where('status',1)->first();
			if(!isset($debitor->id)){
				$debitor = \Modules\Accounts\Entities\Debitor::create([
                'name' => $value,
                'address' => '...',
                'phone' => '...',
                'email' => '...',
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'status' => 1,
				]);
			}
			
			return $debitor->id;
			}else{
			return $debitor_id;
		}
	}
	
	function getBankAccountId($value){
		if($value == "choose"){
			return 0;
		}
		
		$bank_account_id = (int)($value);
		if($bank_account_id == 0){
			$bankAccount = \Modules\Accounts\Entities\BankAccount::where('name',strtolower($value))->where('status',1)->first();
			if(!isset($bankAccount->id)){
				$bankAccount = \Modules\Accounts\Entities\BankAccount::create([
                'name' => $value,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'status' => 1,
				]);
			}
			
			return $bankAccount->id;
			}else{
			return $bank_account_id;
		}
	}
	
	function downloadPDF($name,$data,$view){
		return \PDF::loadView($view, $data)->setPaper('legal', 'landscape')->download($name.'-('.date('F j,Y g:i a').').pdf');
	}
	
	function downloadPDFExtra($name,$data,$view,$paper,$orientation){
		return \PDF::loadView($view, $data)->setPaper($paper, $orientation)->download($name.'-('.date('F j,Y g:i a').').pdf');
	}
	
	function downloadExcel($view, $data, $name, $type){
		return \Excel::download(new \App\Exports\Excel($view, $data), $name.'('.date('F j,Y g:i a').')'.'.'.$type);
	}
	
	function student(){
		$student = false;
		
		if(session()->has('student') && !empty(session()->get('student'))){
			$student = \Modules\Student\Entities\Student::find(session()->get('student'));
		}
		
		return $student;
	}
	
	function checkWeekend($date){
		$weekend = false;
		
		if(date('N',strtotime($date)) == 5){
			$weekend = true;
		}
		
		return $weekend;
	}
	
	function checkHoliday($date){
		$holiday = false;
		
		$search = \Modules\EventManagement\Entities\Holiday::where(['date' => $date,'status' => 1])->first();
		if(isset($search->id)){
			$holiday = true;
		}
		
		return $holiday;
	}
	
	function timeDifference($from,$to)
	{
		if(strtotime($from) && strtotime($to)){
			$start_date = new DateTime($from);
			$diff = $start_date->diff(new DateTime($to));
			
			return date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s));
		}
		
		return false;
	}

	function datatableOrdering(){
	    $order = false;
	    if(isset(request()->order[0])){
	        foreach(request()->order as $key => $ordering){
	            if($ordering['column'] != 0){
	                $order = $ordering;
	            }
	        }
	    }

	    return $order;
	}

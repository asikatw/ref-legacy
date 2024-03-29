<?php

class AKDate {
	public static function execute ($func , $date = 'now') 
	{
		$object = JFactory::getDate($dtae);
		
        if (is_callable( array( $object, $func ) ))
        {
            $temp = func_get_args();
            array_shift( $temp );
			array_shift( $temp );
            
            $args = array();
            foreach ($temp as $k => $v) {
                $args[] = &$temp[$k];
            }
            return call_user_func_array( array( $object, $func ), $args );
        }
        else
        {
            JError::raiseWarning( 0, $object.'::'.$func.' not supported.' );
            return false;
        }
	}
	
	public static function toFormat($date='now' , $format='%Y-%m-%d %H:%M:%S', $locale = true) {
		return JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') )->format($format, $locale) ;
	}
	
	/*
	 * function offsetTime
	 * @param 
	 */
	
	public static function offset($origin = 'now', $offset = 0, $unit = 'd')
	{
		if( $origin instanceof JDate ){
			$origin = $origin->toUnix();
		}else{
			$origin = JFactory::getDate( $origin , JFactory::getConfig()->get('offset') )->toUnix() ;
		}
		
		switch($unit){
			case 's':
			case 'second':
			default:
				$offset = $offset ;
			break ;
			
			case 'm':
			case 'minute':
				$offset = $offset * 60 ;
			break ;
			
			case 'h':
			case 'hr':
				$offset = $offset * 60 * 60 ;
			break ;	
			
			case 'd':
			case 'day':
				$offset = $offset * 60 * 60 * 24 ;
			break ;
		
			case 'w':
			case 'week':
				$offset = $offset * 60 * 60 * 24 * 7 ;
			break ;
			
			case 'mon':
			case 'month':
				$offset = $offset * 60 * 60 * 24 * 30 ;
			break ;
			
			case 'y':
			case 'year':
				$offset = $offset * 60 * 60 * 24 * 30 * 365 ;
			break ;
		}
		
		$result = $origin + $offset ;
		return $date = JFactory::getDate( $result , JFactory::getConfig()->get('offset') ) ;
	}
	
	
	/*日期差距計算函式
	
	* Param var $type  = 取得的差距格式 'year' or 'month' or 'day' or 'second'	
	* Param var $start = 起始日期，格式 '2009-11-10' or 'now'=現在日期
	* Param var $end   = 結束日期，格式 '2009-11-10' or 'now',null=現在日期
	* 
	* 範例：
	* TimeGap('year','now','2012-11-10');  Result = 2  ;
	* TimeGap('month','2005-10-20');       Result = 49 ; 	
	*/	
	public static function timeGap($type, $start, $end=null) {
	
		//開始日期轉換成UNIX時間戳記
		if ($start == 'now')
		  $startSecond = mktime();
		else {
		  $start = explode('-',$start);
		  $startSecond = mktime(0,0,0,$start[1],$start[2],$start[0]);
		}
		
		//結束日期轉換成UNIX時間戳記
		if ($end == 'now' || $end == null)
		  $endSecond = mktime();
		else {
		  $end = explode('-',$end);
		  $endSecond = mktime(0,0,0,$end[1],$end[2],$end[0]);
		}
	
		//相減取得差距秒數
		$Gap = $endSecond - $startSecond ;
		
		//換算成各種格式，無條件捨去
		switch ($type) {
		  
		  case 'second' :
			$Gap = intval($Gap);
		  break;
		  
		  case 'day' :
			$Gap = intval($Gap/86400);
		  break;
		  
		  case 'month' :
			$Gap = intval(($Gap/86400)/30);
		  break;
		  
		  case 'year' :
			$Gap = intval(($Gap/86400)/365);
		  break;
		  
		  case 'yearfloat' :
			$t = intval(($Gap/86400)/365);
			$d = $Gap - ( $t * 365 * 86400 );
			$d = round(($d / 86400)) ;
			if( $d > 182 ) $Gap = $t + 0.5 ;
			else $Gap = $t ;
		  break;
		  
		}
		
		return $Gap;
		
	}
}



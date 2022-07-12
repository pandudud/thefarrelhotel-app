<?php

if (! function_exists('getDays')) 
{
	function getDays()
	{
		return [
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu',
			'Sun' => 'Minggu'
		];
	}
}

if (! function_exists('getMonths')) 
{
	function getMonths()
	{
		return [
			1	=> "Januari",
			2	=> "Februari",
			3	=> "Maret",
			4	=> "April",
			5	=> "Mei",
			6	=> "Juni",
			7	=> "Juli",
			8	=> "Agustus",
			9	=> "September",
			10	=> "Oktober",
			11	=> "November",
			12	=> "Desember"
		];
	}
}

if (! function_exists('toRp')) 
{
	function toRp($parm)
	{
		return 'Rp. ' . number_format( floatval($parm), 0 , '' , '.' ) . ',00';
	}
}

if (! function_exists('toDecimal')) 
{
	function toDecimal($parm)
	{
		return number_format( floatval($parm), 0 , '' , '.' );
	}
}

if (! function_exists('tglIndo')) 
{
	function tglIndo($parm)
	{
		$array_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$dataBulan = date('n',strtotime($parm));
		return date('d',strtotime($parm))." ".$array_bulan[$dataBulan]." ".date('Y',strtotime($parm));
	}
}

if (! function_exists('tglIndoAngka')) 
{
	function tglIndoAngka($parm)
	{
		return date('d/m/Y',strtotime($parm));
	}
}

if (! function_exists('waktuIndo')) 
{
	function waktuIndo($parm)
	{
		return date('H:i', strtotime($parm));
	}
}

if (! function_exists('tglWaktuIndo')) 
{
	function tglWaktuIndo($parm)
	{
		if($parm == '0000-00-00 00:00:00'){
			return "-";
		}
		$array_bulan = array(1=>"Januari","Februari","Maret", "April", "Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember");
		$dataBulan = date('n',strtotime($parm));
		$dataWaktu = date('H:i',strtotime($parm));
		return date('d',strtotime($parm))." ".$array_bulan[$dataBulan]." ".date('Y',strtotime($parm))." ".$dataWaktu;
	}
}

if (! function_exists('hariTglWaktuIndo')) 
{
	function hariTglWaktuIndo($parm)
	{
		if($parm == '0000-00-00 00:00:00'){
			return "-";
		}
		$array_bulan = array(1=>"Januari","Februari","Maret", "April", "Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember");
		$dataBulan = date('n',strtotime($parm));

		$array_hari = array(1=>"Senin","Selasa","Rabu","Kamis","Jumat", "Sabtu","Minggu");
		$dataHari = date('N',strtotime($parm));

		$dataWaktu = date('H:i',strtotime($parm));

		return $array_hari[$dataHari].", ".date('d',strtotime($parm))." ".$array_bulan[$dataBulan]." ".date('Y',strtotime($parm))." ".$dataWaktu;
	}
}

if (! function_exists('timeInterval')) 
{
	function timeInterval($start, $end)
	{
		$date1=date_create($start);
		$date2=date_create($end);
		$diff=date_diff($date1,$date2);
		$jam=$diff->format('%h')+($diff->format('%a')*24);
		$menit=$diff->format('%i')+($diff->format('%a')*24);
		$detik=$diff->format('%s')+($diff->format('%a')*24);
		$time=['jam'=>$jam,'menit'=>$menit,'detik'=>$detik];
		return $time;
	}
}

if (! function_exists('timeInterval24')) 
{
	function timeInterval24($start, $end)
	{
		$date1=date_create($start);
		$date2=date_create($end);
		$diff=date_diff($date1,$date2);
		$jam=$diff->format('%h')+($diff->format('%a')*24);
		$menit=$diff->format('%i')+($diff->format('%a')*24);
		$detik=$diff->format('%s')+($diff->format('%a')*24);
		$time=Date('H:i:s',strtotime($jam.':'.$menit.':'.$detik));
		return $time;
	}
}

if (! function_exists('dateDiff')) 
{
	function dateDiff($parm)
	{
		$datetime1 = new DateTime();
		$datetime2 = new DateTime($parm);
		$interval = $datetime1->diff($datetime2);

		$year = $interval->format('%y');
		$month = $interval->format('%m');
		$day = $interval->format('%a');
		$hour = $interval->format('%h');
		$min = $interval->format('%i');

		$words = "";
		if($year > 0){
			$words .= $year;
			if($year == 1){
				$words .= " year ";
			}else{
				$words .= " years ";
			}
		}
		if($month > 0){
			$words .= $month;
			if($month == 1){
				$words .= " month ";
			}else{
				$words .= " months ";
			}
		}
		if($day > 0){
			$words .= $day;
			if($day == 1){
				$words .= " day ";
			}else{
				$words .= " days ";
			}
		}
		if($hour > 0){
			$words .= $hour;
			if($hour == 1){
				$words .= " hour ";
			}else{
				$words .= " hours ";
			}
		}
		if($min > 0){
			$words .= $min;
			if($min == 1){
				$words .= " min ";
			}else{
				$words .= " mins ";
			}
		}

		$con = $datetime1 > $datetime2 ? " ago" : " later";

		return $words.$con;
	}
}

if (! function_exists('collect_count')) 
{
	function collect_count($array, $count)
	{
		$return = [];
		for ($i=0; $i <= $count-1 ; $i++)
		{
			if(count($array) >= $count)
				array_push($return, $array[$i]);
		}
		return collect($return);
	}
}

if (! function_exists('same_collection')) 
{
	function same_collection($collection1, $collection2)
	{
		if(count($collection1->diff($collection2)) == 0)
			return true;
		return false;
	}
}

if (! function_exists('public_storage')) 
{
	function public_storage($path)
	{
		return asset('application/public/storage') . '/' . $path;
	}
}
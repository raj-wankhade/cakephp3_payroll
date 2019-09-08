<?php
namespace App\Controller;
use App\Controller\AppController;
/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 */
class HomeController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

    }
    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function getCsv($filename)
    {
        date_default_timezone_set('Asia/Kolkata');

        $time=strtotime(date('Y-m-d'));
        // get year and month from a date
        $data = array();
        $currentMonthNumber = date("n");
        $curretYear =  date("Y",$time);  

        for ($m=$currentMonthNumber; $m<=12; $m++) {
            
            $currentMonth =  date("F",$time); 
            $currentDay =  date("l",$time);  

            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
            $lastdateofthemonth = date("m/t/y", strtotime($curretYear.'-'. $m.'-'.date('d')));
            $lastday = date('t',strtotime($curretYear.'-'. $m.'-'.date('d')));

            $lastworkingday = date('l', strtotime($curretYear.'-'. $m.'-' . $lastday));

            if($lastworkingday == "Saturday") { 
            $newdate = strtotime ('-1 day', strtotime($lastdateofthemonth));
            $lastworkingday = date ('Y-m-j', $newdate);
            }
            elseif($lastworkingday == "Sunday") { 
            $newdate = strtotime ('-2 day', strtotime($lastdateofthemonth));
            $lastworkingday = date ( 'Y-m-j' , $newdate );
            } 
            else{
                $lastworkingday = date ( 'Y-m-j' , strtotime($curretYear.'-'. $m.'-' . $lastday) );
            }

            
            // bonus date
           $lastWeekDate = $curretYear . "/" . $m . "/" . "15";

            // bonus date
           $bonusDate = $curretYear . "/" . $m . "/" . "15";
            $timestamp = strtotime($bonusDate);
            $weekday= date("l", $timestamp );

            if ($weekday =="Saturday" OR $weekday =="Sunday") { 
                $bonusDate = date('Y-m-d', strtotime($bonusDate . 'next week wednesday'));
            }

            $dateObj   = \DateTime::createFromFormat('!m', $m);
            $monthName = $dateObj->format('F'); 

            $data[] = [$monthName, $lastworkingday, $bonusDate];

            $time=strtotime($curretYear . "-" . $m . "-" .$currentDay);
        }
        $_serialize = 'data';
        $_header = ['Month', 'Payment Date', 'Bonus Payment Date'];
        $this->response = $this->response->withDownload($filename . '.csv');
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->set(compact('data', '_serialize', '_header'));
        $f = fopen($filename . ".csv", "w");
        fputcsv($f, $_header);
        foreach ($data as $line) {
            fputcsv($f, $line);
        }
    }
}
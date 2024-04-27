<?php

class WorkingHours extends Model {
    protected static $tableName = 'working_hours';
    protected static $collumns = [
        'id',
        'user_id',
        'work_date',
        'time1',
        'time2',
        'time3',
        'time4',
        'worked_time',
    ];
    
    public static function loadFromUserAndDate($userId, $WorkDate) {
        $register = self::getOne(['user_id' => $userId, 'work_date' => $WorkDate]);
        
        if (!$register) {
            $register = new WorkingHours([
                'user_id' => $userId,
                'work_date' => $WorkDate,
                'worked_time' => 0,
            ]);
        }
        
        return $register;
    }

    public function getWorkedInterval(){
        [$t1,$t2,$t3,$t4] = $this->getTimes();
        $today = new DateTime('now');
        $dt1 = new DateTime($t1);
        $dt2 = new DateTime($t2);
        $dt3 = new DateTime($t3);
        $dt4 = new DateTime($t4);
        
        $horario1 = new DateInterval('PT0S');
        $horario2 = new DateInterval('PT0S');
        if ($t1) $horario1 = $dt1->diff($today);
        if ($t2) $horario1 = $dt1->diff($dt2);
        if ($t3) $horario2 = $dt3->diff($today );
        if ($t4) $horario2 = $dt3->diff($dt4);

        if (!$t1) {
            return date('H:i:s', strtotime('00:00:00'));
        }
        
        return date('H:i:s', strtotime("{$horario1->format('%H:%i:%s')} + {$horario2->h} hours {$horario2->i} minutes {$horario2->s} seconds"));

    }

    public function getLunchInterval(){
        [, $t2, $t3,] = $this->getTimes();
        $today = new DateTime('now');
        $dt2 = new DateTime($t2);
        $dt3 = new DateTime($t3);
        
        $hIntervalo = new DateInterval('PT1H');
        
        if ($t2) $hIntervalo = $today->diff($dt2);
        if ($t3) $hIntervalo = $dt3->diff($dt2);
        
        return $hIntervalo;
    }

    public function getExitTime() {
        [$t1, , ,$t4] = $this->getTimes();
        $today = new DateTime('now');
        $workday = new DateTime('07:20:00');
        $brackInterval = new DateTime('01:00:00');

        if (!$t1) {
            $work = explode(':', $workday->format('H:i:s'));
            $break = explode(':', $brackInterval->format('H:i:s'));            
            $h = date('H:i:s', strtotime("{$today->format('H:i:s')} + {$work[0]} hours {$work[1]} minutes {$work[2]} seconds"));
            return date('H:i:s', strtotime("{$h} + {$break[0]} hours {$break[1]} minutes {$break[2]} seconds"));
        } elseif($t4) {
            return $t4;

        } else {
            $workday = explode(':', $workday->format('H:i:s'));
            $lunchInterval = explode(':', $this->getLunchInterval()->format('%H:%I:%S'));
            $wd = date('H:i:s', strtotime("{$t1} + {$workday[0]} hours {$workday[1]} minutes {$workday[2]} seconds"));
            return date('H:i:s', strtotime("{$wd} + {$lunchInterval[0]} hours {$lunchInterval[1]} minutes {$lunchInterval[2]} seconds"));
        }
    }
    
    public static function getMonthyReport($userId, $data){
        $registers = [];
        $startDate = getFirstMonthDay($data)->format('Y-m-d');
        $endDate = getLastMonthDay($data)->format('Y-m-d');
        
        $result = WorkingHours::getResultSetFromSelect([
            'user_id' => $userId,
            'raw' => "work_date BETWEEN '{$startDate}' AND '{$endDate}'"
        ]);
        
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $registers[$row['work_date']] = new WorkingHours($row);
            }
        }
        
        return $registers;
    }
    
    private function getTimes(){
        $times = [];
        $this->time1 ? array_push($times, date('H:i:s', strtotime($this->time1))) : array_push($times, null);
        $this->time2 ? array_push($times, date('H:i:s', strtotime($this->time2))) : array_push($times, null);
        $this->time3 ? array_push($times, date('H:i:s', strtotime($this->time3))) : array_push($times, null);
        $this->time4 ? array_push($times, date('H:i:s', strtotime($this->time4))) : array_push($times, null);
        
        return $times;
    }
    
    function getBalance() {
        if (!$this->time1 && !isPastWorkDay($this->work_date)) return '';
        if ( $this->worked_time == DAILY_TIME ) return '—';

        $balance = $this->worked_time - DAILY_TIME;
        $balanceString = getTimeStringFromSeconds(abs($balance));
        $sign = $this->worked_time >= DAILY_TIME ? '+' : '-';
        return "{$sign}{$balanceString}";
    }

    public static function getAbsentUsers() {
        $today = new DateTime();
        $result = Database::getResultFromQuery("
            SELECT name FROM users
            WHERE end_date is NULL 
            AND id NOT IN (
                SELECT user_id FROM working_hours 
                WHERE work_date = '{$today->format('Y-m-d')}' 
                AND time1 IS NOT NULL
            )
        ");

        $absentUsers = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()){
                array_push($absentUsers, $row['name']);
            }
        }

        return $absentUsers;
    }

    public static function getWorkedTimeInMonth($date) {
        $startDate = (new DateTime("{$date}-1"))->format('Y-m-d');
        $endDate = getLastMonthDay($date)->format('Y-m-d');
        
        $result = static::getResultSetFromSelect([
            'raw' => "work_date BETWEEN '{$startDate}' AND '{$endDate}' "
        ], "sum(worked_time) as sum");

        return $result->fetch_assoc()['sum'];
    }

    public function innout($time){
        $timeCollumn = $this->getNextTime();
        if (!$timeCollumn) {
            throw new AppException("Você já fez os 4 batimentos do dia");
            header("Location: painel.php");
        }
    
        $this->$timeCollumn = $time;
        $this->worked_time = getSecondsFromDateInterval($this->getWorkedInterval());
        
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }
}  

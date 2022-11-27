<?php
    
// Name Space -> Name of the project\ Name of the folder
// Using the object of Month class in the other file Ex: <?php $month = new App\Date\Month(x, y) ?\> -> The __construct() gets 2 parameters
// Beacause of using namespace -> All the classe that we want to use is like we declare them as App\Date\Exception
// Thats why for the external class we should define their own namespace -> Ex: \Exception -> Comes from the root
namespace App\Date;

use App\Date\Month as DateMonth;

class Month {

    // This property is available to the public
    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    // We need to have $month & $year & ... variables to be accessible in all the methods of this class
    // For the solution we define the properties for the class
    private $months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    public $month;
    public $year;

    //For writing the documentation 
    //First parameter: Name of the constructor
    //@param: The arguments of the constructor
    //@throws: The exceptions

    /**
     * Month constructor 
     * 
     * @param int $month -> [1, 12]
     * @param int $year
     * @throws \Exception
     */

    // The class which allows us to construct our object
    // Each time we create a new object of this class -> The construct function will be called
    /*As we see in index.php (Where the calendar will show up) 
    we want to have dynamic time which means we won't define the month & year
    For preventing the error of the application 
    we define the argument of the __construct() method = null and put “?” before it 
    Then we replace it with current date */
    public function __construct(?int $month=null, ?int $year=null)
    {
        // $month === null -> value & data are the same
        // The date() returns the string value
        // intval() -> string -> int
        if ($month === null || $month < 1 || $month > 12){
            // In case they're === null, we give it the default value
            // date('m') -> Returns the month Ex: Mars
            $month = intval(date('m'));
        }

        if ($year === null){
            // date('Y') -> Returns the year Ex: 2022
            $year = intval(date('Y'));
        }

        //Verifying year validation
        if ($year < 1970){
            // Here we use Exception php native function which throws an exception for us 
            // We must indicate in php documentation that this method could sometimes return the exception
            throw new \Exception("L'année $year est inférieur à 1970");

        }

        // Here we define that the properties that we have, they'll take the values of the construct variables
        // With the methods we defined in the construct method:
        // -> We are sure that the variables have the right values & well defined
        $this->month = $month;
        $this->year = $year;
    }



     /**
     * Returns the frst day of the month
     *
     * @return \DateTime
     */
    public function getStartingDay(): \DateTime {
        // We define the starting date 
        // All the monthes start at day 01
        return new \DateTime("{$this->year}-{$this->month}-01");
    }



    /**
     * Returns the number of the weeks in the month
     *
     * @return integer 
     */
    public function getWeeks (): int {
        
        $start = $this->getStartingDay();

        // Ending date is more complicated because the ending date is not always the same
        // We use relative formats -> Ex: defining Sunday the last day of the week
        // modify() -> Native php relative format which modifies the date
        // we don't want to completely change the starting date -> we use the clone function
        // clone function -> Makes a clone of the starting date & we modify the clone of $start
        $end = (clone $start)->modify('+1 month -1 day');
        // var_dump($start, $end);

        // Now we need to get the number of weeks in the month
        // Format() -> Allows us to get the date in the format we like
        // $end->format('W') -> returns the number of weeks
        // return intval($end->format('W')) - intval($start->format('W')) -> in this case we'll have problem with Janvier, the returned value -47
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
        
        // fixing the Janvier Error -> In case that number of weeks are negative
        if ($weeks < 0){
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }



    /**
     * Is the day in current month?
     *
     * @param \DateTime $date
     * @return boolean
     */
    public function withinMonth (\DateTime $date): bool {
        
        // Here we simply get the date & month (NOT DAY) & we compare it 
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }


    /**
     * The function which returns the next month
     *
     * @return Month
     */
    public function nextMonth(): Month {
        $month = $this->month + 1;
        $year = $this->year;

        if($month > 12){
            $month = 1;
            $year = $year + 1; 
        }
        return new Month($month, $year);
    }


    /**
     * The function which returns the previous month
     *
     * @return Month
     */
    public function previousMonth(): Month {
        $month = $this->month - 1;
        $year = $this->year;

        if($month < 1){
            $month = 12;
            $year = $year -  1;
        }
        return new Month($month, $year);
    }

    /**
     * toString function
     * @return string -> Returns the date (Ex: Mars 2018) 
     */
    public function toString(): string {
        // the monthes started from 1 -> We define the index here
        return $this->months[$this->month -1] . ' ' . $this->year;
    }
}
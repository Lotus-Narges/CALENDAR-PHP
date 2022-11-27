<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="Css/calendar.css">
        <title>Agenda</title>
    </head> 
    <body>
        <!--navbar-dark -> The text will be shown on back
        bg-primary -> Blue color
        mb-3 -> margin bottom -->
        <nav class="navbar navbar-dark bg-primary mb-3">
            <!--The title of our website-->
            <a href="/index.php" class="navbar-brand">Mon calendrier</a>
        </nav> 
 
        <!-- Creating our calendar -->
        <?php
            // Requiring the Month class in this external file (manually)
            require '../src/Date/month.php';

            // get the month -> We create a new object of month class -> Access to the class
            try{
                //Using the month class by respecting the namespace
                //$_Get['month'] -> Will get automatically the value which is defined for the month variable
                // we define the condition for the null variables -> The variables get the null value in the first place
                // ?? -> Defines if the value of the variables are defined, we get the value, if not = null
            $month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null); 
            } catch(\Exception $e){
                // In case of the error, throw what we defined as an exception
                // In case month is not valid, we get the current month
                $month = new App\Date\Month();
            }

            // Get the first day
            $start = $month->getStartingDay()->modify('last monday');
        ?>
        
        <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
            <!-- Where we show the month -->
            <!-- <h1> should be a dynamic tag -> Which means when we gives id=1 -> displays “Janvier” for us 
            If our php is on english version Mars will be displayed as March -> So we need to create a class for that
            All the classes should be in src folder -> In the source folder
            -->
            <h1><?= $month->toString(); ?></h1>
            <div>
                <!--First we get the month property from Month class (The reason we set this property to public)
                Second: We get the previousMonth() method
                Third: We get the month variable in the previousMonth() method
                Fourth: We stock all the data in index.php?month (in index.php in $month variable)-->
                <a href="index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
                <a href="index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
            </div>
        </div>

        <table class="calendar_table calendar_table<?= $month->getWeeks(); ?>weeks">
            <?php for ($i=0; $i<$month->getWeeks(); $i++): ?>
                <tr>
                    <!--
                    $month -> The object of the Month class
                    days -> The public property in month class
                    $day -> The variable that we stock the data we get from the loop in it
                    -->
                    <!-- $k -> the variable which allows us to know which day we are -->
                    <?php foreach($month->days as $k => $day):
                        $date = (clone $start)->modify("+" . ($k + $i *7 ) . "days") ?>

                    <td class="<?= $month->withinMonth($date) ? '' : 'calendar_otherMonth'; ?>">

                        <!--Show the name of days just for the firts week-->
                        <?php if ($i === 0 ): ?>
                        <!--Getting the Days in the month-->
                        <div class="calendar_weekday"><?= $day; ?></div>
                        <?php endif; ?>

                        <!--Getting the Days in the week-->
                        <!--We need to add $k days to the day that we get -->
                        <!--For not modifying the original date -> We clone the data -->
                        <!--$i will be the number of week in the month 1, 2, 3, ... -->
                        <div class="calendar_day"><?= $date->format('d'); ?></div>

                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php endfor; ?>
        </table>

    </body> 
</html>
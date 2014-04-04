/* ------------------------------------------------------------------------
  # jprccron - Joomla cronjobs component for J1.6/1.7
  # ------------------------------------------------------------------------
  # author    Prieco S.A.
  # copyright Copyright (C) 2012 Prieco.com. All Rights Reserved.
  # @license - http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  # Websites: http://www.prieco.com
  # Technical Support:  Forum - http://www.prieco.com/en/forum.html
  ------------------------------------------------------------------------- */

window.addEvent('domready', function(){

    $each([$('minute2'), $('hour2'), $('day2'), $('month2'), $('weekday2')], function(obj,index){
        obj.addEvent('click',function(e){

            $('crontab').value = $('minute2').value + " " + $('hour2').value + " " +
            $('day2').value+" " + $('month2').value+" " + $('weekday2').value;

        });
    });

});



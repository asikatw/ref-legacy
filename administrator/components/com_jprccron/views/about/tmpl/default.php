<?php
/* ------------------------------------------------------------------------
  # jprccron - Joomla cronjobs component for J1.6/1.7
  # ------------------------------------------------------------------------
  # author    Prieco S.A.
  # copyright Copyright (C) 2012 Prieco.com. All Rights Reserved.
  # @license - http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  # Websites: http://www.prieco.com
  # Technical Support:  Forum - http://www.prieco.com/en/forum.html
  ------------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');
?>
<div id="editcell">
    Powered by <a target="_blank" href='http://www.prieco.com'>www.prieco.com</a>
    <img style='float:left; align:top;' src='http://www.prieco.com/images/logo.png' border='0'>
    <pre>
     JCron is a Joomla component for Cron Jobs Management and Scheduling! It's purpose is to simulate cron jobs through
    Joomla front end interface at preset periods of time for users who either don't have access to the server crontab or
    don't want to use it for any purpose!

    This software is a fork from the venerable JCron (<a target="_blank" href='http://www.joomlaplug.com'>JoomlaPlug.com</a>), updated to the new J1.6/1.7 branch.

     <b>How it works:</b>

     - in your Configuration area you will see a button called "Enable CRON RUN"
     - by clicking  that a code will be inserted into your template so cronjobs
       can be launched at their preset time from within your Joomla site
     - after that, by clicking the "Disable CRON RUN", the code will be removed as
       long as you haven't done any modifications to it

     Note*: the cronjob is launched at the preset time only if your site gets visits in place, each time a user or
            spider accesses your site you will have the cron running, else you might consider a server side solution!
     Note**: to execute the cron jobs, we use the PHP <b>exec()</b> function, so your provider must have it enabled!


     If you want to manually insert the code into your template, copy/paste the following code:
     <span style='background:#000000;color:#ffffff;'><b><?php echo htmlentities($this->code); ?></b></span>

    </pre>

    For support or suggestions please contact us on our <a href='http://www.joomlaplug.com/Forum/'>Forum</a> or by email <a href='mailto:admin@joomlaplug.com'>admin@joomlaplug.com</a>
</div>
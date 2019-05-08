<?php
/*
  This code is based on a public domain JS code which has been publsihed in
  http://www.fourmilab.ch/documents/calendar/ by by John Walker  --  September, MIM
  as calendar.js and astra.js
  That code has been converted to PHP and enclosed in a Multi_Calendar class by
  Kaveh Mousavi Zamani 
  eNoox Company 2007
*/

class Multi_Calendar {  
  /*
         JavaScript functions for the Fourmilab Calendar Converter
  
                    by John Walker  --  September, MIM
                http://www.fourmilab.ch/documents/calendar/
  
                  This program is in the public domain.
  */
  
  /*  You may notice that a variety of array variables logically local
      to functions are declared globally here.  In JavaScript, construction
      of an array variable from source code occurs as the code is
      interpreted.  Making these variables pseudo-globals permits us
      to avoid overhead constructing and disposing of them in each
      call on the function in which whey are used.  */
  
  var $J0000 = 1721424.5;                // Julian date of Gregorian epoch: 0000-01-01
  var $J1970 = 2440587.5;                // Julian date at Unix epoch: 1970-01-01
  var $JMJD  = 2400000.5;                // Epoch of Modified Julian Date system
  var $J1900 = 2415020.5;                // Epoch ($day 1) of Excel 1900 date system (PC)
  var $J1904 = 2416480.5;                // Epoch ($day 0) of Excel 1904 date system (Mac)
  
  var $NormLeap = array("Normal year", "Leap year");
  
  /*  $weekday_BEFORE  --  Return Julian date of given $weekday (0 = Sunday)
                          in the seven $days ending on $jd.  */
  
  function weekday_before($weekday, $jd)
  {
      return $jd - $this->jwday($jd - $weekday);
  }
  
  /*  SEARCH_weekday  --  Determine the Julian date for: 
  
              $weekday      $day of week desired, 0 = Sunday
              $jd           Julian date to begin search
              $direction    1 = next $weekday, -1 = last $weekday
              $offset       $offset from $jd to begin search
  */
  
  function search_weekday($weekday, $jd, $direction, $offset)
  {
      return $this->weekday_before($weekday, $jd + ($direction * $offset));
  }
  
  //  Utility $weekday functions, just wrappers for search_weekday
  
  function nearest_weekday($weekday, $jd)
  {
      return $this->search_weekday($weekday, $jd, 1, 3);
  }
  
  function next_weekday($weekday, $jd)
  {
      return $this->search_weekday($weekday, $jd, 1, 7);
  }
  
  function next_or_current_weekday($weekday, $jd)
  {
      return $this->search_weekday($weekday, $jd, 1, 6);
  }
  
  function previous_weekday($weekday, $jd)
  {
      return $this->search_weekday($weekday, $jd, -1, 1);
  }
  
  function previous_or_current_weekday($weekday, $jd)
  {
      return $this->search_weekday($weekday, $jd, 1, 0);
  }
  
  function TestSomething()
  {
  }
  
  //  LEAP_GREGORIAN  --  Is a given $year in the Gregorian calendar a leap $year ?
  
  function leap_gregorian($year)
  {
      return (($year % 4) == 0) &&
              (!((($year % 100) == 0) && (($year % 400) != 0)));
  }
  
  //  GREGORIAN_TO_$jd  --  Determine Julian $day number from Gregorian calendar date
  
  var $GREGORIAN_EPOCH = 1721425.5;
  
  function gregorian_to_jd($year, $month, $day)
  {
      return ($this->GREGORIAN_EPOCH - 1) +
             (365 * ($year - 1)) +
             floor(($year - 1) / 4) +
             (-floor(($year - 1) / 100)) +
             floor(($year - 1) / 400) +
             floor((((367 * $month) - 362) / 12) +
             (($month <= 2) ? 0 :
                                 ($this->leap_gregorian($year) ? -1 : -2)
             ) +
             $day);
  }
  
  //  $jd_TO_GREGORIAN  --  Calculate Gregorian calendar date from Julian $day
  
  function jd_to_gregorian($jd) {
  
      $wjd = floor($jd - 0.5) + 0.5;
      $depoch = $wjd - $this->GREGORIAN_EPOCH;
      $quadricent = floor($depoch / 146097);
      $dqc = $this->mod($depoch, 146097);
      $cent = floor($dqc / 36524);
      $dcent = $this->mod($dqc, 36524);
      $quad = floor($dcent / 1461);
      $dquad = $this->mod($dcent, 1461);
      $yindex = floor($dquad / 365);
      $year = ($quadricent * 400) + ($cent * 100) + ($quad * 4) + $yindex;
      if (!(($cent == 4) || ($yindex == 4))) {
          $year++;
      }
      $yearday = $wjd - $this->gregorian_to_jd($year, 1, 1);
      $leapadj = (($wjd < $this->gregorian_to_jd($year, 3, 1)) ? 0
                                                    :
                    ($this->leap_gregorian($year) ? 1 : 2)
                );
      $month = floor(((($yearday + $leapadj) * 12) + 373) / 367);
      $day = ($wjd - $this->gregorian_to_jd($year, $month, 1)) + 1;
  
      return array($year, $month, $day);
  }
  
  //  ISO_TO_JULIAN  --  Return Julian $day of given ISO $year, week, and $day
  
  function n_weeks($weekday, $jd, $nthweek)
  {
      $j = 7 * $nthweek;
  
      if ($nthweek > 0) {
          $j += $this->previous_weekday($weekday, $jd);
      } else {
          $j += $this->next_weekday($weekday, $jd);
      }
      return $j;
  }
  
  function iso_to_julian($year, $week, $day)
  {
      return $day + $this->n_weeks(0, $this->gregorian_to_jd($year - 1, 12, 28), $week);
  }
  
  //  $jd_TO_ISO  --  Return array of ISO ($year, week, $day) for Julian $day
  
  function jd_to_iso($jd)
  {
      $temp=$this->jd_to_gregorian($jd - 3);
      $year = $temp[0];
      if ($jd >= $this->iso_to_julian($year + 1, 1, 1)) {
          $year++;
      }
      $week = floor(($jd - $this->iso_to_julian($year, 1, 1)) / 7) + 1;
      $day = $this->jwday($jd);
      if ($day == 0) {
          $day = 7;
      }
      return array($year, $week, $day);
  }
  
  //  ISO_$day_TO_JULIAN  --  Return Julian $day of given ISO $year, and $day of $year
  
  function iso_day_to_julian($year, $day)
  {
      return ($day - 1) + $this->gregorian_to_jd($year, 1, 1);
  }
  
  //  $jd_TO_ISO_$day  --  Return array of ISO ($year, $day_of_$year) for Julian $day
  
  function jd_to_iso_day($jd)
  {

      $temp=$this->jd_to_gregorian($jd);
      $year = $temp[0];
      $day = floor($jd - $this->gregorian_to_jd($year, 1, 1)) + 1;
      return array($year, $day);
  }
  
  /*  PAD  --  Pad a string to a given length with a given fill character.  */
  
  function pad($str, $howlong, $padwith) {
  
      while (strlen($s) < $howlong) {
          $s = $padwith . $s;
      }
      return $s;
  }
  
  //  JULIAN_TO_$jd  --  Determine Julian $day number from Julian calendar date
  
  var $JULIAN_EPOCH = 1721423.5;
  
  function leap_julian($year)
  {
      return $this->mod($year, 4) == (($year > 0) ? 0 : 3);
  }
  
  function julian_to_jd($year, $month, $day)
  {
  
      /* Adjust negative common era $years to the zero-based notation we use.  */
  
      if ($year < 1) {
          $year++;
      }
  
      /* Algorithm as given in Meeus, Astronomical Algorithms, Chapter 7, page 61 */
  
      if ($month <= 2) {
          $year--;
          $month += 12;
      }
  
      return ((floor((365.25 * ($year + 4716))) +
              floor((30.6001 * ($month + 1))) +
              $day) - 1524.5);
  }
  
  //  $jd_TO_JULIAN  --  Calculate Julian calendar date from Julian $day
  
  function jd_to_julian($td) {
      
  
      $td += 0.5;
      $z = floor($td);
  
      $a = $z;
      $b = $a + 1524;
      $c = floor(($b - 122.1) / 365.25);
      $d = floor(365.25 * $c);
      $e = floor(($b - $d) / 30.6001);
  
      $month = floor(($e < 14) ? ($e - 1) : ($e - 13));
      $year = floor(($month > 2) ? ($c - 4716) : ($c - 4715));
      $day =$b - $d - floor(30.6001 * $e);
  
      /*  If $year is less than 1, subtract one to convert from
          a zero based date system to the common era system in
          which the $year -1 (1 B.C.E) is followed by $year 1 (1 C.E.).  */
  
      if ($year < 1) {
          $year--;
      }
  
      return array($year, $month, $day);
  }
  
  //  HEBREW_TO_$jd  --  Determine Julian $day from Hebrew date
  
  var $HEBREW_EPOCH = 347995.5;
  
  //  Is a given Hebrew $year a leap $year ?
  
  function hebrew_leap($year)
  {
      return $this->mod((($year * 7) + 1), 19) < 7;
  }
  
  //  How many $months are there in a Hebrew $year (12 = normal, 13 = leap)
  
  function hebrew_year_months($year)
  {
      return $this->hebrew_leap($year) ? 13 : 12;
  }
  
  //  Test for delay of start of new $year and to avoid
  //  Sunday, Wednesday, and Friday as start of the new $year.
  
  function hebrew_delay_1($year)
  {

  
      $months = floor(((235 * $year) - 234) / 19);
      $parts = 12084 + (13753 * $months);
      $day = ($months * 29) + floor($parts / 25920);
  
      if ($this->mod((3 * ($day + 1)), 7) < 3) {
          $day++;
      }
      return $day;
  }
  
  //  Check for delay in start of new $year due to length of adja$cent $years
  
  function hebrew_delay_2($year)
  {

  
      $last = $this->hebrew_delay_1($year - 1);
      $present = $this->hebrew_delay_1($year);
      $next = $this->hebrew_delay_1($year + 1);
  
      return (($next - $present) == 356) ? 2 :
                                       ((($present - $last) == 382) ? 1 : 0);
  }
  
  //  How many $days are in a Hebrew $year ?
  
  function hebrew_year_days($year)
  {
      return $this->hebrew_to_jd($year + 1, 7, 1) - $this->hebrew_to_jd($year, 7, 1);
  }
  
  //  How many $days are in a given $month of a given $year
  
  function hebrew_month_days($year, $month)
  {
      //  First of all, dispose of fixed-length 29 $day $months
  
      if ($month == 2 || $month == 4 || $month == 6 ||
          $month == 10 || $month == 13) {
          return 29;
      }
  
      //  If it's not a leap $year, Adar has 29 $days
  
      if ($month == 12 && !$this->hebrew_leap($year)) {
          return 29;
      }
  
      //  If it's Heshvan, $days depend on length of $year
  
      if ($month == 8 && !($this->mod($this->hebrew_year_days($year), 10) == 5)) {
          return 29;
      }
  
      //  Similarly, Kislev varies with the length of $year
  
      if ($month == 9 && ($this->mod($this->hebrew_year_days($year), 10) == 3)) {
          return 29;
      }
  
      //  Nope, it's a 30 $day $month
  
      return 30;
  }
  
  //  Finally, wrap it all up into...
  
  function hebrew_to_jd($year, $month, $day)
  {

  
      $months = $this->hebrew_year_months($year);
      $jd = $this->HEBREW_EPOCH + $this->hebrew_delay_1($year) +
           $this->hebrew_delay_2($year) + $day + 1;
  
      if ($month < 7) {
          for ($mon = 7; $mon <= $months; $mon++) {
              $jd += $this->hebrew_month_days($year, $mon);
          }
          for ($mon = 1; $mon < $month; $mon++) {
              $jd += $this->hebrew_month_days($year, $mon);
          }
      } else {
          for ($mon = 7; $mon < $month; $mon++) {
              $jd += $this->hebrew_month_days($year, $mon);
          }
      }
  
      return $jd;
  }
  
  /*  $jd_TO_HEBREW  --  Convert Julian date to Hebrew date
                        This works by making multiple calls to
                        the inverse function, and is this very
                        slow.  */
  
  function jd_to_hebrew($jd)
  {

  
      $jd = floor($jd) + 0.5;
      $count = floor((($jd - $this->HEBREW_EPOCH) * 98496.0) / 35975351.0);
      $year = $count - 1;
      for ($i = $count; $jd >= $this->hebrew_to_jd($i, 7, 1); $i++) {
          $year++;
      }
      $first = ($jd < $this->hebrew_to_jd($year, 1, 1)) ? 7 : 1;
      $month = $first;
      for ($i = $first; $jd > $this->hebrew_to_jd($year, i, $this->hebrew_month_days($year, $i)); $i++) {
          $month++;
      }
      $day = ($jd - $this->hebrew_to_jd($year, $month, 1)) + 1;
      return array($year, $month, $day);
  }
  
  /*  EQUINOXE_A_PARIS  --  Determine Julian $day and fraction of the
                            September equinox at the Paris meridian in
                            a given Gregorian $year.  */
  
  function equinoxe_a_paris($year)
  {

  
      //  September equinox in dynamical time
      $equJED = $this->equinox($year, 2);
  
      //  Correct for delta T to obtain Universal time
      $equjd = $equJED - ($this->deltat($year) / (24 * 60 * 60));
  
      //  Apply the equation of time to yield the apparent time at Greenwich
      $equAPP = $equjd + $this->equationOfTime($equJED);
  
      /*  Finally, we must correct for the constant difference between
          the Greenwich meridian and that of Paris, 2°20'15" to the
          East.  */
  
      $dtParis = (2 + (20 / 60.0) + (15 / (60 * 60.0))) / 360;
      $equParis = $equAPP + $dtParis;
  
      return $equParis;
  }
  
  /*  PARIS_EQUINOXE_$jd  --  Calculate Julian $day during which the
                             September equinox, reckoned from the Paris
                             meridian, occurred for a given Gregorian
                             $year.  */
  
  function paris_equinoxe_jd($year)
  {

  
      $ep = $this->equinoxe_a_paris($year);
      $epg = floor($ep - 0.5) + 0.5;
  
      return $epg;
  }
  
  /*  ANNEE_DE_LA_REVOLUTION  --  Determine the $year in the French
                                  revolutionary calendar in which a
                                  given Julian $day falls.  Returns an
                                  array of two elements:
  
                                      [0]  Année de la Révolution
                                      [1]  Julian $day number containing
                                           equinox for this $year.
  */
  
  var $FRENCH_REVOLUTIONARY_EPOCH = 2375839.5;
  
  function annee_da_la_revolution($jd)
  {
      $temp=$this->jd_to_gregorian($jd);
      $guess = $temp[0] - 2;
      
  
      $lasteq = $this->paris_equinoxe_jd($guess);
      while ($lasteq > $jd) {
          $guess--;
          $lasteq = $this->paris_equinoxe_jd($guess);
      }
      $nexteq = $lasteq - 1;
      while (!(($lasteq <= $jd) && ($jd < $nexteq))) {
          $lasteq = $nexteq;
          $guess++;
          $nexteq = $this->paris_equinoxe_jd($guess);
      }
      $adr = round(($lasteq - $this->FRENCH_REVOLUTIONARY_EPOCH) / $this->Tropicalyear) + 1;
  
      return array($adr, $lasteq);
  }
  
  /*  $jd_TO_FRENCH_REVOLUTIONARY  --  Calculate date in the French Revolutionary
                                      calendar from Julian $day.  The five or six
                                      "sansculottides" are considered a thirteenth
                                      $month in the results of this function.  */
  
  function jd_to_french_revolutionary($jd)
  {

  
      $jd = floor($jd) + 0.5;
      $adr = $this->annee_da_la_revolution($jd);
      $an = $adr[0];
      $equinoxe = $adr[1];
      $mois = floor(($jd - $equinoxe) / 30) + 1;
      $jour = ($jd - $equinoxe) % 30;
      $decade = floor($jour / 10) + 1;
      $jour = ($jour % 10) + 1;
  
      return array($an, $mois, $decade, $jour);
  }
  
  /*  FRENCH_REVOLUTIONARY_TO_$jd  --  Obtain Julian $day from a given French
                                      Revolutionary calendar date.  */
  
  function french_revolutionary_to_jd($an, $mois, $decade, $jour)
  {

  
      $guess = $this->FRENCH_REVOLUTIONARY_EPOCH + ($this->Tropicalyear * (($an - 1) - 1));
      $adr = array($an - 1, 0);
  
      while ($adr[0] < $an) {
          $adr = $this->annee_da_la_revolution($guess);
          $guess = $adr[1] + ($this->Tropicalyear + 2);
      }
      $equinoxe = $adr[1];
  
      $jd = equinoxe + (30 * ($mois - 1)) + (10 * ($decade - 1)) + ($jour - 1);
      return $jd;
  }
  
  //  LEAP_ISLAMIC  --  Is a given $year a leap $year in the Islamic calendar ?
  
  function leap_islamic($year)
  {
      return ((($year * 11) + 14) % 30) < 11;
  }
  
  //  ISLAMIC_TO_$jd  --  Determine Julian $day from Islamic date
  
  var $ISLAMIC_EPOCH = 1948439.5;
  var $ISLAMIC_weekdayS = array("al-'ahad", "al-'ithnayn",
                                   "ath-thalatha'", "al-'arb`a'",
                                   "al-khamis", "al-jum`a", "as-sabt");
  
  function islamic_to_jd($year, $month, $day)
  {
      return ($day +
              ceil(29.5 * ($month - 1)) +
              ($year - 1) * 354 +
              floor((3 + (11 * $year)) / 30) +
              $this->ISLAMIC_EPOCH) - 1;
  }
  
  //  $jd_TO_ISLAMIC  --  Calculate Islamic date from Julian $day
  
  function jd_to_islamic($jd)
  {

  
      $jd = floor($jd) + 0.5;
      $year = floor(((30 * ($jd - $this->ISLAMIC_EPOCH)) + 10646) / 10631);
      $month = min(12,
                  ceil(($jd - (29 + $this->islamic_to_jd($year, 1, 1))) / 29.5) + 1);
      $day = ($jd - $this->islamic_to_jd($year, $month, 1)) + 1;
      return array($year, $month, $day);
  }
  
  //  LEAP_PERSIAN  --  Is a given $year a leap $year in the Persian calendar ?
  
  function leap_persian($year)
  {
      return (((((($year - (($year > 0) ? 474 : 473)) % 2820) + 474) + 38) * 682) % 2816) < 682;
  }
  
  //  PERSIAN_TO_$jd  --  Determine Julian $day from Persian date
  
  var $PERSIAN_EPOCH = 1948320.5;
  var $PERSIAN_weekdayS = array("Yekshanbeh", "Doshanbeh",
                                   "Seshhanbeh", "Chaharshanbeh",
                                   "Panjshanbeh", "Jomeh", "Shanbeh");
  
  function persian_to_jd($year, $month, $day)
  {

  
      $epbase = $year - (($year >= 0) ? 474 : 473);
      $epyear = 474 + $this->mod($epbase, 2820);
  
      return $day +
              (($month <= 7) ?
                  (($month - 1) * 31) :
                  ((($month - 1) * 30) + 6)
              ) +
              floor((($epyear * 682) - 110) / 2816) +
              ($epyear - 1) * 365 +
              floor($epbase / 2820) * 1029983 +
              ($this->PERSIAN_EPOCH - 1);
  }
  
  //  $jd_TO_PERSIAN  --  Calculate Persian date from Julian $day
  
  function jd_to_persian($jd)
  {

  
      $jd = floor($jd) + 0.5;
  
      $depoch = $jd - $this->persian_to_jd(475, 1, 1);
      $cycle = floor($depoch / 1029983);
      $cyear = $this->mod($depoch, 1029983);
      if ($cyear == 1029982) {
          $ycycle = 2820;
      } else {
          $aux1 = floor($cyear / 366);
          $aux2 = $this->mod($cyear, 366);
          $ycycle = floor(((2134 * $aux1) + (2816 * $aux2) + 2815) / 1028522) +
                      $aux1 + 1;
      }
      $year = $ycycle + (2820 * $cycle) + 474;
      if ($year <= 0) {
          $year--;
      }
      $yday = ($jd - $this->persian_to_jd($year, 1, 1)) + 1;
      $month = ($yday <= 186) ? ceil($yday / 31) : ceil(($yday - 6) / 30);
      $day = ($jd - $this->persian_to_jd($year, $month, 1)) + 1;
      return array($year, $month, $day);
  }
  
  //  MAYAN_COUNT_TO_$jd  --  Determine Julian $day from Mayan long count
  
  var $MAYAN_COUNT_EPOCH = 584282.5;
  
  function mayan_count_to_jd($baktun, $katun, $tun, $uinal, $kin)
  {
      return $$this->MAYAN_COUNT_EPOCH +
             ($baktun * 144000) +
             ($katun  *   7200) +
             ($tun    *    360) +
             ($uinal  *     20) +
             $kin;
  }
  
  //  $jd_TO_MAYAN_COUNT  --  Calculate Mayan long count from Julian $day
  
  function jd_to_mayan_count($jd)
  {

  
      $jd = floor($jd) + 0.5;
      $d = $jd - $this->MAYAN_COUNT_EPOCH;
      $baktun = floor($d / 144000);
      $d = $this->mod($d, 144000);
      $katun = floor($d / 7200);
      $d = $this->mod($d, 7200);
      $tun = floor($d / 360);
      $d = $this->mod($d, 360);
      $uinal = floor($d / 20);
      $kin = $this->mod($d, 20);
  
      return array($baktun, $katun, $tun, $uinal, $kin);
  }
  
  //  $jd_TO_MAYAN_HAAB  --  Determine Mayan Haab "$month" and $day from Julian $day
  
  var $MAYAN_HAAB_monthS = array("Pop", "Uo", "Zip", "Zotz", "Tzec", "Xul",
                                    "Yaxkin", "Mol", "Chen", "Yax", "Zac", "Ceh",
                                    "Mac", "Kankin", "Muan", "Pax", "Kayab", "Cumku", "Uayeb");
  
  function jd_to_mayan_haab($jd)
  {

  
      $jd = floor($jd) + 0.5;
      $lcount = $jd - $this->MAYAN_COUNT_EPOCH;
      $day = $this->mod($lcount + 8 + ((18 - 1) * 20), 365);
  
      return array (floor($day / 20) + 1, $this->mod($day, 20));
  }
  
  //  $jd_TO_MAYAN_TZOLKIN  --  Determine Mayan Tzolkin "$month" and $day from Julian $day
  
  var $MAYAN_TZOLKIN_monthS = array("Imix", "Ik", "Akbal", "Kan", "Chicchan",
                                       "Cimi", "Manik", "Lamat", "Muluc", "Oc",
                                       "Chuen", "Eb", "Ben", "Ix", "Men",
                                       "Cib", "Caban", "Etznab", "Cauac", "Ahau");
  
  function jd_to_mayan_tzolkin($jd)
  {

  
      $jd = floor($jd) + 0.5;
      $lcount = $jd - $this->MAYAN_COUNT_EPOCH;
      return array ($this->mod($lcount + 20, 20), amod($lcount + 4, 13));
  }
  
  //  BAHAI_TO_$jd  --  Determine Julian $day from Bahai date
  
  var $BAHAI_EPOCH = 2394646.5;
  var $BAHAI_weekdayS = array("Jamál", "Kamál", "Fidál", "Idál",
                                 "Istijlál", "Istiqlál", "Jalál");
  
  function bahai_to_jd($major, $cycle, $year, $month, $day)
  {

      $temp=$this->jd_to_gregorian($this->BAHAI_EPOCH);
      $gy = (361 * ($major - 1)) + (19 * ($cycle - 1)) + ($year - 1) +
           $temp[0];
      return $this->gregorian_to_jd($gy, 3, 20) + (19 * ($month - 1)) +
             (($month != 20) ? 0 : ($this->leap_gregorian($gy + 1) ? -14 : -15))  +
             $day;
  }
  
  //  $jd_TO_BAHAI  --  Calculate Bahai date from Julian $day
  
  function jd_to_bahai($jd)
  {

      $jd = floor($jd) + 0.5;
      $temp=$this->jd_to_gregorian($jd);
      $gy = $temp[0];
      $temp=$this->jd_to_gregorian($this->BAHAI_EPOCH);
      $bstarty = $temp[0];
      $bys = $gy - ($bstarty + ((($this->gregorian_to_jd($gy, 1, 1) <= $jd) && ($jd <= $this->gregorian_to_jd($gy, 3, 20))) ? 1 : 0));
      $major = floor($bys / 361) + 1;
      $cycle = floor($this->mod($bys, 361) / 19) + 1;
      $year = $this->mod($bys, 19) + 1;
      $days = $jd - $this->bahai_to_jd($major, $cycle, $year, 1, 1);
      $bld = $this->bahai_to_jd($major, $cycle, $year, 20, 1);
      $month = ($jd >= $bld) ? 20 : (floor($days / 19) + 1);
      $day = ($jd + 1) - $this->bahai_to_jd($major, $cycle, $year, $month, 1);
  
      return array($major, $cycle, $year, $month, $day);
  }
  
  //  INDIAN_CIVIL_TO_$jd  --  Obtain Julian $day for Indian Civil date
  
  var $INDIAN_CIVIL_weekdayS = array(
      "ravivara", "somavara", "mangalavara", "budhavara",
      "brahaspativara", "sukravara", "sanivara");
  
  function indian_civil_to_jd($year, $month, $day)
  {

      $gyear = $year + 78;
      $leap = $this->leap_gregorian($gyear);     // Is this a leap $year ?
      $start = $this->gregorian_to_jd($gyear, 3, $leap ? 21 : 22);
      $Caitra = $leap ? 31 : 30;
  
      if ($month == 1) {
          $jd = $start + ($day - 1);
      } else {
          $jd = $start + $Caitra;
          $m = $month - 2;
          $m = min($m, 5);
          $jd += $m * 31;
          if ($month >= 8) {
              $m = $month - 7;
              $jd += $m * 30;
          }
          $jd += $day - 1;
      }
  
      return $jd;
  }
  
  //  $jd_TO_INDIAN_CIVIL  --  Calculate Indian Civil date from Julian $day
  
  function jd_to_indian_civil($jd)
  {

      $Saka = 79 - 1;                    // $offset in $years from $Saka era to Gregorian epoch
      $start = 80;                       // $day $offset between $Saka and Gregorian
  
      $jd = floor($jd) + 0.5;
      $greg = $this->jd_to_gregorian($jd);       // Gregorian date for Julian $day
      $leap = $this->leap_gregorian($greg[0]);   // Is this a leap $year?
      $year = $greg[0] - $Saka;            // Tentative $year in $Saka era
      $greg0 = $this->gregorian_to_jd($greg[0], 1, 1); // $jd at start of Gregorian $year
      $yday = $jd - $greg0;                // $day number (0 based) in Gregorian $year
      $Caitra = $leap ? 31 : 30;          // $days in Caitra this $year
  
      if ($yday < $start) {
          //  $day is at the end of the preceding $Saka $year
          $year--;
          $yday += $Caitra + (31 * 5) + (30 * 3) + 10 + $start;
      }
  
      $yday -= $start;
      if ($yday < $Caitra) {
          $month = 1;
          $day = $yday + 1;
      } else {
          $mday = $yday - $Caitra;
          if ($mday < (31 * 5)) {
              $month = floor($mday / 31) + 2;
              $day = ($mday % 31) + 1;
          } else {
              $mday -= 31 * 5;
              $month = floor($mday / 30) + 7;
              $day = ($mday % 30) + 1;
          }
      }
  
      return array($year, $month, $day);
  }
  
  /*  updateFromGregorian  --  Update all calendars from Gregorian.
                               "Why not Julian date?" you ask.  Because
                               starting from Gregorian guarantees we're
                               already snapped to an integral second, so
                               we don't get roundoff errors in other
                               calendars.  */
  
  
  
  //astro functions
  /*
              JavaScript functions for positional astronomy
  
                    by John Walker  --  September, MIM
                         http://www.fourmilab.ch/
  
                  This program is in the public domain.
  */
  
  //  Frequently-used constants
  
  
  var $J2000             = 2451545.0;              // Julian $day of $this->J2000 epoch
  var $JulianCentury     = 36525.0;                // $days in Julian $century
  var $JulianMillennium  = 365250.0;   // $days in Julian millennium (JulianCentury * 10) 
  var $AstronomicalUnit  = 149597870.0;            // Astronomical unit in kilometres
  var $Tropicalyear      = 365.24219878;           // Mean solar tropical $year
  
  /*  ASTOR  --  Arc-seconds to radians.  */
  
  function astor($a)
  {
      return $a * (M_PI / (180.0 * 3600.0));
  }
  
  /*  DTR  --  Degrees to radians.  */
  
  function dtr($d)
  {
      return ($d * M_PI) / 180.0;
  }
  
  /*  RTD  --  Radians to degrees.  */
  
  function rtd($r)
  {
      return ($r * 180.0) / M_PI;
  }
  
  /*  FIXANGLE  --  Range reduce angle in degrees.  */
  
  function fixangle($a)
  {
          return $a - 360.0 * (floor($a / 360.0));
  }
  
  /*  FIXANGR  --  Range reduce angle in radians.  */
  
  function fixangr($a)
  {
          return $a - (2 * M_PI) * (floor($a / (2 * M_PI)));
  }
  
  //  DSIN  --  Sine of an angle in degrees
  
  function dsin($d)
  {
      return sin($this->dtr($d));
  }
  
  //  DCOS  --  Cosine of an angle in degrees
  
  function dcos($d)
  {
      return cos($this->dtr($d));
  }
  
  /*  MOD  --  Modulus function which works for non-integers.  */
  
  function mod($a, $b)
  {
      return $a - ($b * floor($a / $b));
  }
  
  //  AMOD  --  Modulus function which returns numerator if modulus is zero
  
  function amod($a, $b)
  {
      return $this->mod($a - 1, $b) + 1;
  }
  
  /*  JHMS  --  Convert Julian time to hour, minutes, and seconds,
                returned as a three-element array.  */
  
  function jhms($j) {

  
      $j += 0.5;                 /* Astronomical to civil */
      $ij = (($j - floor($j)) * 86400.0) + 0.5;
      return array(
                       floor($ij / 3600),
                       floor(($ij / 60) % 60),
                       floor($ij % 60));
  }
  
  //  JW$day  --  Calculate $day of week from Julian $day
  
  var $weekdays = array( "Sunday", "Monday", "Tuesday", "Wednesday",
                            "Thursday", "Friday", "Saturday" );
  
  function jwday($j)
  {
      return $this->mod(floor(($j + 1.5)), 7);
  }
  
  /*  OBLIQEQ  --  Calculate the obliquity of the ecliptic for a given
                   Julian date.  This uses Laskar's tenth-degree
                   polynomial fit (J. Laskar, Astronomy and
                   Astrophysics, Vol. 157, page 68 [1986]) which is
                   accurate to within 0.01 arc second between AD 1000
                   and AD 3000, and within a few seconds of arc for
                   +/-10000 $years around AD 2000.  If we're outside the
                   range in which this fit is valid (deep time) we
                   simply return the $this->J2000 value of the obliquity, which
                   happens to be almost precisely the mean.  */
  
  var $oterms = array (
          -4680.93,
             -1.55,
           1999.25,
            -51.38,
           -249.67,
            -39.05,
              7.12,
             27.87,
              5.79,
              2.45
  );
  
  function obliqeq($jd)
  {

      $v =  ($jd - $this->J2000) / ($this->JulianCentury * 100);
      $u = $v;
      $eps = 23 + (26 / 60.0) + (21.448 / 3600.0);
  
      if (abs($u) < 1.0) {
          for ($i = 0; $i < 10; $i++) {
              $eps += ($this->oterms[$i] / 3600.0) * $v;
              $v *= $u;
          }
      }
      return $eps;
  }
  
  /* Periodic terms for nutation in longiude (delta \Psi) and
     obliquity (delta \Epsilon) as given in table 21.A of
     Meeus, "Astronomical Algorithms", first edition. */
  
  var $nutArgMult = array(
       0,  0,  0,  0,  1,
      -2,  0,  0,  2,  2,
       0,  0,  0,  2,  2,
       0,  0,  0,  0,  2,
       0,  1,  0,  0,  0,
       0,  0,  1,  0,  0,
      -2,  1,  0,  2,  2,
       0,  0,  0,  2,  1,
       0,  0,  1,  2,  2,
      -2, -1,  0,  2,  2,
      -2,  0,  1,  0,  0,
      -2,  0,  0,  2,  1,
       0,  0, -1,  2,  2,
       2,  0,  0,  0,  0,
       0,  0,  1,  0,  1,
       2,  0, -1,  2,  2,
       0,  0, -1,  0,  1,
       0,  0,  1,  2,  1,
      -2,  0,  2,  0,  0,
       0,  0, -2,  2,  1,
       2,  0,  0,  2,  2,
       0,  0,  2,  2,  2,
       0,  0,  2,  0,  0,
      -2,  0,  1,  2,  2,
       0,  0,  0,  2,  0,
      -2,  0,  0,  2,  0,
       0,  0, -1,  2,  1,
       0,  2,  0,  0,  0,
       2,  0, -1,  0,  1,
      -2,  2,  0,  2,  2,
       0,  1,  0,  0,  1,
      -2,  0,  1,  0,  1,
       0, -1,  0,  0,  1,
       0,  0,  2, -2,  0,
       2,  0, -1,  2,  1,
       2,  0,  1,  2,  2,
       0,  1,  0,  2,  2,
      -2,  1,  1,  0,  0,
       0, -1,  0,  2,  2,
       2,  0,  0,  2,  1,
       2,  0,  1,  0,  0,
      -2,  0,  2,  2,  2,
      -2,  0,  1,  2,  1,
       2,  0, -2,  0,  1,
       2,  0,  0,  0,  1,
       0, -1,  1,  0,  0,
      -2, -1,  0,  2,  1,
      -2,  0,  0,  0,  1,
       0,  0,  2,  2,  1,
      -2,  0,  2,  0,  1,
      -2,  1,  0,  2,  1,
       0,  0,  1, -2,  0,
      -1,  0,  1,  0,  0,
      -2,  1,  0,  0,  0,
       1,  0,  0,  0,  0,
       0,  0,  1,  2,  0,
      -1, -1,  1,  0,  0,
       0,  1,  1,  0,  0,
       0, -1,  1,  2,  2,
       2, -1, -1,  2,  2,
       0,  0, -2,  2,  2,
       0,  0,  3,  2,  2,
       2, -1,  0,  2,  2
  );
  
  var $nutArgCoeff = array(
      -171996,   -1742,   92095,      89,          /*  0,  0,  0,  0,  1 */
       -13187,     -16,    5736,     -31,          /* -2,  0,  0,  2,  2 */
        -2274,      -2,     977,      -5,          /*  0,  0,  0,  2,  2 */
         2062,       2,    -895,       5,          /*  0,  0,  0,  0,  2 */
         1426,     -34,      54,      -1,          /*  0,  1,  0,  0,  0 */
          712,       1,      -7,       0,          /*  0,  0,  1,  0,  0 */
         -517,      12,     224,      -6,          /* -2,  1,  0,  2,  2 */
         -386,      -4,     200,       0,          /*  0,  0,  0,  2,  1 */
         -301,       0,     129,      -1,          /*  0,  0,  1,  2,  2 */
          217,      -5,     -95,       3,          /* -2, -1,  0,  2,  2 */
         -158,       0,       0,       0,          /* -2,  0,  1,  0,  0 */
          129,       1,     -70,       0,          /* -2,  0,  0,  2,  1 */
          123,       0,     -53,       0,          /*  0,  0, -1,  2,  2 */
           63,       0,       0,       0,          /*  2,  0,  0,  0,  0 */
           63,       1,     -33,       0,          /*  0,  0,  1,  0,  1 */
          -59,       0,      26,       0,          /*  2,  0, -1,  2,  2 */
          -58,      -1,      32,       0,          /*  0,  0, -1,  0,  1 */
          -51,       0,      27,       0,          /*  0,  0,  1,  2,  1 */
           48,       0,       0,       0,          /* -2,  0,  2,  0,  0 */
           46,       0,     -24,       0,          /*  0,  0, -2,  2,  1 */
          -38,       0,      16,       0,          /*  2,  0,  0,  2,  2 */
          -31,       0,      13,       0,          /*  0,  0,  2,  2,  2 */
           29,       0,       0,       0,          /*  0,  0,  2,  0,  0 */
           29,       0,     -12,       0,          /* -2,  0,  1,  2,  2 */
           26,       0,       0,       0,          /*  0,  0,  0,  2,  0 */
          -22,       0,       0,       0,          /* -2,  0,  0,  2,  0 */
           21,       0,     -10,       0,          /*  0,  0, -1,  2,  1 */
           17,      -1,       0,       0,          /*  0,  2,  0,  0,  0 */
           16,       0,      -8,       0,          /*  2,  0, -1,  0,  1 */
          -16,       1,       7,       0,          /* -2,  2,  0,  2,  2 */
          -15,       0,       9,       0,          /*  0,  1,  0,  0,  1 */
          -13,       0,       7,       0,          /* -2,  0,  1,  0,  1 */
          -12,       0,       6,       0,          /*  0, -1,  0,  0,  1 */
           11,       0,       0,       0,          /*  0,  0,  2, -2,  0 */
          -10,       0,       5,       0,          /*  2,  0, -1,  2,  1 */
           -8,       0,       3,       0,          /*  2,  0,  1,  2,  2 */
            7,       0,      -3,       0,          /*  0,  1,  0,  2,  2 */
           -7,       0,       0,       0,          /* -2,  1,  1,  0,  0 */
           -7,       0,       3,       0,          /*  0, -1,  0,  2,  2 */
           -7,       0,       3,       0,          /*  2,  0,  0,  2,  1 */
            6,       0,       0,       0,          /*  2,  0,  1,  0,  0 */
            6,       0,      -3,       0,          /* -2,  0,  2,  2,  2 */
            6,       0,      -3,       0,          /* -2,  0,  1,  2,  1 */
           -6,       0,       3,       0,          /*  2,  0, -2,  0,  1 */
           -6,       0,       3,       0,          /*  2,  0,  0,  0,  1 */
            5,       0,       0,       0,          /*  0, -1,  1,  0,  0 */
           -5,       0,       3,       0,          /* -2, -1,  0,  2,  1 */
           -5,       0,       3,       0,          /* -2,  0,  0,  0,  1 */
           -5,       0,       3,       0,          /*  0,  0,  2,  2,  1 */
            4,       0,       0,       0,          /* -2,  0,  2,  0,  1 */
            4,       0,       0,       0,          /* -2,  1,  0,  2,  1 */
            4,       0,       0,       0,          /*  0,  0,  1, -2,  0 */
           -4,       0,       0,       0,          /* -1,  0,  1,  0,  0 */
           -4,       0,       0,       0,          /* -2,  1,  0,  0,  0 */
           -4,       0,       0,       0,          /*  1,  0,  0,  0,  0 */
            3,       0,       0,       0,          /*  0,  0,  1,  2,  0 */
           -3,       0,       0,       0,          /* -1, -1,  1,  0,  0 */
           -3,       0,       0,       0,          /*  0,  1,  1,  0,  0 */
           -3,       0,       0,       0,          /*  0, -1,  1,  2,  2 */
           -3,       0,       0,       0,          /*  2, -1, -1,  2,  2 */
           -3,       0,       0,       0,          /*  0,  0, -2,  2,  2 */
           -3,       0,       0,       0,          /*  0,  0,  3,  2,  2 */
           -3,       0,       0,       0           /*  2, -1,  0,  2,  2 */
  );
  
  /*  NUTATION  --  Calculate the nutation in longitude, deltaPsi, and
                    obliquity, $deltaEpsilon for a given Julian date
                    $jd.  Results are returned as a two element Array
                    giving (deltaPsi, $deltaEpsilon) in degrees.  */
  
  function nutation($jd)
  {
      $t = ($jd - 2451545.0) / 36525.0;
  
      $t3 = $t * ($t2 = $t * $t);
  
      /* Calculate angles.  The correspondence between the elements
         of our array and the terms cited in Meeus are:
  
         ta[0] = D  ta[0] = M  ta[2] = M'  ta[3] = F  ta[4] = \$Omega
  
      */
  
      $ta[0] = $this->dtr(297.850363 + 445267.11148 * $t - 0.0019142 * $t2 + 
                  $t3 / 189474.0);
      $ta[1] = $this->dtr(357.52772 + 35999.05034 * $t - 0.0001603 * $t2 -
                  $t3 / 300000.0);
      $ta[2] = $this->dtr(134.96298 + 477198.867398 * $t + 0.0086972 * $t2 +
                  $t3 / 56250.0);
      $ta[3] = $this->dtr(93.27191 + 483202.017538 * $t - 0.0036825 * $t2 +
                  $t3 / 327270);
      $ta[4] = $this->dtr(125.04452 - 1934.136261 * $t + 0.0020708 * $t2 +
                  $t3 / 450000.0);
  
      /* Range reduce the angles in case the sine and cosine functions
         don't do it as accurately or quickly. */
  
      for ($i = 0; $i < 5; $i++) {
          $ta[$i] = $this->fixangr($ta[$i]);
      }
  
      $to10 = $t / 10.0;
      for ($i = 0; $i < 63; $i++) {
          $ang = 0;
          for ($j = 0; $j < 5; $j++) {
              if ($this->nutArgMult[($i * 5) + $j] != 0) {
                  $ang += $this->nutArgMult[($i * 5) + $j] * $ta[$j];
              }
          }
          $dp += ($this->nutArgCoeff[($i * 4) + 0] + $this->nutArgCoeff[($i * 4) + 1] * $to10) * sin($ang);
          $de += ($this->nutArgCoeff[($i * 4) + 2] + $this->nutArgCoeff[($i * 4) + 3] * $to10) * cos($ang);
      }
  
      /* Return the result, converting from ten thousandths of arc
         seconds to radians in the process. */
  
      $deltaPsi = $dp / (3600.0 * 10000.0);
      $deltaEpsilon = $de / (3600.0 * 10000.0);
  
      return array($deltaPsi, $deltaEpsilon);
  }
  
  /*  ECLIPTOEQ  --  Convert celestial (ecliptical) longitude and
                     latitude into right ascension (in degrees) and
                     declination.  We must supply the time of the
                     conversion in order to compensate correctly for the
                     varying obliquity of the ecliptic over time.
                     The right ascension and declination are returned
                     as a two-element Array in that order.  */
  
  function ecliptoeq($jd, $Lambda, $Beta)
  {
  
      /* Obliquity of the ecliptic. */
  
      $eps = $this->dtr($this->obliqeq($jd));
      $log .= "Obliquity: " . $this->rtd($eps) . "\n";
  
      $Ra = $this->rtd(atan2((cos($eps) * sin($this->dtr($Lambda)) -
                          (tan($this->dtr($Beta)) * sin($eps))),
                        cos($this->dtr($Lambda))));
      $log .= "RA = " . $Ra + "\n";
      $Ra = $this->fixangle($this->rtd(atan2((cos($eps) * sin($this->dtr($Lambda)) -
                          (tan($this->dtr($Beta)) * sin($eps))),
                        cos($this->dtr($Lambda)))));
      $Dec = $this->rtd(asin((sin($eps) * sin($this->dtr($Lambda)) * cos($this->dtr($Beta))) +
                   (sin($this->dtr($Beta)) * cos($eps))));
  
      return array($Ra, $Dec);
  }
  
  
  /*  DELTAT  --  Determine the difference, in seconds, between
                  Dynamical time and Universal time.  */
  
  /*  Table of observed $Delta T values at the beginning of
      even numbered $years from 1620 through 2002.  */
  
  var $deltaTtab = array(
      121, 112, 103, 95, 88, 82, 77, 72, 68, 63, 60, 56, 53, 51, 48, 46,
      44, 42, 40, 38, 35, 33, 31, 29, 26, 24, 22, 20, 18, 16, 14, 12,
      11, 10, 9, 8, 7, 7, 7, 7, 7, 7, 8, 8, 9, 9, 9, 9, 9, 10, 10, 10,
      10, 10, 10, 10, 10, 11, 11, 11, 11, 11, 12, 12, 12, 12, 13, 13,
      13, 14, 14, 14, 14, 15, 15, 15, 15, 15, 16, 16, 16, 16, 16, 16,
      16, 16, 15, 15, 14, 13, 13.1, 12.5, 12.2, 12, 12, 12, 12, 12, 12,
      11.9, 11.6, 11, 10.2, 9.2, 8.2, 7.1, 6.2, 5.6, 5.4, 5.3, 5.4, 5.6,
      5.9, 6.2, 6.5, 6.8, 7.1, 7.3, 7.5, 7.6, 7.7, 7.3, 6.2, 5.2, 2.7,
      1.4, -1.2, -2.8, -3.8, -4.8, -5.5, -5.3, -5.6, -5.7, -5.9, -6,
      -6.3, -6.5, -6.2, -4.7, -2.8, -0.1, 2.6, 5.3, 7.7, 10.4, 13.3, 16,
      18.2, 20.2, 21.1, 22.4, 23.5, 23.8, 24.3, 24, 23.9, 23.9, 23.7,
      24, 24.3, 25.3, 26.2, 27.3, 28.2, 29.1, 30, 30.7, 31.4, 32.2,
      33.1, 34, 35, 36.5, 38.3, 40.2, 42.2, 44.5, 46.5, 48.5, 50.5,
      52.2, 53.8, 54.9, 55.8, 56.9, 58.3, 60, 61.6, 63, 65, 66.6
                           );
  
  function deltat($year)
  {
  
      if (($year >= 1620) && ($year <= 2000)) {
          $i = floor(($year - 1620) / 2);
          $f = (($year - 1620) / 2) - $i;  /* Fractional part of $year */
          $dt = $this->deltaTtab[$i] + (($this->deltaTtab[$i + 1] - $this->deltaTtab[$i]) * $f);
      } else {
          $t = ($year - 2000) / 100;
          if ($year < 948) {
              $dt = 2177 + (497 * $t) + (44.1 * $t * $t);
          } else {
              $dt = 102 + (102 * $t) + (25.3 * $t * $t);
              if (($year > 2000) && ($year < 2100)) {
                  $dt += 0.37 * ($year - 2100);
              }
          }
      }
      return $dt;
  }
  
  /*  EQUINOX  --  Determine the Julian Ephemeris $day of an
                   equinox or solstice.  The "which" argument
                   selects the item to be computed:
  
                      0   March equinox
                      1   June solstice
                      2   September equinox
                      3   December solstice
  
  */
  
  //  Periodic terms to obtain true time
  
  var $EquinoxpTerms = array(
                         485, 324.96,   1934.136,
                         203, 337.23,  32964.467,
                         199, 342.08,     20.186,
                         182,  27.85, 445267.112,
                         156,  73.14,  45036.886,
                         136, 171.52,  22518.443,
                          77, 222.54,  65928.934,
                          74, 296.72,   3034.906,
                          70, 243.58,   9037.513,
                          58, 119.81,  33718.147,
                          52, 297.17,    150.678,
                          50,  21.02,   2281.226,
                          45, 247.54,  29929.562,
                          44, 325.15,  31555.956,
                          29,  60.93,   4443.417,
                          18, 155.12,  67555.328,
                          17, 288.79,   4562.452,
                          16, 198.04,  62894.029,
                          14, 199.76,  31436.921,
                          12,  95.39,  14577.848,
                          12, 287.11,  31931.756,
                          12, 320.81,  34777.259,
                           9, 227.73,   1222.114,
                           8,  15.45,  16859.074
                               );
  
  var $jdE0tab1000 = array(
     array(1721139.29189, 365242.13740,  0.06134,  0.00111, -0.00071),
     array(1721233.25401, 365241.72562, -0.05323,  0.00907,  0.00025),
     array(1721325.70455, 365242.49558, -0.11677, -0.00297,  0.00074),
     array(1721414.39987, 365242.88257, -0.00769, -0.00933, -0.00006)
                         );
  
  var $jdE0tab2000 = array(
     array(2451623.80984, 365242.37404,  0.05169, -0.00411, -0.00057),
     array(2451716.56767, 365241.62603,  0.00325,  0.00888, -0.00030),
     array(2451810.21715, 365242.01767, -0.11575,  0.00337,  0.00078),
     array(2451900.05952, 365242.74049, -0.06223, -0.00823,  0.00032)
                         );
  
  function equinox($year, $which)
  {
  
      /*  Initialise terms for mean equinox and solstices.  We
          have two sets: one for $years prior to 1000 and a second
          for subsequent $years.  */
  
      if ($year < 1000) {
          $jdE0tab = $jdE0tab1000;
          $Y = $year / 1000;
      } else {
          $jdE0tab = $jdE0tab2000;
          $Y = ($year - 2000) / 1000;
      }
  
      $jdE0 =  $jdE0tab[$which][0] +
             ($jdE0tab[$which][1] * $Y) +
             ($jdE0tab[$which][2] * $Y * $Y) +
             ($jdE0tab[$which][3] * $Y * $Y * $Y) +
             ($jdE0tab[$which][4] * $Y * $Y * $Y * $Y);
  
  //document.debug.log.value += "$jdE0 = " + $jdE0 + "\n";
  
      $T = ($jdE0 - 2451545.0) / 36525;
  //document.debug.log.value += "T = " + T + "\n";
      $W = (35999.373 * T) - 2.47;
  //document.debug.log.value += "W = " + W + "\n";
      $deltaL = 1 + (0.0334 * $this->dcos($W)) + (0.0007 * $this->dcos(2 * $W));
  //document.debug.log.value += "deltaL = " + deltaL + "\n";
  
      //  Sum the periodic terms for time T
  
      $S = 0;
      for ($i = $j = 0; $i < 24; $i++) {
          $S += $this->EquinoxpTerms[$j] * $this->dcos($this->EquinoxpTerms[$j + 1] + ($this->EquinoxpTerms[$j + 2] * $T));
          $j += 3;
      }
  
  //document.debug.log.value += "S = " + S + "\n";
  //document.debug.log.value += "Corr = " + ((S * 0.00001) / deltaL) + "\n";
  
      $jdE = $jdE0 + (($S * 0.00001) / $deltaL);
  
      return $jdE;
  }
  
  /*  SUNPOS  --  Position of the Sun.  Please see the comments
                  on the return statement at the end of this function
                  which describe the array it returns.  We return
                  intermediate values because they are useful in a
                  variety of other contexts.  */
  
  function sunpos($jd)
  {
  
      $T = ($jd - $this->J2000) / $this->JulianCentury;
  //document.debug.log.value += "Sunpos.  T = " + T + "\n";
      $T2 = $T * $T;
      $L0 = 280.46646 + (36000.76983 * $T) + (0.0003032 * $T2);
  //document.debug.log.value += "L0 = " + L0 + "\n";
      $L0 = $this->fixangle($L0);
  //document.debug.log.value += "L0 = " + L0 + "\n";
      $M = 357.52911 + (35999.05029 * $T) + (-0.0001537 * $T2);
  //document.debug.log.value += "M = " + M + "\n";
      $M = $this->fixangle($M);
  //document.debug.log.value += "M = " + M + "\n";
      $e = 0.016708634 + (-0.000042037 * $T) + (-0.0000001267 * $T2);
  //document.debug.log.value += "e = " + e + "\n";
      $C = ((1.914602 + (-0.004817 * $T) + (-0.000014 * $T2)) * $this->dsin($M)) +
          ((0.019993 - (0.000101 * $T)) * $this->dsin(2 * $M)) +
          (0.000289 * $this->dsin(3 * $M));
  //document.debug.log.value += "C = " + C + "\n";
      $sunLong = $L0 + $C;
  //document.debug.log.value += "$sunLong = " + $sunLong + "\n";
      $sunAnomaly = $M + $C;
  //document.debug.log.value += "$sunAnomaly = " + $sunAnomaly + "\n";
      $sunR = (1.000001018 * (1 - ($e * $e))) / (1 + ($e * $this->dcos($sunAnomaly)));
  //document.debug.log.value += "$sunR = " + $sunR + "\n";
      $Omega = 125.04 - (1934.136 * $T);
  //document.debug.log.value += "$Omega = " + $Omega + "\n";
      $Lambda = $sunLong + (-0.00569) + (-0.00478 * $this->dsin($Omega));
  //document.debug.log.value += "$Lambda = " + $Lambda + "\n";
      $epsilon0 = $this->obliqeq($jd);
  //document.debug.log.value += "$epsilon0 = " + $epsilon0 + "\n";
      $epsilon = $epsilon0 + (0.00256 * $this->dcos($Omega));
  //document.debug.log.value += "$epsilon = " + $epsilon + "\n";
      $Alpha = $this->rtd(atan2($this->dcos($epsilon0) * $this->dsin($sunLong), $this->dcos($sunLong)));
  //document.debug.log.value += "$Alpha = " + $Alpha + "\n";
      $Alpha = $this->fixangle($Alpha);
  ////document.debug.log.value += "$Alpha = " + $Alpha + "\n";
      $Delta = $this->rtd(asin($this->dsin($epsilon0) * $this->dsin($sunLong)));
  ////document.debug.log.value += "$Delta = " + $Delta + "\n";
      $AlphaApp = $this->rtd(atan2($this->dcos($epsilon) * $this->dsin($Lambda), $this->dcos($Lambda)));
  //document.debug.log.value += "$AlphaApp = " + $AlphaApp + "\n";
      $AlphaApp = $this->fixangle($AlphaApp);
  //document.debug.log.value += "$AlphaApp = " + $AlphaApp + "\n";
      $DeltaApp = $this->rtd(asin($this->dsin($epsilon) * $this->dsin($Lambda)));
  //document.debug.log.value += "$DeltaApp = " + $DeltaApp + "\n";
  
      return array(                 //  Angular quantities are expressed in decimal degrees
          $L0,                           //  [0] Geometric mean longitude of the Sun
          $M,                            //  [1] Mean anomaly of the Sun
          $e,                            //  [2] Ec$centricity of the Earth's orbit
          $C,                            //  [3] Sun's equation of the Centre
          $sunLong,                      //  [4] Sun's true longitude
          $sunAnomaly,                   //  [5] Sun's true anomaly
          $sunR,                         //  [6] Sun's radius vector in AU
          $Lambda,                       //  [7] Sun's apparent longitude at true equinox of the date
          $Alpha,                        //  [8] Sun's true right ascension
          $Delta,                        //  [9] Sun's true declination
          $AlphaApp,                     // [10] Sun's apparent right ascension
          $DeltaApp                      // [11] Sun's apparent declination
      );
  }
  
  /*  EQUATIONOFTIME  --  Compute equation of time for a given moment.
                          Returns the equation of time as a fraction of
                          a $day.  */
  
  function equationOfTime($jd)
  {
  
      $tau = ($jd - $this->J2000) / $this->JulianMillennium;
  //document.debug.log.value += "equationOfTime.  tau = " + tau + "\n";
      $L0 = 280.4664567 + (360007.6982779 * $tau) +
           (0.03032028 * $tau * $tau) +
           (($tau * $tau * $tau) / 49931) +
           (-(($tau * $tau * $tau * $tau) / 15300)) +
           (-(($tau * $tau * $tau * $tau * $tau) / 2000000));
  //document.debug.log.value += "L0 = " + L0 + "\n";
      $L0 = $this->fixangle($L0);
  //document.debug.log.value += "L0 = " + L0 + "\n";
      $temp=$this->sunpos($jd);
      $alpha = $temp[10];
  //document.debug.log.value += "alpha = " + alpha + "\n";
      $temp=$this->nutation($jd);
      $deltaPsi = $temp[0];
  //document.debug.log.value += "deltaPsi = " + deltaPsi + "\n";
      $temp=$this->nutation($jd);
      $epsilon = $this->obliqeq($jd) + $temp[1];
  //document.debug.log.value += "$epsilon = " + $epsilon + "\n";
      $E = $L0 + (-0.0057183) + (-$alpha) + ($deltaPsi * $this->dcos($epsilon));
  //document.debug.log.value += "E = " + E + "\n";
      $E = $E - 20.0 * (floor($E / 20.0));
  //document.debug.log.value += "Efixed = " + E + "\n";
      $E = $E / (24 * 60);
  //document.debug.log.value += "E$day = " + E + "\n";
  
      return $E;
  }
  
}// class calendar  
?>
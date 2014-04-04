<?php
   mb_regex_encoding('UTF-8');
   mb_internal_encoding('UTF-8');

   // ******************************************************************************

   function mb($s) {
      return mb8($s);
   }
   
   function mb16($s) {
      //return mb_convert_encoding($s, 'UTF-16LE');
      return big5_to_utf16($s);
   }
   
   function mb8($s) {
      //return mb_convert_encoding($s, 'UTF-16LE');
      return big5_to_utf8($s);
   }
   
   function u8b5($s) {
      return utf8_to_big5($s);
   }
   
   function b5u8($s) {
      return big5_to_utf8($s);
   }
   
   function u8u16($s) {
      return utf8_to_utf16($s);
   }
   
   function u16u8($s) {
      return utf16_to_utf8($s);
   }
   
   function b5u16($s) {
      return big5_to_utf16($s);
   }
   
   function u16b5($s) {
      return utf16_to_big5($s);
   }
   
   function big5_to_utf16($s) {
      if (!$s) return '';
      return iconv("BIG-5", "UTF-16LE", $s);
   }
   
   function utf16_to_big5($s) {
      if (!$s) return '';
      return iconv("UTF-16LE", "BIG-5//IGNORE", $s);
   }
   
   function utf16_to_utf8($s) {
      if (!$s) return '';
      return iconv("UTF-16LE", "UTF-8", $s);
   }
   
   function utf8_to_utf16($s) {
      if (!$s) return '';
      return iconv("UTF-8", "UTF-16LE", $s);
   }
   
   function big5_to_utf8($s) {
      if (!$s) return '';
      return iconv("CP950", "UTF-8//IGNORE", $s);
   }
   
   function utf8_to_big5($s) {
      if (!$s) return '';
      return iconv("UTF-8", "CP950//IGNORE", $s);
   }
   
   // ******************************************************************************
?>

<?php

/*
 * Altera o formato das Datas; Apenas o primeiro parametro é obrigatório;
 * Ao passar os demais parametros, pode ou não, passar o parametro $reverseDate como terceiro parametro, seguido dos delimitadores;
 * Pode se usar um formato de Data como usado na função date() do PHP. Os argumentos aceitos nesse caso são apenas a Data (obrigatório)
 *      e os formatos de saída (opcional) e formato de entrada (opcional)
 *
 * formatDate($date[, $removeHour, $delimiter, $delimiterReplace])
 * formatDate($date[, $removeHour, $reverseDate, $delimiter, $delimiterReplace])
 * formatDate($date[, $maskDateReplace, $maskDate])
 *
 * @date - Data a ser formatada;
 * @removeHour - Booleano para definir se o resultado imprime ou não a hora se tiver;
 * @reverseDate - Caso passado como 3º parametro, inverte a posição da data 'dd/mm/YYYY' para 'YYYY/mm/dd' ou vice versa;
 * @delimiter - Define o Separador da Data do texto atual; Valor padrão é '/'; É o 4º parametro se passado o parametro reverseDate, ou 3º se não passado;
 * @delimiterReplace - Define o Separador da Data do texto formatado; Valor padrão é '-'; É o 5º parametro se passado o parametro reverseDate, ou 4º se não passado;
 * @maskDateReplace - Define o formato de saída da Data
 * @maskDate - Define o formato de entrada da Data
 *
 * @autor Pyetro Costa
 * @firstVersion Felipe Iwata
 *
 * @defaultFormatDate - Assume the default formate to DATE_ISO8601 (Example: 2013-04-12T15:52:01+0000)
 *
 * Resultados de uso:
 *    formatDate('1955-02-20', false);                   // 20/02/1955
 *    formatDate('1955/02/20', false, '/', '-');         // 20-02-1955
 *    formatDate('20-02-1955', false);                   // 1955/02/20
 *    formatDate('20/02/1955', false, '/', '-');         // 1955-02-20
 *
 *    formatDate('1955-02-20', false, true);             // 20/02/1955
 *    formatDate('1955/02/20', false, true, '/', '-');   // 20-02-1955
 *    formatDate('20-02-1955', false, true);             // 1955/02/20
 *    formatDate('20/02/1955', false, true, '/', '-');   // 1955-02-20
 *
 *    formatDate('1955-02-20', false, false);            // 1955/02/20
 *    formatDate('1955/02/20', false, false, '/', '-');  // 1955-02-20
 *    formatDate('20-02-1955', false, false);            // 20/02/1955
 *    formatDate('20/02/1955', false, false, '/', '-');  // 20-02-1955
 *
 *    formatDate('1955-02-20', 'd/m/Y');                 // 20/02/1955
 *    formatDate('1955/02/20', 'd-m-Y', 'Y/m/d');        // 20-02-1955
 *    formatDate('20-02-1955', 'Y/m/d', 'd-m-Y');        // 1955/02/20
 *    formatDate('20/02/1955', 'Y-m-d', 'd/m/Y');        // 1955-02-20
 *
 * Demonstração:
 * var_dump(
 *    '1955-02-20 ==> '.formatDate('1955-02-20', false)                       ." ( false ) ",
 *    '1955/02/20 ==> '.formatDate('1955/02/20', false, '/', '-')             ." ( false, '/', '-' ) ",
 *    '20-02-1955 ==> '.formatDate('20-02-1955', false)                       ." ( false ) ",
 *    '20/02/1955 ==> '.formatDate('20/02/1955', false, '/', '-')             ." ( false, '/', '-' ) ",
 *    '',
 *    '1955-02-20 ==> '.formatDate('1955-02-20', false, true)                 ." ( false, true ) ",
 *    '1955/02/20 ==> '.formatDate('1955/02/20', false, true, '/', '-')       ." ( false, true, '/', '-' ) ",
 *    '20-02-1955 ==> '.formatDate('20-02-1955', false, true)                 ." ( false, true ) ",
 *    '20/02/1955 ==> '.formatDate('20/02/1955', false, true, '/', '-')       ." ( false, true, '/', '-' ) ",
 *    '',
 *    '1955-02-20 ==> '.formatDate('1955-02-20', false, false)                ." ( false, false ) ",
 *    '1955/02/20 ==> '.formatDate('1955/02/20', false, false, '/', '-')      ." ( false, false, '/', '-' ) ",
 *    '20-02-1955 ==> '.formatDate('20-02-1955', false, false)                ." ( false, false ) ",
 *    '20/02/1955 ==> '.formatDate('20/02/1955', false, false, '/', '-')      ." ( false, false, '/', '-' ) ",
 *    '',
 *    '1955-02-20 ==> '.formatDate('1955-02-20', 'd/m/Y')                     ." ( 'd/m/Y' ) ",
 *    '1955/02/20 ==> '.formatDate('1955/02/20', 'd-m-Y', 'Y/m/d')            ." ( 'd-m-Y', 'Y/m/d' ) ",
 *    '20-02-1955 ==> '.formatDate('20-02-1955', 'Y/m/d', 'd-m-Y')            ." ( 'Y/m/d', 'd-m-Y' ) ",
 *    '20/02/1955 ==> '.formatDate('20/02/1955', 'Y-m-d', 'd/m/Y')            ." ( 'Y-m-d', 'd/m/Y' ) "
 * );
 */
if (!function_exists('formatDate') ) {
  function formatDate($value) {

    $numArgs = func_num_args();
    $getArgs = func_get_args();
    $removeHour = false;
    $reverseDate = ($numArgs>=5 and gettype($getArgs[2]!='boolean')) ? false : true;
    $delimiter = '-';
    $delimiterReplace = '/';
    $maskDateReplace = null;
    $maskDate = null;

    if ($value == null or $value == '')
        return null;

    // Seta parametro removeHour se passado como argumento no segundo parametro como Booleano
    if ($numArgs >= 2) {
      $removeHour = (gettype($getArgs[1])=='boolean') ? $getArgs[1] : $removeHour;
      if ($numArgs == 2 and gettype($getArgs[1])=='string')
        $maskDateReplace = $getArgs[1];
    }

    // Seta parametro reverseDate se passado como argumento no terceiro parametro como Booleano
    // Seta parametro delimiter se passado como argumento no terceiro (s/ reserveDate) ou quarto (c/ reserveDate) parametro como String
    // Seta parametro delimiter se passado como argumento no quarto (s/ reserveDate) ou quinto (c/ reserveDate) parametro como String
    if ($numArgs == 3) {
      if (gettype($getArgs[1])=='string') {
        list(, $maskDateReplace, $maskDate) = $getArgs;
      } else {
        $reverseDate        = (gettype($getArgs[2])=='boolean') ? $getArgs[2] : $reverseDate;
        $delimiter          = (gettype($getArgs[2])=='string') ? $getArgs[2] : $delimiter;
      }
    } else if ($numArgs==4) {
      if (gettype($getArgs[2])=='boolean')
        list(,, $reverseDate, $delimiter ) = $getArgs;
      else
        list(,, $delimiter, $delimiterReplace) = $getArgs;
    } else if ($numArgs==5) {
      list (,, $reverseDate, $delimiter, $delimiterReplace) = $getArgs;
    }

    // Usado apenas quando não for MaskedDate
    $date = $reverseDate ? array_reverse(explode($delimiter, substr($value, 0, 10))) : explode($delimiter, substr($value, 0, 10));

    // Anonymous Function to Mask Date
    $maskedDate = function () use ($value, $maskDateReplace, $maskDate, $delimiter, $delimiterReplace) {

      $maskDate = $maskDate==null? 'Y-m-d H:i:s' : $maskDate;
      $fmt = array('year'=>'1970','month'=>'01','day'=>'01','hour'=>'00','minute'=>'00','second'=>'00',);

      if ( $maskDate !== 'Y-m-d H-i-s' ) {
        $maskDate = str_split(preg_replace('/[^a-zA-Z]/i', '', $maskDate));
        $value = preg_replace('/[^0-9]/i', '', $value);
        for($i=0; $i < count($maskDate); $i++) {
          switch($maskDate[$i]) {
            case 'Y':
              $fmt['year'] = (substr($value, 0, 4)!=''? substr($value, 0, 4) : $fmt['year']);
              $value = substr($value, 4);
              break;
            case 'y':
              $fmt['year'] = (substr($value, 0, 2)!=''? substr($value, 0, 2) : $fmt['year']);
              $value = substr($value, 2);
              break;
            case 'm': case 'M':
              $fmt['month'] = (substr($value, 0, 2)!=''? substr($value, 0, 2) : $fmt['month']);
              $value = substr($value, 2);
              break;
            case 'd': case 'D':
              $fmt['day'] = (substr($value, 0, 2)!=''? substr($value, 0, 2) : $fmt['day']);
              $value = substr($value, 2);
              break;
            case 'g': case 'G':
              $fmt['hour'] = (substr($value, 0, 1)!=''? substr($value, 0, 1) : $fmt['hour']);
              $value = substr($value, 1);
              break;
            case 'h': case 'H':
              $fmt['hour'] = (substr($value, 0, 2)!=''? substr($value, 0, 2) : $fmt['hour']);
              $value = substr($value, 2);
              break;
            case 'i': case 'I':
              $fmt['minute'] = (substr($value, 0, 2)!=''? substr($value, 0, 2) : $fmt['minute']);
              $value = substr($value, 2);
              break;
            case 's': case 'S':
              $fmt['second'] = (substr($value, 0, 2)!=''? substr($value, 0, 2) : $fmt['second']);
              $value = substr($value, 2);
              break;
          }
        }
      } else {
        $datetime = explode(' ', $value);
        $date = explode($delimiter, $datetime[0]);
        $time = explode(':', $datetime[1]);

        list($fmt['year'], $fmt['month'], $fmt['day'] ) = $date;
        if ( count($time) == 3 )
          list($fmt['hour'], $fmt['minute'], $fmt['second']) = $time;
        else
          $fmt['hour'] = $fmt['minute'] = $fmt['second'] = '00';
      }

      try {
        $mkTime = mktime($fmt['hour'], $fmt['minute'], $fmt['second'], $fmt['month'], $fmt['day'], $fmt['year']);
      } catch (Exception $e) {
        return ($e->getMessage());
      }
      return date($maskDateReplace, $mkTime);
    };

    // Data Hora Com Mascara
    if ($maskDateReplace!==null)
      return $maskedDate();

    // Apenas data
    if (strlen($value) == 10) {
      return implode( $delimiterReplace, $date);
    }
    // Data e hora
    else if (strlen($value) > 10) {
      if ($removeHour == true) {
        return implode( $delimiterReplace, $date);
      } else {
        return implode( $delimiterReplace, $date).' '.substr($value, 11, 8);
      }
    }
  }
}

if (!function_exists('formatCpfCnpj')) {
  function formatCpfCnpj($cpf_cnpj) {
    $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);
    $qtd = strlen($cpf_cnpj);

    if($qtd >= 11) {
      if($qtd === 11 ) {
        $cpf_cnpjFormatado = substr($cpf_cnpj, 0, 3) . '.' .substr($cpf_cnpj, 3, 3) . '.' .substr($cpf_cnpj, 6, 3) . '-' .substr($cpf_cnpj, 9, 2);
      } else {
        $cpf_cnpjFormatado = substr($cpf_cnpj, 0, 2) . '.' .substr($cpf_cnpj, 2, 3) . '.' .substr($cpf_cnpj, 5, 3) . '/' .substr($cpf_cnpj, 8, 4) . '-' .substr($cpf_cnpj, -2);
      }
      return $cpf_cnpjFormatado;
    }
  }
}

if (!function_exists('removeAccent')) {
  function removeAccent($str) {
    $str = strtolower($str);

    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);

    return strtoupper($str);
  }
}

if (! function_exists('formatPhone') ) {
  function formatPhone($value) {
    $value = preg_replace('/\D+/', '', $value);

    if ($value !== '' or !is_null($value)) {
      if (strlen($value) == 8) // Telefone fixo sem DDD
        return substr($value, 0, 4).'-'.substr($value, -4);
      else if (strlen($value) == 9) // Celular sem DDD
        return substr($value, 0, 5).'-'.substr($value, -4);
      else if (strlen($value) == 10) // Telefone fixo com DDD
        return '('.substr($value, 0, 2).') '.substr($value, 2, 4).'-'.substr($value, -4);
      else if (strlen($value) == 11) // Celular com DDD
        return '('.substr($value, 0, 2).') '.substr($value, 2, 5).'-'.substr($value, -4);
      else if (strlen($value) == 12) // Telefone fixo com DDD e DDI do Brasil
        return '+'.substr($value, 0, 2).' ('.substr($value, 2, 2).') '.substr($value, 4, 4).'-'.substr($value, -4);
      else if (strlen($value) == 13) // Celular com DDD e DDI do Brasil
        return '+'.substr($value, 0, 2).' ('.substr($value, 2, 2).') '.substr($value, 4, 5).'-'.substr($value, -4);
    } else {
      return 'Número de telefone inválido !';
    }
  }
}


if (! function_exists('MaskText') ) {
  function MaskText($str, $mask) {
    $str = str_replace(' ','',$str);
    try {
      for($i=0; $i < strlen($mask); $i++) {
        $char = '';
        for ($j=0; $j < strlen($str); $j++) {
          switch( $mask[$i] ) {
            case '9':
              $char = preg_replace('/\D/', '', $str[0]); break;
            case 'a': case 'A':
              $char = preg_replace('/[^a-zA-ZÀ-ü]/', '', $str[0]); break;
            case '#':
              $char = preg_replace('/\W|_/', '', $str[0]); break;
            default:
              $char = $mask[$i]; break;
          }

          if ($char=='') {
            $str = substr($str, 1);
            continue;
          } else {
            if ($char == $str[0])
              $str = substr($str, 1);

            break;
          }
        }
        if ($char=='') {
          $mask = substr($mask, 0, $i);
          break;
        } else {
          $mask[$i] = $char;
        }
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    return $mask;
  }
}

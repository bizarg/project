<?php

//����� � ������� ����� ���������� �����
define('DIR','c:/xampp/tmp/sendmail/');

//�������� �� ������ ���� ������
$stream = '';
$fp = fopen('php://stdin','r');
while($t=fread($fp,2048))
    {
    if( $t===chr(0) )
        break;
    $stream .= $t;
    }
fclose($fp);

//��������� � ����
$fp = fopen(mkname(),'w');
fwrite($fp,iconv("UTF-8","CP1251",$stream));
fclose($fp);

//������� ���������� ����� �����
function mkname($i=0)
    {
    $fn = DIR.date('Y-m-d_H-i-s_').$i.'.eml';
    if ( file_exists($fn) )
        return mkname(++$i);
        else return $fn;
    }

?>
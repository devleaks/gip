<?php
$str = '{
 "full_count":8394
,"version":4
,"93afc49":["406132",51.0719,2.1614,99,33350,472,"0277","T-EGLC1","A319","G-EZFP",1459154949,"LGW","PRG","U25493",0,1280,"EZY46HM",0]
,"93afc7f":["471F86",52.3262,2.2503,81,35275,475,"0744","F-EHAM2","A320","HA-LYK",1459154951,"LTN","GDN","W61602",0,832,"WZZ1600",0]
,"93af010":["4B17A4",50.1278,2.2607,323,24075,359,"3035","F-LFSR2","RJ1H","HB-IYU",1459154951,"ZRH","LCY","LX460",0,-1216,"SWR45T",0]
}';
$o = json_decode($str);
$d = new StdClass();
$d->full_count = $o->full_count;
unset($o->full_count);
$d->version = $o->version;
unset($o->version);
$d->planes = get_object_vars($o);
echo '<pre>'.print_r($d, true).'</pre>';
//echo '<pre>'.json_encode($d, JSON_PRETTY_PRINT).'</pre>';

<?php
function countValue($l,$t1,$t2,$t3) {
    $j = array("", "jeden ", "dwa ", "trzy ", "cztery ", "pięć ", "sześć ",
        "siedem ", "osiem ", "dziewięć ", "dziesięć ", "jedenaście ",
        "dwanaście ", "trzynaście ", "czternaście ", "piętnaście ",
        "szesnaście ", "siedemnaście ", "osiemnaście ", "dziewiętnaście ");
    $d = array("", "", "dwadzieścia ", "trzydzieści ", "czterdzieści ",
        "pięćdziesiąt ", "sześćdziesiąt ", "siedemdziesiąt ",
        "osiemdziesiąt ", "dziewięćdziesiąt ");
    $s = array("","sto ", "dwieście ", "trzysta ", "czterysta ", "pięćset ",
        "sześćset ", "siedemset ", "osiemset ", "dziewięćset ");

    $txt = $s[0+substr($l,0,1)];
    if (substr($l,1,2)<20) $txt .= $j[0+substr($l,1,2)];
    else $txt .= $d[0+substr($l, 1,1)].$j[0+substr($l, 2,1)];
    if ($l==1) $txt .= "$t1 "; else {
        if ((substr($l,2,1)==2 or substr($l,2,1)==3 or substr($l,2,1)==4)
            and (substr($l,1,2)>20 or substr($l,1,2)<10))
            $txt .= "$t2 "; else $txt .= "$t3 ";
    }
    return $txt;
}

function num2words($liczba) {
    $liczba = str_replace(",", ".", $liczba);
    $liczba = number_format($liczba, 2, ",", "");
    $kwota=explode(",", $liczba);
    $kwotazl=sprintf("%012d",$kwota[0]);
    $kwotagr=sprintf("%03d",$kwota[1]);
    $txt="";
    if ($kwotazl>999999999) $txt .= countValue(substr($kwotazl, 0,3),"miliard","miliardy","miliardów");
    if ($kwotazl>999999) $txt .= countValue(substr($kwotazl, 3,3),"milion","miliony","milionów");
    if ($kwotazl>999) $txt .= countValue(substr($kwotazl, 6,3),"tysiąc","tysiące","tysięcy");
    if ($kwotazl>0) $txt .= countValue(substr($kwotazl, 9,3),"złoty","złote","złotych");
    if ($kwotazl==0) $txt="zero złotych";
    return $txt;
}
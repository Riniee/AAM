<?php
    require 'App.php';
    
	$xml=simplexml_load_file("MagPie.xml") or die("Error: Cannot create object");
    $mn = $xml->MEMBER_NUMBER;
    $dd = $xml->DRIVE_DATE;
    $pd = $xml->PRODUCT_TYPE;
    $rs = $xml->STATUS;
    //echo $mn.' '.$dd.' '.$pd.' '.$rs;
    $mn = strval($mn);
    $dd = strval($dd);
    $pd = strval($pd);
    $rs = strval($rs);
    print_r($xml);
    $conn = App::getConnection();
    if($rs != 'NONE') {
    $stid = oci_parse($conn, 'INSERT INTO CARDS (MEMBER_NUMBER, DRIVE_DATE,PRODUCT_TYPE,STATUS) VALUES (:mn, :dd, :pd, :rs)');
    oci_bind_by_name($stid, ':mn', $mn);
    oci_bind_by_name($stid, ':dd', $dd);
    oci_bind_by_name($stid, ':pd', $pd);
    oci_bind_by_name($stid, ':rs', $rs);
    oci_execute($stid);
   }
    else {
        $stid = oci_parse($conn, 'INSERT INTO CARDS (MEMBER_NUMBER, DRIVE_DATE,PRODUCT_TYPE) VALUES (:mn, :dd, :pd)');
        oci_bind_by_name($stid, ':mn', $mn);
        oci_bind_by_name($stid, ':dd', $dd);
        oci_bind_by_name($stid, ':pd', $pd);
        oci_execute($stid);
    }

    App::closeConnection($conn, $stid);
    
    if($stid) {
        echo 'successfully inserted';
    }
    else {
        echo 'Not  inserted';
    }
?>
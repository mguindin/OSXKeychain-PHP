<?php

/* class for getting/setting information from/to OS X keychain
 * author: Matt Guindin <matt@guindin.com>
 */

class OSX_Keychain {

    public static function getInternetUsername($key) {
        $com = "security find-internet-password -s $key | grep \"acct\" | cut -d '\"' -f 4";
        exec($com,$out,$err);
        return (!$err) ? $out[0] : "username not found";
    }

    public static function getInternetPassword($key) {
        $com = "security 2>&1 > /dev/null find-internet-password -gs $key | cut -d '\"' -f 2";
        exec($com,$out,$err);
        return (!$err) ? $out[0] : "password not found";
    }

    public static function setInternetPassword($key, $account, $password) {
        $com = "security 2>&1 > /dev/null add-internet-password -a $account -s $key -w $password";
        exec($com, $out, $err);
        return ($err) ? $out : true;
    }

    public static function hasInternetPassword($key) {
        $com = "security 2>&1 > /dev/null find-internet-password -gs $key";
        exec($com, $out, $err);
        return !$err;
    }

    public static function setGenericPassword($account, $service, $pass) {
        $com = "security add-generic-password -a $account -s $service -w $pass";
        exec($com,$out,$err);
        return (!$err) ? $out : true;
    }

    public static function findGenericPassword($account, $service) {
        $com = "security 2>&1 > /dev/null find-generic-password -a $account -s $service -g | cut -d '\"' -f 2";
        exec($com,$out,$err);
        return (!$err) ? $out[0] : "password not found";
    }

    public static function deleteGenericPassword($account, $service) {
        $com = "security delete-generic-password -a $account -s $service";
        exec($com,$out,$err);
        return !$err;
    }

    public static function hasGenericPassword($account, $service) {
        $com = "security 2>&1 > /dev/null find-generic-password -a $account -s $service -g";
        exec($com,$out,$err);
        return !$err;
    }
}

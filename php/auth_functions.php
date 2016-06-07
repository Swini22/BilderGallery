<?php
/*
 *  @autor Michael Abplanalp
 *  @version 1.0
 *
 *  Dieses Modul beinhaltet Funktionen, welche die Logik zur Authentifizierung implementieren.
 *
 */

/*
 * Beinhaltet die Anwendungslogik zur Registration
 */
function registration() {
    // Der Schaltknopf "senden" wurde betätigt
    if (isset($_REQUEST['senden'])) {
        $fehlermeldung = checkRegistration();
        // Wenn ein Fehler aufgetreten ist
        if (strlen($fehlermeldung) > 0) {
            setValue('css_class_meldung', "alert-warning show");
            setValue('meldung', $fehlermeldung);
            setValues($_REQUEST);
            // Wenn alles ok
        } else {
            db_insert_user($_REQUEST, passwordHash($_REQUEST['password']));
            setValue('css_class_meldung', "alert-info show");
            setValue('meldung', "Registration erfolgreich. Bitte melden Sie sich an.");
        }
        // Der Schaltknopf "abbrechen" wurde betätigt
    } else if (isset($_REQUEST['abbrechen'])) {
        redirect(__FUNCTION__);
        exit;
    }
    // Template abfüllen und Resultat zurückgeben
    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/registration.htm.php");
}

/*
 * Beinhaltet die Anwendungslogik zur änderung von Userdaten und zur löschung
 */
function userchange() {
    if (isset($_REQUEST['delete'])) {
        db_delete_user($_SESSION['userId']);
        logout();
    }

    // Template abfüllen und Resultat zurückgeben
    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/userchange.htm.php");
}

/*
 * Beinhaltet die Anwendungslogik zum Login
 */
function login() {
    // Es wurde auf die Schaltfläche "senden" geklickt
    if (isset($_REQUEST['senden'])) {
        $userId = checkLoginGetId();
        if ($userId > 0) {
            session_regenerate_id();
            setSessionValue("userId", $userId);
            $flist = getValue('cfg_func_member');
            redirect($flist[0]);
            exit;
        } else {
            unset($_SESSION['userId']);
            setValues($_REQUEST);
            setValue('css_class_meldung', "alert-warning show");
            setValue('meldung', "E-Mail-Passwort kombination konnte nicht gefunden werden. Bitte Eingaben korrigieren oder Registration benutzen.");
        }
    }
    // Das Forum wird ohne Angabe der Funktion aufgerufen bzw. es wurde auf die Schaltfläche "abbrechen" geklickt
    setValue('phpmodule', $_SERVER['PHP_SELF'] . "?id=" . __FUNCTION__);
    return runTemplate("../templates/login.htm.php");
}

/*
 * Prüft, ob ein User angemeldet ist
 */
function angemeldet() {
    if (strlen(getSessionValue("userId")) > 0) return true;
    else return false;
}

/*
 * Beinhaltet die Anwendungslogik zum Logout
 */
function logout() {
    session_destroy();
    $flist = getValue('cfg_func_login');
    redirect($flist[0]);
    exit;
}

/*
 * Prüft, ob der Primary Key "email" in der Tabelle "user" bereits existiert
 *
 * @param       $email      Zu prüfende E-Mail Adresse
 *
 */
function emailExists($email) {
    $resultat = db_get_email($email);
    if (empty($resultat)) return false;
    else return true;
}

/*
 * Funktion zur Eingabeprüfung bei der Registration
 */
function checkRegistration() {
    global $css_classes;
    $fehlermeldung = "";
    if (!CheckEmailFormat($_REQUEST['email'])) {
        $css_classes['email'] = getValue('cfg_css_class_error');
        $fehlermeldung .= "Falsches Format E-Mail. ";
    } elseif (emailExists($_REQUEST['email'])) {
        $css_classes['email'] = getValue('cfg_css_class_error');
        $fehlermeldung .= "Diese E-Mail Adresse ist bereits vorhanden. ";
    }
    if (!CheckPasswordFormat($_REQUEST['password'])) {
        $css_classes['password'] = getValue('cfg_css_class_error');
        $fehlermeldung .= "Falsches Format Passwort. ";
    }
    if (!CheckPasswordCompare($_REQUEST['password'], $_REQUEST['password2'])) {
        $css_classes['password'] = getValue('cfg_css_class_error');
        $css_classes['password2'] = getValue('cfg_css_class_error');
        $fehlermeldung .= "Die beiden Passwörter stimmen nicht überein. ";
    }
    return $fehlermeldung;
}

/*
 * Prüft die Authorisierung eines Users und gibt die Id zurück, falls erfolgreich
 */
function checkLoginGetId() {
    // E-Mail ist ein Unique-Attribut in der DB, deshalb gibt Abfrage max. 1 Datensatz zurück
    $resultat = getUserDaten($_REQUEST['email']);
    if (empty($resultat)) {
        return 0;
        // Vergleich, ob beide Passwörter identisch
    } elseif (password_verify($_REQUEST['password'], $resultat['password'])) {
        return $resultat['id_user'];
    } else return 0;
}


?>
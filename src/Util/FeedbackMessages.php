<?php


namespace App\Util;


/**
 * Class FeedbackMessages
 * @package App\Util
 */
class FeedbackMessages
{

    const WRONG_DATA_TYPE = 'Falscher Dateityp, bitte laden Sie eine JSON-Datei hoch';
    const WRONG_ENCODING = 'Die Dateicodierung ist nicht UTF-8, bitte laden Sie eine gültige UTF-8-kodierte Datei';
    const MAX_DEPTH = 'Die maximale Stapeltiefe wurde überschritten';
    const INVALID_FORMAT = 'Ungültiger oder fehlerhafter JSON.';
    const CHAR_ERR_WRONG_ENCODED = 'Control character error, possibly incorrectly encoded';
    const SYNTAX_ERR_JSON = 'Syntaxfehler, fehlerhaftes JSON';
    const WRONG_CHAR_ENCODING = 'Fehlerhafte UTF-8-Zeichen, möglicherweise falsch codiert';
    const RECURSIVE_ERR = 'Eine oder mehrere rekursive Referenzen im zu codierenden Wert';
    const NAN_INF_ERR = 'Ein oder mehrere NAN- oder INF-Werte im zu codierenden Wert';
    const CAN_NOT_ENCODE = 'Es wurde ein Wert eines Typs angegeben, der nicht codiert werden kann';
    const UNKNOWN_ERR = 'Ein unbekannter JSON-Fehler ist aufgetreten';
}
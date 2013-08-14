<?php
/**
 * LineCounter: Counts lines of code in code files
 * https://github.com/larukedi/linecounter/
 *
 * Licensed under the MIT License
 *
 * @link        http://github.com/larukedi/linecounter for the canonical source repository
 * @copyright   Copyright (c) 2010-2013 Eser Ozvataf. (http://eser.ozvataf.com/)
 * @license     https://github.com/larukedi/linecounter/blob/master/LICENSE - MIT License
 */

namespace Scabbia\LineCounter;

use Scabbia\LineCounter\IoHelper;

/**
 * Scabbia\LineCounter: LineCounter Class
 *
 * Counts lines of code in code files
 */
class LineCounter
{
    /**
     * Executes the counting.
     *
     * @param $uPath        string      The path
     */
    public function exec($uPath)
    {
        $tFiles = IoHelper::glob($uPath, "*.php", IoHelper::GLOB_FILES|IoHelper::GLOB_RECURSIVE);

        foreach ($tFiles as $tFile) {
            $this->countFile($tFile);
        }
    }

    /**
     * @param $uPath        string      The path
     */
    public function countFile($uPath)
    {
        // echo $uPath, PHP_EOL;
        // echo str_repeat("-",strlen($uPath)), PHP_EOL;
        // echo PHP_EOL;

        $tFileContents = file_get_contents($uPath);
        $tTokens = token_get_all($tFileContents);

        $tPrevious = null;
        $tNewUsed = false;
        $tCount = 0;

        foreach ($tTokens as $tToken) {
            if (!is_array($tToken)) {
                if ($tPrevious === T_STRING && $tToken === '(' && !$tNewUsed) {
                    $tCount++;
                } elseif ($tToken === ';') {
                    $tNewUsed = false;
                }
                // echo $tToken;

                $tPrevious = null;
            } else {
                if (
                    $tToken[0] === T_AND_EQUAL ||
                    $tToken[0] === T_ARRAY ||
                    // $tToken[0] === T_BOOLEAN_AND ||
                    // $tToken[0] === T_BOOLEAN_OR ||
                    $tToken[0] === T_BREAK ||
                    $tToken[0] === T_CASE ||
                    $tToken[0] === T_CATCH ||
                    $tToken[0] === T_CLASS ||
                    $tToken[0] === T_CLONE ||
                    // $tToken[0] === T_COMMENT ||
                    $tToken[0] === T_CONCAT_EQUAL ||
                    $tToken[0] === T_CONST ||
                    $tToken[0] === T_CONTINUE ||
                    $tToken[0] === T_DEC ||
                    $tToken[0] === T_DECLARE ||
                    $tToken[0] === T_DEFAULT ||
                    $tToken[0] === T_DIV_EQUAL ||
                    // T_DOC_COMMENT ||
                    $tToken[0] === T_DO ||
                    $tToken[0] === T_DOUBLE_ARROW ||
                    $tToken[0] === T_ECHO ||
                    $tToken[0] === T_ELSE ||
                    $tToken[0] === T_ELSEIF ||
                    $tToken[0] === T_EMPTY ||
                    $tToken[0] === T_EVAL ||
                    $tToken[0] === T_EXIT ||
                    $tToken[0] === T_FOR ||
                    $tToken[0] === T_FOREACH ||
                    $tToken[0] === T_FUNCTION ||
                    $tToken[0] === T_GLOBAL ||
                    $tToken[0] === T_GOTO ||
                    $tToken[0] === T_HALT_COMPILER ||
                    $tToken[0] === T_IF ||
                    $tToken[0] === T_INC ||
                    $tToken[0] === T_INCLUDE ||
                    $tToken[0] === T_INCLUDE_ONCE ||
                    $tToken[0] === T_INSTANCEOF ||
                    $tToken[0] === T_INSTEADOF ||
                    $tToken[0] === T_INTERFACE ||
                    $tToken[0] === T_ISSET ||
                    $tToken[0] === T_IS_EQUAL ||
                    $tToken[0] === T_IS_GREATER_OR_EQUAL ||
                    $tToken[0] === T_IS_IDENTICAL ||
                    $tToken[0] === T_IS_NOT_EQUAL ||
                    $tToken[0] === T_IS_NOT_IDENTICAL ||
                    $tToken[0] === T_IS_SMALLER_OR_EQUAL ||
                    $tToken[0] === T_LIST ||
                    // $tToken[0] === T_LOGICAL_AND ||
                    // $tToken[0] === T_LOGICAL_OR ||
                    // $tToken[0] === T_LOGICAL_XOR ||
                    $tToken[0] === T_MINUS_EQUAL ||
                    // $tToken[0] === T_ML_COMMENT ||
                    $tToken[0] === T_MOD_EQUAL ||
                    $tToken[0] === T_MUL_EQUAL ||
                    $tToken[0] === T_NAMESPACE ||
                    $tToken[0] === T_NEW ||
                    $tToken[0] === T_OR_EQUAL ||
                    $tToken[0] === T_PLUS_EQUAL ||
                    $tToken[0] === T_PRINT ||
                    $tToken[0] === T_REQUIRE ||
                    $tToken[0] === T_REQUIRE_ONCE ||
                    $tToken[0] === T_RETURN ||
                    $tToken[0] === T_SL ||
                    $tToken[0] === T_SL_EQUAL ||
                    $tToken[0] === T_SR ||
                    $tToken[0] === T_SR_EQUAL ||
                    // $tToken[0] === T_START_HEREDOC ||
                    $tToken[0] === T_SWITCH ||
                    $tToken[0] === T_THROW ||
                    $tToken[0] === T_TRAIT ||
                    $tToken[0] === T_UNSET ||
                    $tToken[0] === T_USE ||
                    $tToken[0] === T_WHILE ||
                    $tToken[0] === T_XOR_EQUAL ||
                    // $tToken[0] === T_YIELD ||
                    false
                ) {
                    $tCount++;

                    if ($tToken[0] === T_NEW) {
                        $tNewUsed = true;
                    }
                }
                // echo '(' . token_name($tToken[0]) . ')';
                // echo $tToken[1];

                $tPrevious = $tToken[0];
            }
        }

        // echo PHP_EOL;
        // echo PHP_EOL;
        echo $uPath, '=', $tCount, PHP_EOL;
    }
}

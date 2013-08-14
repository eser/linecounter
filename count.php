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

require __DIR__ . "/src/Scabbia/LineCounter/IoHelper.php";
require __DIR__ . "/src/Scabbia/LineCounter/LineCounter.php";

$tLineCounter = new Scabbia\LineCounter\LineCounter();
$tLineCounter->exec('.');

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

/**
 * Scabbia\LineCounter: IoHelper Class
 *
 * Performs some basic I/O operations
 */
class IoHelper
{
    /**
     * @var int none
     */
    const GLOB_NONE = 0;
    /**
     * @var int recursive
     */
    const GLOB_RECURSIVE = 1;
    /**
     * @var int files
     */
    const GLOB_FILES = 2;
    /**
     * @var int directories
     */
    const GLOB_DIRECTORIES = 4;
    /**
     * @var int just names
     */
    const GLOB_JUSTNAMES = 8;


    /**
     * Searches the file system and returns the set of files match given credentials.
     *
     * @param string      $uPath            the path will be searched
     * @param string|null $uFilter          the pattern
     * @param int         $uOptions         the flags
     * @param string      $uRecursivePath   the path will be concatenated (recursive)
     * @param array       $uArray           the results array (recursive)
     *
     * @return array|bool the set of files
     */
    public static function glob(
        $uPath,
        $uFilter = null,
        $uOptions = self::GLOB_FILES,
        $uRecursivePath = "",
        array &$uArray = []
    ) {
        $tPath = rtrim(strtr($uPath, "\\", "/"), "/") . "/";
        $tRecursivePath = $tPath . $uRecursivePath;

        // if (file_exists($tRecursivePath)) {
        try {
            $tDir = new \DirectoryIterator($tRecursivePath);

            foreach ($tDir as $tFile) {
                $tFileName = $tFile->getFilename();

                if ($tFileName[0] === ".") { // $tFile->isDot()
                    continue;
                }

                if ($tFile->isDir()) {
                    $tDirectory = $uRecursivePath . $tFileName . "/";

                    if (($uOptions & self::GLOB_DIRECTORIES) > 0) {
                        $uArray[] = (($uOptions & self::GLOB_JUSTNAMES) > 0) ? $tDirectory : $tPath . $tDirectory;
                    }

                    if (($uOptions & self::GLOB_RECURSIVE) > 0) {
                        self::glob(
                            $tPath,
                            $uFilter,
                            $uOptions,
                            $tDirectory,
                            $uArray
                        );
                    }

                    continue;
                }

                if (($uOptions & self::GLOB_FILES) > 0 && $tFile->isFile()) {
                    if ($uFilter === null || fnmatch($uFilter, $tFileName)) {
                        $uArray[] = (($uOptions & self::GLOB_JUSTNAMES) > 0) ?
                            $uRecursivePath . $tFileName :
                            $tRecursivePath . $tFileName;
                    }

                    continue;
                }
            }

            return $uArray;
        } catch (\Exception $tException) {
            // echo $tException->getMessage();
        }
        // }

        $uArray = false;

        return $uArray;
    }
}

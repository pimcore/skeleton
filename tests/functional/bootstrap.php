<?php

// We want to use the global bootstrap, but customize the setup a bit to run tests with a larger scope.
require_once dirname(__DIR__) . '/bootstrap.php';

// Let tests believe that the process is executed as a console application.
// This helps process manager bundle from elements handle shutdown of the testsuite situation properly.
const PIMCORE_CONSOLE = true;

<?php

// We want to use the global bootstrap, but customize the setup a bit for running a wider-scope tests.
require_once dirname(__DIR__) . '/bootstrap.php';

// Let tests believe that the process is executed as a console application.
// This helps process manager bundle from elements handle shutdown of the testsuite situation properly.
const PIMCORE_CONSOLE = true;

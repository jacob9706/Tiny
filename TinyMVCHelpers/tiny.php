<?php

$arguments = array(
	"--help",
	"new-project <projectName>"
);

if ($argc < 2) {
    echo 'You must supply an argument. For help use --help\r\n';
    exit();
} elseif ($argv[1] == "--help") {
	foreach ($arguments as $argument) {
		echo $argument . "\r\n";
	}
} elseif ($argc > 2) {
	if ($argv[1] == "new-project") {
		echo "Creating new project\r\n";
		$cplocation = getcwd();
		$docloc = dirname(__FILE__);
		$success = shell_exec("cp -r " . $docloc . "/TinyProjectOutline " . $cplocation . " 2>&1");
		$success1 = shell_exec("mv " . $cplocation . "/TinyProjectOutline " . $argv[2] . " 2>&1");

		if ($success == NULL && $success1 == NULL) {
			echo "Created Project \r\n";
		} else {
			echo "Did not create project. Might already exist or TinyProjectOutline folder does not exist in directory with tiny.php scritp\r\n";
		}
	}	
}
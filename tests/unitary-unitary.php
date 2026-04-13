<?php

use MaplePHP\Unitary\{Config\TestConfig, Expect, TestCase};
use MaplePHP\Blunder\Exceptions\BlunderSoftException;

$config = TestConfig::make()->withName("unitary");


group($config->withSubject("Assert validations"), function (TestCase $case) {

    $case->validate("HelloWorld", function(Expect $inst) {
        assert($inst->isEqualTo("HelloWorld")->isValid(), "Assert has failed");
    });
    assert(1 === 1, "Assert has failed");

});

group($config->withSubject("Tets old validation syntax"), function ($case) {
    $case->add("HelloWorld", [
        "isString" => [],
        "User validation" => function($value) {
            return $value === "HelloWorld";
        }
    ], "Is not a valid port number");

    $case->add("HelloWorld", [
        "isEqualTo" => ["HelloWorld"],
    ], "Failed to validate");
});

group($config->withSubject("Test json validation"), function(TestCase $case) {

    $case->check(function(Expect $expect) {
        $expect->against('{"response":{"status":200,"message":"ok"}}')
	        ->isJson()
	        ->hasJsonValueAt("response.status", 200)
            ->assert();

    }, "Test json validation");

});
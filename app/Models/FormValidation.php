<?php

namespace App\Models;

use Exception;

class FormValidation {
    private $db;
    private $inputData;
    private $rules;
    private $errors = [];
    private $customMessages = [];

    public function __construct(Database $db, array $inputData)
    {
        $this->db = $db;
        $this->inputData = $inputData;
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function setMessages($customMessages) {
        $this->customMessages = $customMessages;
    }

    public function validate()
    {
        foreach ($this->rules as $field => $fieldRules) {
            $fieldRules = explode('|', $fieldRules);

            // Don't check nonrequired fields if they are not set
            if (!in_array('required', $fieldRules)) {
                if (!isset($this->inputData[$field])) {
                    continue;
                }
            }

            $this->validateField($field, $fieldRules);
        }
    }

    private function validateField(string $field, array $fieldRules)
    {
        usort($fieldRules, function ($firstRule, $secondRule) {
            if ($firstRule === 'required') {
                return -1;
            }

            return 1;
        });

        foreach ($fieldRules as $fieldRule) {
            $ruleSegments = explode(':', $fieldRule);

            $fieldRule = $ruleSegments[0];
            // $satisfier = $ruleSegments[1] ?? null;
            // $satisfier = isset($ruleSegments[1]) ? $ruleSegments[1] : null;

            if (isset($ruleSegments[1])) {
                $satisfier = $ruleSegments[1];
            } else {
                $satisfier = null;
            }

            try {
                $this->{$fieldRule}($field, $satisfier);
            } catch (Exception $exception) {
                // array_push($this->errors, $e->getMessage());
                // $this->errors[$field] = [];
                // array_push($this->errors[$field], $e->getMessage());

                if (isset($this->customMessages["$field.$fieldRule"])) {
                    $this->errors[$field][] = $this->customMessages["$field.$fieldRule"];
                } else {
                    $this->errors[$field][] = $exception->getMessage();
                }

                // $this->errors[$field][] = $this->customMessages["$field.$fieldRule"] ?? $exception->getMessage()

                if ($fieldRule === 'required') {
                    break;
                }
            }
        }
    }

    public function fails()
    {
        return count($this->errors) ? true : false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function required(string $field)
    {
        if (!isset($this->inputData[$field]) || empty($this->inputData[$field])) {
            $exception = new Exception("The $field field is required.");
            throw $exception;
        }
    }

    private function alnum(string $field) {
        if (!ctype_alnum($this->inputData[$field])) {
            throw new Exception("The $field may only contain letters and numbers.");
        }
    }

    private function min(string $field, string $satisfier) {
        if (strlen($this->inputData[$field]) < (int) $satisfier) {
            throw new Exception("The $field field must be at least $satisfier characters.");
        }
    }

    private function max(string $field, string $satisfier) {
        if (strlen($this->inputData[$field]) > (int) $satisfier) {
            throw new Exception("The $field field must be no more than $satisfier characters.");
        }
    }

    private function email(string $field) {
        if (!filter_var($this->inputData[$field], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Please provide a valid email");
        }
    }

    private function matches(string $field, string $satisfier) {
        if ($this->inputData[$field] !== $this->inputData[$satisfier]) {
            throw new Exception("Looks like you didn't repeat the $satisfier correctly.");
        }
    }

    private function between(string $field, $satisfier) {
        // $bounds = explode(',', $satisfier);
        // $lowerBound = $bounds[0];
        // $upperBound = $bounds[1];

        [ $lowerBound, $upperBound ] = explode(',', $satisfier);

        if ($this->inputData[$field] < $lowerBound || $this->inputData[$field] > $upperBound) {
            throw new Exception("Please choose a $field between $lowerBound and $upperBound");
        }
    }

    private function available(string $field, string $satisfier)
    {
        $query = $this->db->table($satisfier)->where($field, '=', $this->inputData[$field]);

        if ($query->count()) {
            throw new Exception("The {$field} is already taken.");
        }
    }
}

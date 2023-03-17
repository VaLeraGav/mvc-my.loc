<?php

namespace Core;

class Validator
{
    public array $rules;

    public array $cleanData;

    /**
     * Sets the rules
     *
     * @param  $rules
     * @return void
     */
    public function setRules($rules): void
    {
        $this->rules = $rules;
    }

    public function validate($data): array
    {
        $errors = [];

        $keyRules = array_keys($this->rules);
        $this->cleanData = $this->deletesUnusedFields($keyRules, $data);

        foreach ($this->cleanData as $field => $value) {
            $ruleFull = $this->rules[$field];
            $ruleByValue = explode('|', $ruleFull);
            $error = [];

            foreach ($ruleByValue as $rule) {
                $error[] = $this->callRule($rule, $field, $value);
            }
            $errors[$field] = $error;
        }
        return $this->cleanEmpty($errors);
    }

    /**
     * Удаляет поля в которых не установлены правила
     *
     * @param array $keyRules
     * @param array $data
     * @return array
     */
    private function deletesUnusedFields($keyRules, $data): array
    {
        return array_filter($data, fn($keyData) => in_array($keyData, $keyRules, true), ARRAY_FILTER_USE_KEY);
    }

    public function cleanEmpty($array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->cleanEmpty($array[$key]);
            }

            if (empty($array[$key])) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    private function checkAvailableRule($name): void
    {
        if (!method_exists(self::class, $name)) {
            throw new \Exception("The {$name} method is missing");
        }
    }

    private function callRule($rule, $field, $value): ?string
    {
        $ruleByParts = explode(':', $rule);
        $ruleName = $ruleByParts[0];

        $this->checkAvailableRule($ruleName);

        $callable = [self::class, $ruleName];

        if (strpos($rule, ':')) {
            $argument = $ruleByParts[1];

            if ($this->haveField($this->cleanData, $argument)) {
                $argumentField = $this->cleanData[$argument];
                $methodCall = call_user_func_array($callable, [$field, $value, $argumentField]);
            } else {
                $methodCall = call_user_func_array($callable, [$field, $value, $argument]);
            }
        } else {
            $methodCall = call_user_func_array($callable, [$field, $value]);
        }
        return $methodCall;
    }


    /**
     * Проверяет наличие поля в данных из запроса.
     * @param array $prepareData
     * @param string $rulesCondition
     * @return bool
     */
    public static function haveField($prepareData, $rulesCondition): bool
    {
        $res = array_filter($prepareData, function ($k) use ($rulesCondition) {
            return $k === $rulesCondition;
        }, ARRAY_FILTER_USE_KEY);

        return !empty($res);
    }

    /**
     * Правила
     * @return string
     */
    private static function require($field, $value): ?string
    {
        return empty($value) ? "The field \"$field\" must not be empty" : null;
    }

    private static function max($field, $value, $matchValue): ?string
    {
        return $matchValue < strlen($value) ? "The field \"$field\" must not be larger than $matchValue" : null;
    }

    private static function min($field, $value, $matchValue): ?string
    {
        return $matchValue > strlen($value) ? "The field \"$field\" must not be less than $matchValue" : null;
    }

    private static function unique($field, $value): ?string
    {
        // TODO: подключение к оперделенному методу
        $db = new \App\Models\UserModel();
        $dbData = $db->find($field, $value);

        return $dbData ? "This field  \"{$value}\" is already in use in another account" : null;
    }

    private static function match($field, $value, $matchValue): ?string
    {
        return $value !== $matchValue ? "Password and confirmation don't match" : null;
    }

    private static function email($field, $value): ?string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL) ?? preg_match('/@.+./', $value)) {
            return "The email was entered incorrectly";
        }
        return null;
    }

}
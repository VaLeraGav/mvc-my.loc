<?php

namespace Core;

class Validator
{
    public array $rules;

    public array $cleanData;

    public array $message = [
        'require' =>
            'The field :name must not be empty',
        'max' =>
            'The field :name must not be larger than :max',
        'min' =>
            'The field :name must not be less than :min',
        'unique' =>
            'This field :value is already in use in another account',
        'match' =>
            'Password and confirmation don\'t match',
        'email' =>
            'The email was entered incorrectly',
    ];

    /**
     * Sets the rules
     *
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function setRuleMessage($messError = [])
    {
        $this->message = array_merge($this->message, $messError);
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

        $callable = [$this, $ruleName];

        // вызов правила по количеству аргументов
        if (strpos($rule, ':')) {
            $argument = $ruleByParts[1];
            $methodCall = call_user_func_array($callable, [$ruleName, $field, $value, $argument]);
        } else {
            $methodCall = call_user_func_array($callable, [$ruleName, $field, $value]);
        }
        return $methodCall;
    }

    /**
     * Проверяет наличие поля в данных из запроса
     */
    public function haveField($prepareData, $rulesCondition): bool
    {
        $res = array_filter($prepareData, function ($k) use ($rulesCondition) {
            return $k === $rulesCondition;
        }, ARRAY_FILTER_USE_KEY);

        return empty($res);
    }

    /**
     * Правила
     */
    private function require($ruleName, $field, $value): ?string
    {
        $raw = $this->getRuleMessage($ruleName, $field);
        $str = $this->replaceLines($raw, [":name"], [$field]);
        return empty($value) ? $str : null;
    }

    private function unique($ruleName, $field, $value): ?string
    {
        // TODO: подключение к определенному методу
        $db = new \App\Models\UserModel();
        $dbData = $db->find($field, $value);

        $raw = $this->getRuleMessage($ruleName, $field);
        $str = $this->replaceLines($raw, [':value'], [$value]);
        return $dbData ? $str : null;
    }

    private function email($ruleName, $field, $value): ?string
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) ?? preg_match('/@.+./', $value)) {
            return null;
        }
        $raw = $this->getRuleMessage($ruleName, $field);
        // dpre($raw);
        $str = $this->replaceLines($raw);
        return $str;
    }

    private function max($ruleName, $field, $value, $matchValue): ?string
    {
        $raw = $this->getRuleMessage($ruleName, $field);
        $str = $this->replaceLines($raw, [':name', ':max'], [$field, $matchValue]);
        return $matchValue < strlen($value) ? $str : null;
    }

    private function min($ruleName, $field, $value, $matchValue): ?string
    {
        $raw = $this->getRuleMessage($ruleName, $field);
        $str = $this->replaceLines($raw, [':name', ':min'], [$field, $matchValue]);
        return $matchValue > strlen($value) ? $str : null;
    }

    private function match($ruleName, $field, $value, $matchValue): ?string
    {
        if ($this->haveField($this->cleanData, $matchValue)) {
            return "Неправильное имя поля для совпадения {$field}";
        }
        $argumentField = $this->cleanData[$matchValue];

        $raw = $this->getRuleMessage($ruleName, $field);
        $str = $this->replaceLines($raw);
        return $value !== $argumentField ? $str : null;
    }

    public function replaceLines($strMessRule, $search = [], $replace = [])
    {
        return str_replace($search, $replace, $strMessRule);
    }

    public function getRuleMessage($ruleName, $field)
    {
        if (!empty($this->message[$field]) && is_array($this->message[$field])) {
            if (empty($this->message[$field][$ruleName])) {
                return "У поля {$field} нет текста ошибки: {$ruleName}";
            }
            return $this->message[$field][$ruleName];
        }
        if (empty($this->message[$ruleName])) {
            return "Полe $field является пустым";
        }
        return $this->message[$ruleName];
    }

}
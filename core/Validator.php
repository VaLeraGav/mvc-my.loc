<?php

namespace Core;

class Validator
{
    use Rules;

    public array $rules;

    public array $cleanData;

    public array $message = [
        'require' =>
            'The field :name must not be empty',
        'english' =>
            'The field :name must in English',
        'cyrillic' =>
            'The field :name must be a Cyrillic',
        'numeric' =>
            'The field :name must be a number',
        'integer' =>
            'The field :name must be a integer',
        'max' =>
            'The field :name must not be larger than :max',
        'min' =>
            'The field :name must not be less than :min',
        'match' =>
            'Password and confirmation don\'t match',
        'email' =>
            'The email was entered incorrectly',
//        'unique' =>
//            'This field :value is already in use in another account',
    ];

    /**
     * Sets the rules
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

    /**
     * Удаляет пустые поля
     */
    private function cleanEmpty($array): array
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

    /**
     * Проверяет наличие поля в данных из запроса
     */
    private function haveField($prepareData, $rulesCondition): bool
    {
        $res = array_filter($prepareData, function ($k) use ($rulesCondition) {
            return $k === $rulesCondition;
        }, ARRAY_FILTER_USE_KEY);

        return empty($res);
    }

    private function replaceLines($strMessRule, $search = [], $replace = [])
    {
        return str_replace($search, $replace, $strMessRule);
    }

    private function getRuleMessage($ruleName, $field)
    {
        if (!empty($this->message[$field]) && is_array($this->message[$field])) {
            if (empty($this->message[$field][$ruleName])) {
                return "The {$field} field has no error text: {$ruleName}";
            }
            return $this->message[$field][$ruleName];
        }
        if (empty($this->message[$ruleName])) {
            return "The $field field is empty";
        }
        return $this->message[$ruleName];
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
        $strError = $this->getRuleMessage($ruleName, $field);

        // вызов правила по количеству аргументов
        if (strpos($rule, ':')) {
            $argument = $ruleByParts[1];
            $strMess = call_user_func_array($callable, [$strError, $field, $value, $argument]);
        } else {
            $strMess = call_user_func_array($callable, [$strError, $field, $value]);
        }
        return $strMess;
    }
}

trait Rules
{
    private function require($str, $field, $value): ?string
    {
        $str = $this->replaceLines($str, [":name"], [$field]);
        return empty($value) ? $str : null;
    }

    private function email($str, $field, $value): ?string
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) ?? preg_match('/@.+./', $value)) {
            return null;
        }
        $str = $this->replaceLines($str);
        return $str;
    }

    private function max($str, $field, $value, $matchValue): ?string
    {
        $str = $this->replaceLines($str, [':name', ':max'], [$field, $matchValue]);
        return $matchValue < strlen($value) ? $str : null;
    }

    private function min($str, $field, $value, $matchValue): ?string
    {
        $str = $this->replaceLines($str, [':name', ':min'], [$field, $matchValue]);
        return $matchValue > strlen($value) ? $str : null;
    }

    private function match($str, $field, $value, $matchValue): ?string
    {
        if ($this->haveField($this->cleanData, $matchValue)) {
            return "Неправильное имя поля для совпадения {$field}";
        }
        $argumentField = $this->cleanData[$matchValue];
        $str = $this->replaceLines($str);
        return $value !== $argumentField ? $str : null;
    }

    // доработать
    private function english($str, $field, $value): ?string
    {
        $str = $this->replaceLines($str, [":name"], [$field]);
        return preg_match('/[^A-Za-z0-9]/', $value) ? $str : null;
    }

    // доработать
    private function numeric($str, $field, $value): ?string
    {
        $str = $this->replaceLines($str, [":name"], [$field]);
        return preg_match('/[^0-9]/', $value) ? $str : null;
    }

    // доработать
    private function cyrillic($str, $field, $value): ?string
    {
        $str = $this->replaceLines($str, [":name"], [$field]);
        return !preg_match('/[^а-яё0-9]/iu', $value) ? $str : null;
    }

    private function integer($str, $field, $value): ?string
    {
        $str = $this->replaceLines($str, [":name"], [$field]);
        if (!is_numeric($value)) {
            return $str;
        }
        $value = $value * 1;
        return !is_int($value) ? $str : null;
    }

//    private function unique($str, $field, $value): ?string
//    {
//        $db = new \App\Models\UserModel();
//        $dbData = $db->find($field, $value);
//        $str = $this->replaceLines($raw, [':value'], [$value]);
//        return $dbData ? $str : null;
//    }

}

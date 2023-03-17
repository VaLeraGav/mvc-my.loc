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
            'The field :name must not be less than :mix',
        'unique' =>
            'This field :value is already in use in another account',
        'match' =>
            'Password and confirmation don\'t match',
        'email' =>
            'The email was entered incorrectly'
    ];

    /**
     * Sets the rules
     *
     */
    public function setRules($rules)
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
     * Проверяет наличие поля в данных из запроса
     */
    public function haveField($prepareData, $rulesCondition): bool
    {
        $res = array_filter($prepareData, function ($k) use ($rulesCondition) {
            return $k === $rulesCondition;
        }, ARRAY_FILTER_USE_KEY);

        return !empty($res);
    }

    /**
     * Правила
     */
    private function require($field, $value): ?string
    {
        return empty($value) ? $this->getMessage('require', $field) : null;
    }

    private function max($field, $value, $matchValue): ?string
    {
        return $matchValue < strlen($value) ? $this->getMessage('max', $field, $matchValue) : null;
    }

    private function min($field, $value, $matchValue): ?string
    {
        return $matchValue > strlen($value) ? $this->getMessage('min', $field, $matchValue) : null;
    }

    private function unique($field, $value): ?string
    {
        // TODO: подключение к оперделенному методу
        $db = new \App\Models\UserModel();
        $dbData = $db->find($field, $value);

        return $dbData ? $this->getMessage('unique', $value) : null;
    }

    private function match($field, $value, $matchValue): ?string
    {
        return $value !== $matchValue ? $this->getMessage('match') : null;
    }

    private function email($field, $value): ?string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL) ?? preg_match('/@.+./', $value)) {
            return $this->getMessage('email');
        }
        return null;
    }

    public function getMessage($name, ...$params)
    {
        // мерзость
        switch ($name) {
            case 'require':
                $str = str_replace([":name"], [$params[0]], $this->message['require']);
                break;
            case 'min':
                $str = str_replace([':name', ':mix'], [$params[0], $params[1]], $this->message['min']);
                break;
            case 'max':
                $str = str_replace([':name', ':max'], [$params[0], $params[1]], $this->message['max']);
                break;
            case 'unique':
                $str = str_replace([':value'], [$params[0]], $this->message['unique']);
                break;
            case 'match':
                $str = $this->message['match'];
                break;
            case 'email':
                $str = $this->message['email'];
                break;
            default:
                $str = 'Error';
        }
        return $str;
    }

//    public function setMessage($names)
//    {
//    }
//
//    public array $messages = [
//        'name' => [
//            'require' =>
//                'Имя не должно быть пустым',
//            'max' =>
//                'Имя не должно превышать 30 символов',
//            'min' =>
//                'Имя не должно быть меньше 1 символов',
//            'unique' =>
//                'Имя должно быть уникальным',
//        ]
//    ];

}
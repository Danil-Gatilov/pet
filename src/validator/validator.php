<?php


namespace App\validator;


class validator
{
    public array $errors = [];
    public array $data = [];
    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];
        $this->data = $data;

        foreach ($rules as $field => $fieldRules) {
            $rules = $fieldRules;

            foreach ($rules as $rule) {
                $rule = explode(':' , $rule);

                $ruleName = $rule[0];
                $ruleValue = $rule[1] ?? null;

                $error = $this->validateRule($field, $ruleName, $ruleValue);

                if (! empty($error)) {
                    $this->errors[$field][] = $error;
                }
            }
        }
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function validateRule(string $key, string $ruleName, $ruleValue): ?string
    {
           $field = $this->data[$key];

           switch ($ruleName) {
               case 'required':
                   if (empty($field)) {
                       return "field is required";
                   }
                   break;
               case 'min':
                   if (mb_strlen($field) < $ruleValue) {
                       return "field must be at least $ruleValue characters";
                   }
                   break;
               case 'max':
                   if (mb_strlen($field) > $ruleValue) {
                       return "field $key must be max $ruleValue characters";
                   }
                   break;
               case 'email':
                   if (! filter_var($field, FILTER_VALIDATE_EMAIL)) {
                       return "field must be type email";
                   }
                   break;
           }
           return null;
    }
}



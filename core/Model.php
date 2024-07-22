<?php

namespace PHPFramework;

class Model
{
    public string $table = '';
    public array $fillable = [];
    public array $attributes = [];
    public array $rules = [];
    protected array $errors = [];
    protected array $data_items = [];
    protected array $rules_list = ['required', 'int', 'min', 'max', 'email', 'unique', 'file', 'ext', 'size', 'match'];
    protected array $messages = [
        'required' => 'The :fieldname: field is required.',
        'int' => 'The :fieldname: field must be an integer.',
        'min' => 'The :fieldname: field must be a minimum :rulevalue: characters.',
        'max' => 'The :fieldname: field must be a maximum :rulevalue: characters.',
        'email' => 'The :fieldname: field must be email type.',
        'unique' => 'The :fieldname: is already exists',
        'file' => 'The :fieldname: is required',
        'ext' => 'File :fieldname: does not match. Allowed :rulevalue:.',
        'size' => 'File :fieldname: is too large. Allowed :rulevalue: bytes.',
        'match' => 'The :fieldname: must match with :rulevalue: field.',
    ];

    public function save(): false|string
    {
        // insert into table (`title`, `content`) values (:title, :content)
        // prepare fields data
        $fields_keys = array_keys($this->attributes);
        $fields = array_map(fn ($field) => "`{$field}`", $fields_keys);
        $fields = implode(", ", $fields);

        // prepare values data
        $values_placeholder = array_map(fn ($value) => ":{$value}", $fields_keys);
        $values = implode(", ", $values_placeholder);
        $query = "INSERT INTO {$this->table} ($fields) VALUES ($values)";
        db()->query($query, $this->attributes);
        return db()->getInsertId();
    }

    public function update()
    {
        // update table set `table`=:table, `content`=:content where `id`=:id

        if (!isset($this->attributes['id'])) {
            return false;
        }

        $fields = '';
        foreach ($this->attributes as $key => $value) {
            if ($key === 'id') {
                continue;
            }

            $fields .= "`{$key}`=:{$key},";
        }
        $fields = rtrim($fields, ",");

        $query = "UPDATE {$this->table} SET {$fields} WHERE `id`=:id";
        db()->query($query, $this->attributes);
        return db()->rowCount();
    }

    public function loadData(): void
    {
        $data = request()->getData();
        foreach ($this->fillable as $value) {
            if (isset($data[$value])) {
                $this->attributes[$value] = $data[$value];
            } else {
                $this->attributes[$value] = '';
            }
        }
    }

    public function delete(int $id): int
    {
        db()->query("DELETE FROM {$this->table} WHERE `id` = ?", [$id]);
        return db()->rowCount();
    }

    public function validate($data = [], $rules = []): bool
    {

        if (!$data) {
            $data = $this->attributes;
        }

        if (!$rules) {
            $rules = $this->rules;
        }

        $this->data_items = $data;

        foreach ($data as $fieldname => $value) {
            if (isset($rules[$fieldname])) {
                $this->check([
                    'fieldname' => $fieldname,
                    'value' => $value,
                    'rules' => $rules[$fieldname],
                ]);
            }
        }
        return !$this->hasErrors();
    }

    protected function check(array $field): void
    {
        foreach ($field['rules'] as $rule => $rule_value) {
            if (in_array($rule, $this->rules_list)) {
                if (!call_user_func_array([$this, $rule], [$field['value'], $rule_value])) {
                    $this->addError(
                        $field['fieldname'],
                        str_replace(
                            [':fieldname:', ':rulevalue:'],
                            [$field['fieldname'], $rule_value],
                            $this->messages[$rule]
                        )
                    );
                }
            }
        }
    }


    protected function addError($fieldname, $error): void
    {
        $this->errors[$fieldname][] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function listErrors()
    {
        $output = '<ul class="list-unstyled">';
        foreach ($this->errors as $field_error) {
            foreach ($field_error as $error) {
                $output .= "<li>{$error}</li>";
            }
        }
        $output .= '</ul>';
        return $output;
    }

    protected function required($value, $rule_value): bool
    {
        return !empty(trim($value));
    }

    protected function int($value, $rule_value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    protected function min($value, $rule_value): bool
    {
        return mb_strlen($value, 'UTF-8') >= $rule_value;
    }

    protected function max($value, $rule_value): bool
    {
        return mb_strlen($value, 'UTF-8') <= $rule_value;
    }

    protected function email($value, $rule_value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected function match($value, $rule_value): bool
    {
        return $value === $this->data_items[$rule_value];
    }

    protected function unique($value, $rule_value): bool
    {
        $data = explode(':', $rule_value);
        if (str_contains($data[1], ',')) {
            $data_fields = explode(',', $data[1]);
            return !(db()->query("SELECT {$data_fields[0]} FROM {$data[0]} WHERE {$data_fields[0]} = ? AND {$data_fields[1]} != ?", [$value, $this->data_items[$data_fields[1]]])->getColumn());
        }
        return !(db()->query("SELECT {$data[1]} FROM {$data[0]} WHERE {$data[1]} = ?", [$value])->getColumn());
    }

    protected function file($value, $rule_value): bool
    {
        if (isset($value['error']) && is_array($value['error'])) {
            foreach ($value['error'] as $error) {
                if ($error !== 0) {
                    return false;
                }
            }
        }

        if (isset($value['error']) && $value['error'] !== 0) {
            return false;
        }

        return true;
    }

    protected function ext($value, $rule_value): bool
    {
        if (is_array($value['name'])) {
            if (empty($value['name'][0])) {
                return true;
            }

            for ($i = 0; $i < count($value['name']); $i++) {
                $file_ext = get_file_ext($value['name'][$i]);
                $allowed_exts = explode('|', $rule_value);
                if (!in_array($file_ext, $allowed_exts)) {
                    return false;
                }
            }

            return true;
        }

        if (empty($value['name'])) {
            return true;
        }

        $file_ext = get_file_ext($value['name']);
        $allowed_exts = explode('|', $rule_value);
        return in_array($file_ext, $allowed_exts);
    }

    protected function size($value, $rule_value): bool
    {
        if (is_array($value['size']) && !empty($value['size'])) {
            foreach ($value['size'] as $size) {
                if ($size > $rule_value) {
                    return false;
                }
            }

            return true;
        }

        if (empty($value['size'])) {
            return true;
        }

        return $value['size'] <= $rule_value;
    }
}

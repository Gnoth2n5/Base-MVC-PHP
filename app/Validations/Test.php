<?php

namespace App\Validations;

use Rakit\Validation\Validator;

class Test {
    
    protected $validator;
    protected $data;
    protected $rules;
    protected $messages;

    public function __construct(array $data){
        $this->validator = new Validator;
        $this->data = $data;
        $this->rules = $this->rules();
        $this->messages = $this->messages();
    }

    // Định nghĩa quy tắc xác thực
    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    // Định nghĩa thông báo lỗi
    public function messages(): array
    {
        return [
            'name:required' => 'Tên không được để trống',
        ];        
    }

    // Phương thức validate chạy xác thực
    public function validate()
    {
        $validation = $this->validator->make($this->data, $this->rules, $this->messages);
        $validation->validate();

        if ($validation->fails()) {
            return $validation->errors()->firstOfAll();
        }

        return true;
    }

}

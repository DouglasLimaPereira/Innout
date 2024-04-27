<?php

class User extends Model {
    protected static $tableName = 'users';
    protected static $collumns = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin'
    ];

    public static function getActiveUsersCount() {
        return static::GetCount([
            'raw' => "end_date IS NULL"
        ]);
    }

    public function insert()
    {
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;
        if(!$this->end_date) $this->end_date = null;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::insert();
    }
    
    public function update()
    {
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;
        if(!$this->end_date) $this->end_date = null;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::update();
    }

    private function validate(){
        $errors = [];

        if (!$this->name) {
            $errors['name'] = 'O campo Nome precisa ser informado';
        }
        if (!$this->email) {
            $errors['email'] = 'O campo E-mail precisa ser informado';
        }
        if (!$this->password) {
            $errors['password'] = 'O campo Senha precisa ser informado';
        }
        if (!$this->confirm_password) {
            $errors['confirm_password'] = 'O campo confirmação de Senha precisa ser informado';
        }
        if (!$this->start_date) {
            $errors['start_date'] = 'O campo Data de admissão precisa ser informado';
        }elseif(!DateTime::createFromFormat('Y-m-d', $this->start_date)) {
            $errors['start_date'] = 'A Data de admissão deve seguir o padrão dd/mm/aaaa';
        }
        if (($this->end_date) && (!DateTime::createFromFormat('Y-m-d', $this->end_date))) {
            $errors['start_date'] = 'A Data de demissão deve seguir o padrão dd/mm/aaaa';
        }
        if (($this->password) &&  ($this->confirm_password) && ($this->password !== $this->confirm_password)) {
            $errors['confirm_password'] = 'As senhas informadas são diferentes';
            $errors['password'] = 'As senhas informadas são diferentes';
        }
        if (count($errors) > 0) {
            throw new ValidateException($errors, 'Erro de validação dos campos abaixo');
        }
    }
}
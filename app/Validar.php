<?php
class Validation
{
    protected $_atributos;
    protected $_error;
    public $mensaje;

    public function rules($rule = array(), $data)
    {

        if (!is_array($rule)) {
            $this->mensaje = "The rules must be in array format!";
            return $this;
        }
        foreach ($rule as $key => $rules) {
            $reglas = explode(',', $rules['regla']);
            if (array_key_exists($rules['name'], $data)) {
                foreach ($data as $indice => $valor) {
                    if ($indice === $rules['name']) {
                        foreach ($reglas as $clave => $valores) {
                            $validator = $this->_getInflectedName($valores);
                            if (!is_callable(array(
                                $this,
                                $validator
                            ))) {
                                throw new BadMethodCallException("The method was not found!");
                            }
                            $respuesta = $this->$validator($rules['name'], $valor);
                        }
                        break;
                    }
                }
            } else {

                $this->mensaje[$rules['name']] = "The field is not within the validation rule or on the form.";
            }
        }
        if (!empty($this->mensaje)) {
            return $this;
        } else {
            return true;
        }
    }

    private function _getInflectedName($text)
    {
        $validator = "";
        $_validator = preg_replace('/[^A-Za-z0-9]+/', ' ', $text);
        $arrayValidator = explode(' ', $_validator);
        if (count($arrayValidator) > 1) {
            foreach ($arrayValidator as $key => $value) {
                if ($key == 0) {
                    $validator .= "_" . $value;
                } else {
                    $validator .= ucwords($value);
                }
            }
        } else {
            $validator = "_" . $_validator;
        }

        return $validator;
    }

    protected function _noEmpty($campo, $valor)
    {
        if ($valor != '') {
            return true;
        } else {
            $this->mensaje[$campo][] = `<div class='alert alert-danger' role='danger'>Please, fill all fields. <i class='fas fa-times' id='closeAlertServer'></i></div>`;
            return false;
        }
    }

    protected function _numeric($campo, $valor)
    {
        if (is_numeric($valor)) {
            return true;
        } else {
            $this->mensaje[$campo][] = "The field must be numeric.";
            return false;
        }
    }

    protected function _email($campo, $valor)
    {
        if (preg_match("/^[a-z]+([\.]?[a-z0-9_-]+)*@[a-z]+([\.-]+[a-z0-9]+)*\.[a-z]{2,}$/", $valor)) {
            return true;
        } else {
            $this->mensaje[$campo][] = `<div class='alert alert-danger' role='danger'>The email field of being in the email format user@domain.com <i class='fas fa-times' id='closeAlertServer'></i></div>`;
            return false;
        }
    }
    protected function _password($campo, $valor)
    {
        if (preg_match("/^(?=.*\d.*\d)[0-9A-Za-z]{6,}$/", $valor)) {
            return true;
        } else {
            $this->mensaje[$campo][] = `<div class='alert alert-danger' role='danger'>Incorrect password format.<i class='fas fa-times' id='closeAlertServer'></i></div>`;
            return false;
        }
    }
}

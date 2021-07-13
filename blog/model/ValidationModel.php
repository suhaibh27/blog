<?php
class ValidationModel
{
    private function _isNumeric($value)
    {
        return is_numeric($value);
    }
    private function _isFilled($value)
    {
        return !empty($value);
    }
    public function handler($values, $actions, $returnPath)
    {
        foreach($values as $key => $value)
        {
            $action = $actions[$key];
            if(!$this->$action($value))
            {
                header("location:$returnPath&errorMsg=Error");
                return false;
            }
        }
        return true;
    }
}
?>
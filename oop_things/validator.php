<?php
class YearMonthValidator {
    private $year;
    private $month;

    public function __construct($year, $month) {
        $this->year = $year;
        $this->month = $month;
    }

    public function validate() {
        if (!is_numeric($this->year) || strlen($this->year) > 4) {
            return false; // Год не является числом или превышает 4 символа
        }

        if (!is_numeric($this->month) || $this->month < 1 || $this->month > 12) {
            return false; // Месяц не является числом или не в диапазоне от 1 до 12
        }

        return true; // Валидация успешна
    }
}
?>
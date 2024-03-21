
<?php

    class AmountValue implements Stringable {

        public readonly string $value;

        public function __construct(AmountValue|string|int|float $value)
        {

            if($value instanceof static){
                $value = $value->value;
            }

            if(!is_numeric($value)){
                throw new InvalidArgumentException(

                    "Значение [{$value}] должно быть числом",

                );
            }

            $this->value = (string) $value;
        }

        public function add(AmountValue|string|int|float $number = 0, int $scale = null): static
        {
            $number = new static($number);

            return new static(bcadd($this->value, $number->value, $scale));
        }

        public function sub(AmountValue|string|int|float $number = 0, int $scale = null): static
        {
            $number = new static($number);

            return new static(bcsub($this->value, $number->value, $scale));
        }

        public function mul(AmountValue|string|int|float $number = 0, int $scale = null): static
        {
            $number = new static($number);

            return new static(bcmul($this->value, $number->value, $scale));
        }

        public function div(AmountValue|string|int|float $number = 0, int $scale = null): static
        {
            $number = new static($number);

            return new static(bcdiv($this->value, $number->value, $scale));
        }

        public function eq(AmountValue|string|int|float $number = 0, int $scale = null): bool
        {
            $number = new static($number);

            $result = bccomp($this->value, $number->value, $scale);

            return ($result === 0);
        }


        //больше ли
        public function gt(AmountValue|string|int|float $number = 0, int $scale = null): bool
        {
            $number = new static($number);

            $result = bccomp($this->value, $number->value, $scale);

            return ($result === 1);
        }

        //больше или равно
        public function gte(AmountValue|string|int|float $number = 0, int $scale = null): bool
        {
            return $this->eq($number, $scale) || $this->gt($number, $scale);
        }

        public function lt(AmountValue|string|int|float $number = 0, int $scale = null): bool
        {
            $number = new static($number);

            $result = bccomp($this->value, $number->value, $scale);

            return ($result === -1);
        }

        //больше или равно
        public function lte(AmountValue|string|int|float $number = 0, int $scale = null): bool
        {
            return $this->eq($number, $scale) || $this->lt($number, $scale);
        }

        public function __toString() : string
        {
            return $this->value;
        }

    }

    $foo = new AmountValue('13');
    

    // var_dump($foo->value);

    function bar(AmountValue $value){
        $foo2 = new AmountValue('3');
        // var_dump($value);
        var_dump($value->gte($foo2));
    }

    bar($foo);


<?php

namespace App\Validator;

use App\Repository\TaxrefRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Entity\Taxref;

class SpeciesValidator extends ConstraintValidator
{

    /**
     * @var TaxrefRepository
     */
    private $taxrefRepository;

    public function __construct(TaxrefRepository $taxrefRepository)
    {

        $this->taxrefRepository = $taxrefRepository;
    }
    
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof Taxref){
            $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }

}
<?php

namespace PothenEsxes;

use PothenEsxes\Exceptions\InvalidFieldException;
use PothenEsxes\Messages\Messages;

class AithmaFieldValidator
{
    /**
     * @param string $requestId /^A\d{21}$/
     * @param int $requestType /^[12]$/
     * @param string $referenceDate Y-m-d <=now()
     * @param string $afm /^.{9}$/
     * @param string $name
     * @param string $surname
     * @param string $fatherName
     * @param string $motherName
     * @param string $birthDate Y-m-d
     */
    public function __construct(
        private Messages $messages,
        private string   $requestId='',
        private int      $requestType=0,
        private string   $referenceDate='',
        private string   $afm='',
        private string   $name='',
        private string   $surname='',
        private string   $fatherName='',
        private string   $motherName='',
        private string   $birthDate=''
    )
    {
    }

    public function validate(): bool
    {
        try {
            $this->ValidateRequestId();
            $this->ValidateRequestType();
            $this->ValidateReferenceDate();
            $this->ValidateAfm();
            $this->ValidateName();
            $this->ValidateSurname();
            $this->ValidateBirthDate();
            return true;
        } catch (InvalidFieldException $exception) {
            $message = $this->messages->getMessageByCode(10, ['INVALID_FIELD' => $exception->getMessage()]);
            throw new \Exception($message, 10);
        }
    }

    protected function validateRequestId(): void
    {
        if (empty($this->requestId)) {
            throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['requestIDEmpty']);
        }
        $pattern = '/^A\d{21}$/';
        if (!preg_match($pattern, $this->requestId)) {
            throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['requestIDEmpty']);
        }
    }

    protected function validateRequestType(): void
    {
        if (empty($this->requestType)) {
            throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['requestTypeEmpty']);
        }
        $pattern = '/^[12]$/';
        if (!preg_match($pattern, $this->requestType)) {
            throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['requestTypeInvalid']);
        }
    }

    protected function validateReferenceDate(): void
    {
        if (empty($this->referenceDate)) throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['referenceDateEmpty']);
        $today = new \DateTime();
        $today->setTime(0, 0, 0);
        try {
            $referenceDate = \DateTime::createFromFormat('Y-m-d', $this->referenceDate);
            $errors = \DateTime::getLastErrors();
            if (empty($errors)) {
                $referenceDate->setTime(0, 0, 0);
                if ($referenceDate > $today) {
                    throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['referenceDateFuture']);
                }
            }
            if (!empty($errors)) {
                throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['referenceDateInvalid']);
            }
        } catch (\Exception $e) {
            throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['referenceDateInvalid']);
        }
    }

    protected function validateAfm(): void
    {
        if (empty($this->afm)) {
            throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['afmEmpty']);
        }
        $pattern = '/^.{9}$/';
        if (!preg_match($pattern, $this->afm)) {
            throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['afmInvalid']);
        }
    }

    protected function validateName(): void
    {
        if (empty($this->name)) {
            throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['nameEmpty']);
        }
    }

    protected function validateSurname(): void
    {
        if (empty($this->surname)) {
            throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['surnameEmpty']);
        }
    }

    protected function validateBirthDate(): void
    {
        if (empty($this->birthDate)) throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['birthDateEmpty']);
        $today = new \DateTime();
        $today->setTime(0, 0, 0);
        try {
            $referenceDate = \DateTime::createFromFormat('Y-m-d', $this->birthDate);
            $errors = \DateTime::getLastErrors();
            if (empty($errors)) {
                $referenceDate->setTime(0, 0, 0);
                if ($referenceDate > $today) {
                    throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['birthDateInvalid']);
                }
            }
            if (!empty($errors)) {
                throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['birthDateInvalid']);
            }
        } catch (\Exception $e) {
            throw new InvalidFieldException($this->messages::AITHMA_FIELDS_ERRORS['birthDateInvalid']);
        }
    }
}
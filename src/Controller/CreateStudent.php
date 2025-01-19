<?php

declare(strict_types=1);

namespace Crud\Controller;

use Crud\Repository\StudentRepository;
use Crud\Template;
use Crud\Validation\StudentValidator;

class CreateStudent
{
    public function __construct(

        protected StudentValidator $studentValidator,
        private StudentRepository  $studentRepository,
        private Template           $template
    )
    {

    }

    public function __invoke(): string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;
            $validates = $this->studentValidator->validate($data);
            $saves = $this->studentRepository->save($data);

            if ($validates && $saves) {
                return $this->template->render('create_student_form.php', [
                    'success' => 'Student creation success!'
                ]);
            } else {
                return $this->template->render('create_student_form.php', [
                    'error' => 'Student creation failed!'
                ]);
            }
        } else {
            return $this->template->render('create_student_form.php');
        }
    }
}
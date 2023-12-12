<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;


class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index')]
    public function new(Request $request): Response
    {
        // createFormBuilder is a shortcut to get the "form factory"
        // and then call "createBuilder()" on it

        $form = $this->createFormBuilder()
            ->add('task', TextType::class, [
                'constraints' => new NotBlank(),
            ])
            ->add('dueDate', DateType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Type(\DateTime::class),
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // ... perform some action, such as saving the data to the database

            return $this->render('Home/index.html.twig', [ 'form' => $form->createView(), 'data' => $data, 'test' => 'plop']);
        }

        return $this->render('Home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
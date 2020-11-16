<?php

namespace App\Controller;

use App\Service\FileParserService;
use App\Service\ValidateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostcodeCheckController extends AbstractController
{
    /**
     * @Route("/postcode", name="app_postcode")
     * @param Request $request
     * @param ValidateService $validateService
     * @param FileParserService $fileParserService
     * @return Response
     */
    public function index(Request $request, ValidateService $validateService, FileParserService $fileParserService)
    {
        $form = $this->createFormBuilder()
            ->add('postcode', TextType::class, [
                'label'    => 'Enter postcode',
                'required' => true,
            ])
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data     = $form->getData();
            $postcode = $data['postcode'];

            $validPostCodes = $fileParserService->readFileAndConvertToArray('../data/m25Postcodes.md');
            if ($validateService->isPostCodeValid($validPostCodes, $postcode)) {
                $this->addFlash('success', 'SUCCESS - Postcode Within M25');
            } else {
                $this->addFlash('error', 'ERROR - Postcode Outside M25');
            }
        }

        return $this->render('postcode_check/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

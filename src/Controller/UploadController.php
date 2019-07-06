<?php

namespace App\Controller;

use App\Form\UploadType;
use App\Util\FeedbackFlashMessage;
use App\Util\JsonUploadService;
use App\Util\ValidationService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UploadController extends AbstractController
{
    /**
     * @Route("/upload", name="upload")
     *
     * @param Request             $request
     * @param JsonUploadService   $uploadService
     * @param ValidationService   $validationService
     * @param LoggerInterface     $logger
     *
     * @param TranslatorInterface $translator
     *
     * @return RedirectResponse|Response
     */
    public function index(
        Request $request,
        JsonUploadService $uploadService,
        ValidationService $validationService,
        LoggerInterface $logger,
        TranslatorInterface $translator
    )
    {
        $form = $this->createForm(UploadType::class);
        $form->handleRequest($request);

        // check if upload form is submitted und is valid
        if ($form->isSubmitted()) {
            try {
                /** @var UploadedFile $file */
                $file = $form['file']->getData();
                $result = $validationService->validate($file);

                //check if json file is validated
                if ($result === true && $form->isValid()) {
                    $data = file_get_contents($file);
                    $result = $uploadService->insertIntoDb($data);

                    //check if insertion into db was successful
                    if ($result === true) {

                        $this->addFlash('success', $translator->trans('json.success_insert'));
                        return $this->redirectToRoute('articles');
                    } else {

                        $this->addFlash('error', $result);
                        $logger->error($result);
                    }

                } else {
                    $this->addFlash('error', $result);
                    $logger->error($result);
                }
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
                $logger->error($e->getMessage());
            }
        }

        //render upload view
        return $this->render('upload/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

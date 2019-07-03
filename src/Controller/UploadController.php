<?php

namespace App\Controller;

use App\Form\UploadType;
use App\Util\JsonUploadService;
use App\Util\JsonValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    /**
     * @Route("/upload", name="upload")
     */
    public function index(
        Request $request,
        JsonUploadService $uploadService,
        JsonValidationService $validationService
    )
    {
        $form = $this->createForm(UploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($form->getData());
            /** @var UploadedFile $file */
            $file = $form['file']->getData();
//            dd($file);
//            $file = $data['file']->getClientOriginalName();
            $result = $validationService->validate($file);
            if ($result === true) {
                $data = file_get_contents($file);
                $result = $uploadService->insertIntoDb($data);
                if ($result === true) {
                   return $this->redirectToRoute('article');
                }
            } else {
                dd($result);
            }
//
          return $this->redirectToRoute('article');

//            var_dump();
//            dd($result);
//            die;
        }

        return $this->render('upload/index.html.twig', [
            'controller_name' => 'UploadController',
            'form' =>  $form->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Job;
use App\Form\JobType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    /**
     * Lists all job entities.
     *
     * @Route("/", name="job.list", methods="GET")
     *
     * @return Response
     */
    public function list(EntityManagerInterface $em) : Response
    {
        $categories = $em->getRepository(Category::class)->findWithActiveJobs();

        return $this->render('job/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Finds and displays a job entity.
     *
     * @Route("job/{id}", name="job.show", requirements={"id" = "\d+"})
     *
     * @Entity("job", expr="repository.findActiveJob(id)")
     *
     * @param Job $job
     *
     * @return Response
     */
    public function show(Job $job) : Response
    {
        return $this->render('job/show.html.twig', [
            'job' => $job,
        ]);
    }

    /**
     * Creates a new job entity
     *
     * @Route("/job/create", name="job.create", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param FileUploader $fileUploader
     *
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em, FileUploader $fileUploader) : Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($job);
            $em->flush();

            return $this->redirectToRoute('job.list');
        }

        return $this->render('job/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
